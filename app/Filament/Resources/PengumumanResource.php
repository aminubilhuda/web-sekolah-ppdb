<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengumumanResource\Pages;
use App\Models\Pengumuman;
use App\Traits\HasOptimizedResource;
use App\Traits\HasOptimizedFileUpload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Services\GeminiAIService;
use Filament\Notifications\Notification;

class PengumumanResource extends Resource
{
    use HasOptimizedResource;
    use HasOptimizedFileUpload;

    protected static ?string $model = Pengumuman::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Pengumuman';
    protected static ?string $modelLabel = 'Pengumuman';
    protected static ?string $pluralModelLabel = 'Pengumuman';
    protected static ?int $navigationSort = 16;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user']); // Eager loading dengan user
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('🤖 AI Writer')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('ai_topik')
                                    ->label('Topik Pengumuman')
                                    ->placeholder('Contoh: Libur semester dan jadwal ujian')
                                    ->helperText('Masukkan topik pengumuman')
                                    ->columnSpan(2),
                                Forms\Components\Select::make('ai_target')
                                    ->label('Target Audiens')
                                    ->options([
                                        'seluruh siswa' => 'Seluruh Siswa',
                                        'siswa kelas 10' => 'Siswa Kelas 10',
                                        'siswa kelas 11' => 'Siswa Kelas 11', 
                                        'siswa kelas 12' => 'Siswa Kelas 12',
                                        'guru dan staff' => 'Guru dan Staff',
                                        'orang tua' => 'Orang Tua',
                                        'masyarakat umum' => 'Masyarakat Umum',
                                    ])
                                    ->default('seluruh siswa')
                                    ->columnSpan(1),
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('generate_ai_pengumuman')
                                        ->label('✨ Generate AI')
                                        ->color('warning')
                                        ->icon('heroicon-o-sparkles')
                                        ->requiresConfirmation()
                                        ->modalHeading('Generate Pengumuman dengan AI')
                                        ->modalDescription('AI akan membantu menulis pengumuman berdasarkan topik dan target audiens.')
                                        ->action(function (array $data, Forms\Set $set, Forms\Get $get) {
                                            if (empty($data['ai_topik'])) {
                                                Notification::make()
                                                    ->title('Topik diperlukan')
                                                    ->body('Silakan masukkan topik pengumuman terlebih dahulu')
                                                    ->warning()
                                                    ->send();
                                                return;
                                            }

                                            try {
                                                $aiService = new GeminiAIService();
                                                
                                                // Generate judul jika belum ada
                                                if (empty($get('judul'))) {
                                                    $judulPrompt = "Buatkan judul pengumuman resmi untuk topik: {$data['ai_topik']}. Hanya berikan judulnya saja, maksimal 8 kata, formal.";
                                                    $generatedJudul = $aiService->generateContent($judulPrompt);
                                                    if ($generatedJudul) {
                                                        $set('judul', trim($generatedJudul));
                                                    }
                                                }

                                                // Generate konten pengumuman
                                                $aiParams = [
                                                    'judul' => $get('judul') ?: $data['ai_topik'],
                                                    'topik' => $data['ai_topik'],
                                                    'target' => $data['ai_target'] ?? 'seluruh siswa',
                                                    'tanggal' => now()->format('d F Y')
                                                ];

                                                $generatedContent = $aiService->generatePengumuman($aiParams);
                                                
                                                if ($generatedContent) {
                                                    $set('konten', $generatedContent);
                                                    
                                                    Notification::make()
                                                        ->title('Berhasil Generate Pengumuman!')
                                                        ->body('Konten pengumuman telah dibuat oleh AI. Silakan review dan edit sesuai kebutuhan.')
                                                        ->success()
                                                        ->send();
                                                } else {
                                                    throw new \Exception('Gagal generate konten');
                                                }

                                            } catch (\Exception $e) {
                                                Notification::make()
                                                    ->title('Error Generate AI')
                                                    ->body('Terjadi kesalahan: ' . $e->getMessage())
                                                    ->danger()
                                                    ->send();
                                            }
                                        })
                                ])
                                    ->columnSpan(1),
                            ])
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->description('Gunakan AI untuk membantu menulis pengumuman secara otomatis'),

                Forms\Components\Section::make('Data Pengumuman')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(auth()->id()),
                        Forms\Components\DatePicker::make('tanggal_mulai')
                            ->required()
                            ->default(now()),
                        Forms\Components\DatePicker::make('tanggal_selesai')
                            ->required()
                            ->default(now()->addDays(7)),
                        Forms\Components\DateTimePicker::make('tanggal_publish')
                            ->label('Tanggal Publish')
                            ->default(now()),
                        Forms\Components\RichEditor::make('konten')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Status Publish')
                            ->helperText('Publikasikan pengumuman ini?')
                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Aktifkan pengumuman ini?')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_publish')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status Publish')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publish'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal_publish', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengumumans::route('/'),
            'create' => Pages\CreatePengumuman::route('/create'),
            'edit' => Pages\EditPengumuman::route('/{record}/edit'),
        ];
    }
} 