<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbResource\Pages;
use App\Models\Ppdb;
use App\Services\FileUploadService;
use App\Traits\HasOptimizedResource;
use App\Traits\HasOptimizedFileUpload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;

class PpdbResource extends Resource
{
    use HasOptimizedResource;
    use HasOptimizedFileUpload;

    protected static ?string $model = Ppdb::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Pendaftar PPDB';
    protected static ?string $modelLabel = 'Pendaftar PPDB';
    protected static ?string $pluralModelLabel = 'Pendaftar PPDB';
    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['jurusan']); // Eager loading
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_pendaftaran')
                            ->label('Nomor Pendaftaran')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Auto Generate'),
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nisn')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('nik')
                            ->required()
                            ->maxLength(16),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required(),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan'
                            ])
                            ->required(),
                        Forms\Components\Select::make('agama')
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Konghucu' => 'Konghucu'
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('no_hp')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ])->columns(2),

                Forms\Components\Section::make('Data Sekolah')
                    ->schema([
                        Forms\Components\TextInput::make('asal_sekolah')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tahun_lulus')
                            ->required()
                            ->maxLength(4),
                        Forms\Components\Select::make('jurusan_pilihan')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])->columns(3),

                Forms\Components\Section::make('Data Orang Tua')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ayah')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('pekerjaan_ayah')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_hp_ayah')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('nama_ibu')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('pekerjaan_ibu')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_hp_ibu')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        Forms\Components\Textarea::make('alamat_ortu')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Dokumen')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto')
                            ->image()
                            ->required()
                            ->directory('ppdb/foto')
                            ->preserveFilenames()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->maxSize(2048), // 2MB
                        Forms\Components\FileUpload::make('ijazah')
                            ->acceptedFileTypes(['application/pdf'])
                            ->required()
                            ->directory('ppdb/ijazah')
                            ->maxSize(5120), // 5MB
                        Forms\Components\FileUpload::make('kk')
                            ->acceptedFileTypes(['application/pdf'])
                            ->required()
                            ->directory('ppdb/kk')
                            ->maxSize(5120), // 5MB
                    ])->columns(3),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'Menunggu' => 'Menunggu',
                                'Diterima' => 'Diterima',
                                'Ditolak' => 'Ditolak'
                            ])
                            ->required()
                            ->default('Menunggu'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('asal_sekolah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Diterima' => 'success',
                        'Ditolak' => 'danger',
                        'Menunggu' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Diterima' => 'heroicon-o-check-circle',
                        'Ditolak' => 'heroicon-o-x-circle',
                        'Menunggu' => 'heroicon-o-clock',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->tooltip(fn (string $state): string => match ($state) {
                        'Diterima' => 'Pendaftar telah diterima',
                        'Ditolak' => 'Pendaftar tidak diterima',
                        'Menunggu' => 'Menunggu verifikasi admin',
                        default => 'Status tidak diketahui',
                    })
                    ->sortable()
                    ->searchable(),
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak'
                    ])
                    ->default(null)
                    ->placeholder('Semua Status'),
                Tables\Filters\SelectFilter::make('jurusan_pilihan')
                    ->relationship('jurusan', 'nama_jurusan')
                    ->placeholder('Semua Jurusan'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Tanggal Daftar Dari'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Tanggal Daftar Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Daftar dari ' . \Carbon\Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Daftar sampai ' . \Carbon\Carbon::parse($data['created_until'])->toFormattedDateString();
                        }
                        return $indicators;
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('filter_menunggu')
                    ->label('Lihat Menunggu')
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->url(fn (): string => request()->fullUrlWithQuery(['tableFilters[status][value]' => 'Menunggu'])),
                Tables\Actions\Action::make('filter_diterima')
                    ->label('Lihat Diterima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->url(fn (): string => request()->fullUrlWithQuery(['tableFilters[status][value]' => 'Diterima'])),
                Tables\Actions\Action::make('filter_ditolak')
                    ->label('Lihat Ditolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->url(fn (): string => request()->fullUrlWithQuery(['tableFilters[status][value]' => 'Ditolak'])),
                Tables\Actions\Action::make('reset_filter')
                    ->label('Lihat Semua')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (): string => request()->url()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('terima')
                        ->label('Terima')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Terima Pendaftar')
                        ->modalDescription('Apakah Anda yakin ingin menerima pendaftar ini?')
                        ->action(function (Ppdb $record) {
                            $record->update(['status' => 'Diterima']);
                            
                            Notification::make()
                                ->title('Pendaftar berhasil diterima')
                                ->success()
                                ->send();
                        })
                        ->visible(fn (Ppdb $record): bool => $record->status !== 'Diterima'),
                    Tables\Actions\Action::make('tolak')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Pendaftar')
                        ->modalDescription('Apakah Anda yakin ingin menolak pendaftar ini?')
                        ->action(function (Ppdb $record) {
                            $record->update(['status' => 'Ditolak']);
                            
                            Notification::make()
                                ->title('Pendaftar berhasil ditolak')
                                ->success()
                                ->send();
                        })
                        ->visible(fn (Ppdb $record): bool => $record->status !== 'Ditolak'),
                    Tables\Actions\Action::make('reset_status')
                        ->label('Reset ke Menunggu')
                        ->icon('heroicon-o-clock')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Reset Status')
                        ->modalDescription('Apakah Anda yakin ingin mereset status ke Menunggu?')
                        ->action(function (Ppdb $record) {
                            $record->update(['status' => 'Menunggu']);
                            
                            Notification::make()
                                ->title('Status berhasil direset ke Menunggu')
                                ->success()
                                ->send();
                        })
                        ->visible(fn (Ppdb $record): bool => $record->status !== 'Menunggu'),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('terima_massal')
                        ->label('Terima Semua Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Terima Pendaftar Massal')
                        ->modalDescription('Apakah Anda yakin ingin menerima semua pendaftar yang dipilih?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = $records->count();
                            $records->each(function (Ppdb $record) {
                                $record->update(['status' => 'Diterima']);
                            });
                            
                            Notification::make()
                                ->title("Berhasil menerima {$count} pendaftar")
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('tolak_massal')
                        ->label('Tolak Semua Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Pendaftar Massal')
                        ->modalDescription('Apakah Anda yakin ingin menolak semua pendaftar yang dipilih?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = $records->count();
                            $records->each(function (Ppdb $record) {
                                $record->update(['status' => 'Ditolak']);
                            });
                            
                            Notification::make()
                                ->title("Berhasil menolak {$count} pendaftar")
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('reset_status_massal')
                        ->label('Reset ke Menunggu')
                        ->icon('heroicon-o-clock')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Reset Status Massal')
                        ->modalDescription('Apakah Anda yakin ingin mereset status semua pendaftar yang dipilih ke Menunggu?')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = $records->count();
                            $records->each(function (Ppdb $record) {
                                $record->update(['status' => 'Menunggu']);
                            });
                            
                            Notification::make()
                                ->title("Berhasil mereset status {$count} pendaftar ke Menunggu")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListPpdb::route('/'),
            'create' => Pages\CreatePpdb::route('/create'),
            'edit' => Pages\EditPpdb::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Menunggu')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'nomor_pendaftaran',
            'nama_lengkap', 
            'nisn',
            'nik',
            'jurusan.nama_jurusan'
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->nama_lengkap;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Nomor Pendaftaran' => $record->nomor_pendaftaran,
            'NISN' => $record->nisn,
            'Jurusan' => $record->jurusan?->nama_jurusan,
            'Status' => $record->status,
        ];
    }

    // Helper method untuk mendapatkan statistik PPDB
    public static function getStats(): array
    {
        $total = static::getModel()::count();
        $menunggu = static::getModel()::where('status', 'Menunggu')->count();
        $diterima = static::getModel()::where('status', 'Diterima')->count();
        $ditolak = static::getModel()::where('status', 'Ditolak')->count();

        return [
            'total' => $total,
            'menunggu' => $menunggu,
            'diterima' => $diterima,
            'ditolak' => $ditolak,
            'persentase_diterima' => $total > 0 ? round(($diterima / $total) * 100, 1) : 0,
        ];
    }
} 