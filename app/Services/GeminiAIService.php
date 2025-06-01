<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAIService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-2.0-flash');
    }

    /**
     * Generate content using Gemini AI
     * Updated according to official Google Gemini API documentation
     */
    public function generateContent(string $prompt): ?string
    {
        if (!$this->apiKey) {
            throw new \Exception('API key Gemini tidak dikonfigurasi. Silakan atur GEMINI_API_KEY di file .env atau di AI Settings.');
        }

        try {
            $url = $this->baseUrl . '/' . $this->model . ':generateContent?key=' . $this->apiKey;
            
            // Structure sesuai dokumentasi resmi Google Gemini API
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192, // Ditingkatkan untuk model terbaru
                    'candidateCount' => 1,
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH', 
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ]
                ]
            ];
            
            $response = Http::timeout(60) // Ditingkatkan timeout untuk model yang lebih kompleks
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                // Cek jika ada kandidat dan konten
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
                
                // Cek jika ada error karena safety filtering
                if (isset($data['candidates'][0]['finishReason'])) {
                    $finishReason = $data['candidates'][0]['finishReason'];
                    if ($finishReason === 'SAFETY') {
                        throw new \Exception('Konten ditolak karena alasan keamanan. Coba ubah prompt Anda.');
                    }
                    throw new \Exception('Generasi konten dihentikan: ' . $finishReason);
                }
                
                throw new \Exception('Response dari AI tidak dalam format yang diharapkan');
            }

            // Handle error response
            $errorData = $response->json();
            $errorMessage = $errorData['error']['message'] ?? 'Unknown error';
            $errorCode = $response->status();
            
            // Error messages berdasarkan status code
            switch ($errorCode) {
                case 400:
                    throw new \Exception('Bad Request: ' . $errorMessage);
                case 401:
                    throw new \Exception('API key tidak valid atau tidak memiliki akses. Periksa kembali API key Anda.');
                case 403:
                    throw new \Exception('Akses ditolak. Pastikan API key memiliki permission untuk Gemini API.');
                case 429:
                    throw new \Exception('Quota exceeded. Anda telah mencapai batas penggunaan API.');
                case 500:
                    throw new \Exception('Internal server error dari Google AI. Coba lagi dalam beberapa saat.');
                default:
                    throw new \Exception('API Error (' . $errorCode . '): ' . $errorMessage);
            }

        } catch (\Exception $e) {
            Log::error('Gemini AI Service error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate berita (news article)
     */
    public function generateBerita(array $params): ?string
    {
        $prompt = $this->buildBeritaPrompt($params);
        return $this->generateContent($prompt);
    }

    /**
     * Generate pengumuman (announcement)
     */
    public function generatePengumuman(array $params): ?string
    {
        $prompt = $this->buildPengumumanPrompt($params);
        return $this->generateContent($prompt);
    }

    /**
     * Generate sambutan kepala sekolah
     */
    public function generateSambutanKepsek(array $params): ?string
    {
        $prompt = $this->buildSambutanPrompt($params);
        return $this->generateContent($prompt);
    }

    /**
     * Build prompt untuk berita
     */
    private function buildBeritaPrompt(array $params): string
    {
        $judul = $params['judul'] ?? '';
        $topik = $params['topik'] ?? '';
        $kategori = $params['kategori'] ?? '';
        $tanggal = $params['tanggal'] ?? date('d F Y');

        return "
Tulis artikel berita sekolah dalam bahasa Indonesia yang profesional dan menarik dengan detail berikut:

**Judul**: {$judul}
**Topik**: {$topik} 
**Kategori**: {$kategori}
**Tanggal**: {$tanggal}

Kriteria penulisan:
1. Gaya bahasa formal namun mudah dipahami
2. Struktur: Lead paragraph, body, dan penutup
3. Panjang minimal 300-500 kata
4. Sertakan quote atau testimoni jika relevan
5. Gunakan data atau fakta yang mendukung
6. Akhiri dengan call-to-action atau informasi lebih lanjut
7. Gunakan perspektif positif dan membanggakan sekolah

Konteks: SMK Negeri dengan fokus pada prestasi akademik dan non-akademik siswa.

Hasilkan artikel berita yang lengkap dan siap publish:
        ";
    }

    /**
     * Build prompt untuk pengumuman
     */
    private function buildPengumumanPrompt(array $params): string
    {
        $judul = $params['judul'] ?? '';
        $topik = $params['topik'] ?? '';
        $target = $params['target'] ?? 'seluruh siswa';
        $tanggal = $params['tanggal'] ?? date('d F Y');

        return "
Tulis pengumuman sekolah dalam bahasa Indonesia yang jelas dan informatif dengan detail berikut:

**Judul**: {$judul}
**Topik**: {$topik}
**Target**: {$target}
**Tanggal**: {$tanggal}

Kriteria penulisan:
1. Bahasa resmi namun mudah dipahami
2. Struktur jelas dengan poin-poin penting
3. Informasi lengkap: apa, kapan, dimana, siapa, mengapa
4. Sertakan deadline atau batas waktu jika ada
5. Cantumkan kontak person untuk informasi lebih lanjut
6. Gunakan format yang mudah dibaca
7. Tegas dan langsung ke pointi

Konteks: SMK Negeri dengan siswa dan guru yang aktif.

Hasilkan pengumuman yang informatif dan actionable:
        ";
    }

    /**
     * Build prompt untuk sambutan kepala sekolah
     */
    private function buildSambutanPrompt(array $params): string
    {
        $acara = $params['acara'] ?? '';
        $tema = $params['tema'] ?? '';
        $audiens = $params['audiens'] ?? 'siswa dan guru';
        $pesan_utama = $params['pesan_utama'] ?? '';

        return "
Tulis sambutan kepala sekolah dalam bahasa Indonesia yang inspiratif dan memotivasi dengan detail berikut:

**Acara**: {$acara}
**Tema**: {$tema}
**Audiens**: {$audiens}
**Pesan Utama**: {$pesan_utama}

Kriteria penulisan:
1. Tone inspiratif dan memotivasi
2. Bahasa formal namun hangat dan personal
3. Struktur: pembukaan, isi utama, penutup/harapan
4. Panjang 200-400 kata
5. Sertakan apresiasi kepada audiens
6. Sampaikan visi dan misi sekolah
7. Berikan motivasi dan harapan
8. Akhiri dengan doa atau harapan baik

Konteks: Kepala Sekolah SMK Negeri yang peduli terhadap pendidikan dan masa depan siswa.

Hasilkan sambutan yang menginspirasi dan bermakna:
        ";
    }

    /**
     * Test API connection with simple prompt
     * Updated according to official documentation
     */
    public function testConnection(): bool
    {
        try {
            $result = $this->generateContent("Hello! Please respond with 'AI connection successful' to test the API.");
            return !empty($result) && str_contains(strtolower($result), 'successful');
        } catch (\Exception $e) {
            throw new \Exception('Gagal terhubung ke Gemini AI: ' . $e->getMessage());
        }
    }

    /**
     * Get available models
     */
    public function getAvailableModels(): array
    {
        return [
            'gemini-2.0-flash' => 'Gemini 2.0 Flash (Rekomendasi - Terbaru & Tercepat)',
            'gemini-1.5-pro' => 'Gemini 1.5 Pro (Kualitas Tinggi)',
            'gemini-1.5-flash' => 'Gemini 1.5 Flash (Cepat & Efisien)',
            'gemini-pro' => 'Gemini Pro (Legacy)',
        ];
    }

    /**
     * Get model info
     */
    public function getModelInfo(string $model = null): array
    {
        $model = $model ?? $this->model;
        
        $modelInfo = [
            'gemini-2.0-flash' => [
                'description' => 'Model terbaru dengan performa terbaik dan kecepatan tinggi',
                'max_tokens' => 8192,
                'supports' => ['text', 'image', 'video', 'audio'],
                'recommended' => true
            ],
            'gemini-1.5-pro' => [
                'description' => 'Model dengan kualitas output terbaik untuk tugas kompleks',
                'max_tokens' => 8192,
                'supports' => ['text', 'image', 'video', 'audio'],
                'recommended' => false
            ],
            'gemini-1.5-flash' => [
                'description' => 'Model cepat dengan efisiensi tinggi',
                'max_tokens' => 8192,
                'supports' => ['text', 'image'],
                'recommended' => false
            ],
            'gemini-pro' => [
                'description' => 'Model legacy (tidak direkomendasikan)',
                'max_tokens' => 2048,
                'supports' => ['text'],
                'recommended' => false
            ]
        ];

        return $modelInfo[$model] ?? $modelInfo['gemini-2.0-flash'];
    }
} 