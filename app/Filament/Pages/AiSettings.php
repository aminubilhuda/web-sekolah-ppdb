<?php

namespace App\Filament\Pages;

use App\Services\GeminiAIService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AiSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationLabel = 'AI Settings';
    protected static ?string $title = 'Pengaturan AI Writer';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 99;
    
    protected static string $view = 'filament.pages.ai-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->data['gemini_api_key'] = config('services.gemini.api_key');
        $this->data['gemini_model'] = config('services.gemini.model', 'gemini-2.0-flash');
    }

    public function form(Form $form): Form
    {
        $aiService = new GeminiAIService();
        
        return $form
            ->schema([
                Forms\Components\Section::make('🤖 Konfigurasi Gemini AI')
                    ->description('Konfigurasi API key dan model untuk Google Gemini AI - Updated sesuai dokumentasi resmi')
                    ->schema([
                        Forms\Components\TextInput::make('gemini_api_key')
                            ->label('Gemini API Key')
                            ->password()
                            ->required()
                            ->placeholder('Masukkan API key dari Google AI Studio')
                            ->helperText('Dapatkan API key gratis di: https://aistudio.google.com/app/apikey')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Auto-save API key ke config saat diubah
                                $this->updateEnvFile('GEMINI_API_KEY', $state);
                            }),
                        
                        Forms\Components\Select::make('gemini_model')
                            ->label('Model Gemini')
                            ->options($aiService->getAvailableModels())
                            ->default('gemini-2.0-flash')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Auto-save model ke config saat diubah
                                $this->updateEnvFile('GEMINI_MODEL', $state);
                            }),
                        
                        Forms\Components\Placeholder::make('model_info')
                            ->label('Informasi Model')
                            ->content(function (Forms\Get $get) use ($aiService) {
                                $model = $get('gemini_model') ?? 'gemini-2.0-flash';
                                $info = $aiService->getModelInfo($model);
                                
                                $supports = implode(', ', $info['supports']);
                                $recommended = $info['recommended'] ? '✅ Direkomendasikan' : '⚪ Opsional';
                                
                                return view('filament.components.model-info', [
                                    'description' => $info['description'],
                                    'max_tokens' => number_format($info['max_tokens']),
                                    'supports' => $supports,
                                    'recommended' => $recommended
                                ]);
                            })
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('🧪 Test Koneksi')
                    ->description('Test koneksi ke Gemini AI dengan model yang dipilih')
                    ->schema([
                        Forms\Components\Placeholder::make('test_info')
                            ->label('')
                            ->content('Klik tombol di bawah untuk test koneksi ke Gemini AI dengan API key dan model yang telah dikonfigurasi.'),
                        
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('test_connection')
                                ->label('🔗 Test Koneksi AI')
                                ->color('success')
                                ->icon('heroicon-o-wifi')
                                ->action(function (Forms\Get $get) {
                                    try {
                                        // Gunakan konfigurasi terbaru dari form
                                        $apiKey = $get('gemini_api_key');
                                        $model = $get('gemini_model');
                                        
                                        if (empty($apiKey)) {
                                            throw new \Exception('API key belum diisi. Silakan masukkan API key terlebih dahulu.');
                                        }

                                        // Update config sementara untuk test
                                        config(['services.gemini.api_key' => $apiKey]);
                                        config(['services.gemini.model' => $model]);

                                        $aiService = new GeminiAIService();
                                        $success = $aiService->testConnection();
                                        
                                        if ($success) {
                                            Notification::make()
                                                ->title('✅ Koneksi Berhasil!')
                                                ->body("Gemini AI model {$model} berhasil terhubung dan siap digunakan.")
                                                ->success()
                                                ->duration(5000)
                                                ->send();
                                        }
                                    } catch (\Exception $e) {
                                        $errorMessage = $e->getMessage();
                                        
                                        // Berikan panduan berdasarkan jenis error
                                        if (str_contains($errorMessage, 'API key')) {
                                            $guidance = 'Dapatkan API key gratis di: https://aistudio.google.com/app/apikey';
                                        } elseif (str_contains($errorMessage, 'PERMISSION_DENIED') || str_contains($errorMessage, '401')) {
                                            $guidance = 'API key tidak valid atau tidak memiliki akses ke Gemini API';
                                        } elseif (str_contains($errorMessage, 'QUOTA_EXCEEDED') || str_contains($errorMessage, '429')) {
                                            $guidance = 'Kuota API telah habis. Periksa penggunaan di Google AI Studio';
                                        } elseif (str_contains($errorMessage, '403')) {
                                            $guidance = 'Akses ditolak. Pastikan API key memiliki permission untuk Gemini API';
                                        } else {
                                            $guidance = 'Periksa koneksi internet dan konfigurasi API key';
                                        }

                                        Notification::make()
                                            ->title('❌ Koneksi Gagal')
                                            ->body($errorMessage . '. ' . $guidance)
                                            ->danger()
                                            ->duration(10000)
                                            ->send();
                                    }
                                }),
                        ])
                    ]),

                Forms\Components\Section::make('📝 Fitur AI Writer')
                    ->description('Daftar fitur AI Writer yang tersedia dengan model terbaru')
                    ->schema([
                        Forms\Components\Placeholder::make('features')
                            ->label('')
                            ->content(view('filament.components.ai-features-updated')),
                    ]),

                Forms\Components\Section::make('📚 Dokumentasi & Referensi')
                    ->description('Link ke dokumentasi resmi Google Gemini API')
                    ->schema([
                        Forms\Components\Placeholder::make('docs')
                            ->label('')
                            ->content(view('filament.components.ai-documentation')),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Simpan ke file .env
        $this->updateEnvFile('GEMINI_API_KEY', $data['gemini_api_key']);
        $this->updateEnvFile('GEMINI_MODEL', $data['gemini_model']);

        // Clear config cache agar perubahan segera aktif
        try {
            \Artisan::call('config:clear');
        } catch (\Exception $e) {
            // Ignore jika gagal clear cache
        }

        Notification::make()
            ->title('⚙️ Pengaturan Disimpan')
            ->body('Konfigurasi AI Writer berhasil disimpan dan siap digunakan.')
            ->success()
            ->send();
    }

    private function updateEnvFile(string $key, string $value): void
    {
        $envFile = base_path('.env');
        
        if (file_exists($envFile)) {
            $envContent = file_get_contents($envFile);
            
            // Check if key exists
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            } else {
                // Add new key
                $envContent .= "\n{$key}={$value}";
            }
            
            file_put_contents($envFile, $envContent);
        }
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_ai_setting');
    }
} 