<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Models\Berita;
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

class BeritaResource extends Resource
{
    use HasOptimizedResource;
    use HasOptimizedFileUpload;

    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Berita';
    protected static ?string $modelLabel = 'Berita';
    protected static ?string $pluralModelLabel = 'Berita';
    protected static ?int $navigationSort = 11;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['kategori']); // Eager loading tanpa count
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('🤖 AI Writer - Generate Berita Otomatis')
                    ->schema([
                        Forms\Components\Placeholder::make('ai_info')
                            ->label('')
                            ->content('💡 **Tips:** Masukkan topik yang spesifik untuk hasil yang lebih baik. Contoh: "Siswa SMK meraih juara 1 kompetisi robotik tingkat nasional" atau "Kegiatan ekstrakurikuler basket mencapai prestasi gemilang"')
                            ->columnSpanFull(),
                            
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('ai_topik')
                                    ->label('📝 Topik Berita')
                                    ->placeholder('Contoh: Prestasi siswa juara kompetisi robotik nasional')
                                    ->helperText('Deskripsikan topik berita secara detail untuk hasil AI yang optimal')
                                    ->required(false)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        // Auto-generate judul suggestion saat topik diubah
                                        if (!empty($state) && empty($set)) {
                                            // Set ini akan membuat form lebih responsive
                                        }
                                    })
                                    ->columnSpan(3),
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('generate_ai')
                                        ->label('✨ Generate AI')
                                        ->color('warning')
                                        ->icon('heroicon-o-sparkles')
                                        ->size('lg')
                                        ->requiresConfirmation()
                                        ->modalHeading('🤖 Generate Berita dengan AI')
                                        ->modalDescription('AI akan membantu menulis artikel berita berdasarkan topik yang Anda berikan. Pastikan topik sudah terisi dengan detail.')
                                        ->disabled(fn (Forms\Get $get): bool => empty($get('ai_topik')))
                                        ->action(function (array $data, Forms\Set $set, Forms\Get $get) {
                                            $aiTopik = $get('ai_topik');
                                            
                                            if (empty($aiTopik)) {
                                                Notification::make()
                                                    ->title('❌ Topik diperlukan')
                                                    ->body('Silakan masukkan topik berita terlebih dahulu di field "Topik Berita"')
                                                    ->warning()
                                                    ->duration(5000)
                                                    ->send();
                                                return;
                                            }

                                            try {
                                                $aiService = new GeminiAIService();
                                                
                                                Notification::make()
                                                    ->title('🔄 Sedang Generate...')
                                                    ->body('AI sedang menulis artikel berita untuk Anda. Mohon tunggu sebentar.')
                                                    ->info()
                                                    ->duration(3000)
                                                    ->send();
                                                
                                                // Generate judul jika belum ada
                                                if (empty($get('judul'))) {
                                                    $judulPrompt = "Buatkan judul berita yang menarik dan clickbait untuk topik: {$aiTopik}. Hanya berikan judulnya saja, maksimal 12 kata, dalam bahasa Indonesia.";
                                                    $generatedJudul = $aiService->generateContent($judulPrompt);
                                                    if ($generatedJudul) {
                                                        $cleanJudul = trim(str_replace(['"', "'", '«', '»'], '', $generatedJudul));
                                                        $set('judul', $cleanJudul);
                                                        $set('slug', Str::slug($cleanJudul));
                                                    }
                                                }

                                                // Generate konten berita
                                                $aiParams = [
                                                    'judul' => $get('judul') ?: $aiTopik,
                                                    'topik' => $aiTopik,
                                                    'kategori' => 'Berita Sekolah',
                                                    'tanggal' => now()->format('d F Y')
                                                ];

                                                $generatedContent = $aiService->generateBerita($aiParams);
                                                
                                                if ($generatedContent) {
                                                    $set('konten', $generatedContent);
                                                    
                                                    Notification::make()
                                                        ->title('✅ Berhasil Generate Berita!')
                                                        ->body('Konten berita telah dibuat oleh AI. Silakan review dan edit sesuai kebutuhan sekolah Anda.')
                                                        ->success()
                                                        ->duration(8000)
                                                        ->send();
                                                } else {
                                                    throw new \Exception('Gagal generate konten');
                                                }

                                            } catch (\Exception $e) {
                                                Notification::make()
                                                    ->title('❌ Error Generate AI')
                                                    ->body('Terjadi kesalahan: ' . $e->getMessage() . '. Pastikan koneksi internet dan API key sudah dikonfigurasi.')
                                                    ->danger()
                                                    ->duration(10000)
                                                    ->send();
                                            }
                                        })
                                ])
                                    ->columnSpan(1),
                            ])
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->description('🚀 Gunakan kekuatan AI untuk membantu menulis artikel berita secara otomatis dengan kualitas profesional'),

                Forms\Components\Section::make('Data Berita')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('kategori_id')
                            ->relationship('kategori', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->options(function () {
                                return Cache::remember('kategori_options', 3600, function () {
                                    return \App\Models\Kategori::pluck('nama', 'id')
                                        ->toArray();
                                });
                            }),
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft'),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publish')
                            ->default(now()),
                        Forms\Components\Textarea::make('konten')
                            ->required()
                            ->maxLength(65535)
                            ->rows(10)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar')
                            ->image()
                            ->directory('berita')
                            ->preserveFilenames()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->square(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publish')
                    ->dateTime()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->relationship('kategori', 'nama'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
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
            ->defaultSort('published_at', 'desc');
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
} 