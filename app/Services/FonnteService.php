<?php

namespace App\Services;

use App\Models\FonnteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class FonnteService
{
    protected $baseUrl;
    protected $apiKey;
    protected $adminNumber;

    public function __construct()
    {
        $settings = $this->getSettings();
        $this->baseUrl = $settings['base_url'];
        $this->apiKey = $settings['api_key'];
        $this->adminNumber = $settings['admin_number'];
    }

    /**
     * Dapatkan pengaturan Fonnte
     *
     * @return array
     */
    protected function getSettings()
    {
        return Cache::remember('fonnte_settings', 3600, function () {
            $settings = Setting::where('key', 'fonnte_settings')->first();
            
            if (!$settings) {
                return [
                    'base_url' => config('services.fonnte.base_url'),
                    'api_key' => config('services.fonnte.api_key'),
                    'admin_number' => config('services.fonnte.admin_number'),
                ];
            }

            return $settings->value;
        });
    }

    /**
     * Kirim pesan WhatsApp
     *
     * @param string $target Nomor tujuan (format: 628xxxxxxxxxx)
     * @param string $message Pesan yang akan dikirim
     * @return array
     */
    public function sendMessage($target, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->post($this->baseUrl, [
                'target' => $target,
                'message' => $message
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('Fonnte API Error', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengirim pesan WhatsApp',
                'error' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('Fonnte Service Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pesan',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Kirim notifikasi pendaftaran PPDB ke siswa
     *
     * @param array $data Data pendaftaran
     * @return array
     */
    public function sendPPDBNotification($data)
    {
        $message = "🎓 *PENDAFTARAN PPDB BERHASIL* 🎓\n\n" .
                  "Halo {$data['nama']},\n\n" .
                  "Terima kasih telah mendaftar di PPDB kami.\n\n" .
                  "📋 *Detail Pendaftaran:*\n" .
                  "No. Pendaftaran: *{$data['nomor_pendaftaran']}*\n" .
                  "Nama: *{$data['nama']}*\n" .
                  "Jurusan: *{$data['jurusan']}*\n" .
                  "Asal Sekolah: *{$data['asal_sekolah']}*\n\n" .
                  "📝 *Langkah Selanjutnya:*\n" .
                  "1. Simpan nomor pendaftaran Anda\n" .
                  "2. Cek email Anda untuk informasi selanjutnya\n" .
                  "3. Tunggu pengumuman seleksi\n\n" .
                  "❓ *Bantuan:*\n" .
                  "Jika ada pertanyaan, silakan hubungi kami di:\n" .
                  "📞 " . $this->adminNumber . "\n\n" .
                  "Terima kasih telah memilih sekolah kami.\n" .
                  "Semoga sukses! 🙏";

        return $this->sendMessage($data['no_hp'], $message);
    }

    /**
     * Kirim notifikasi pendaftaran PPDB ke admin
     *
     * @param array $data Data pendaftaran
     * @return array
     */
    public function sendPPDBAdminNotification($data)
    {
        $message = "🔔 *PENDAFTARAN PPDB BARU* 🔔\n\n" .
                  "📋 *Detail Pendaftaran:*\n" .
                  "No. Pendaftaran: *{$data['nomor_pendaftaran']}*\n" .
                  "Nama: *{$data['nama']}*\n" .
                  "NISN: *{$data['nisn']}*\n" .
                  "No. HP: *{$data['no_hp']}*\n" .
                  "Jurusan: *{$data['jurusan']}*\n" .
                  "Asal Sekolah: *{$data['asal_sekolah']}*\n\n" .
                  "📝 *Dokumen:*\n" .
                  "Foto: {$data['foto']}\n" .
                  "Ijazah: {$data['ijazah']}\n" .
                  "KK: {$data['kk']}\n\n" .
                  "Silakan verifikasi pendaftaran ini.";

        return $this->sendMessage(config('services.fonnte.admin_number'), $message);
    }

    /**
     * Kirim pesan template
     *
     * @param string $target Nomor tujuan
     * @param string $templateName Nama template yang terdaftar
     * @param array $components Komponen template
     * @return array
     */
    public function sendTemplate($target, $templateName, $components = [])
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->post($this->baseUrl . '/template', [
                'target' => $target,
                'template' => $templateName,
                'components' => $components
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('Fonnte Template API Error', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengirim template WhatsApp',
                'error' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('Fonnte Template Service Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim template',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Test koneksi Fonnte
     *
     * @param string $target Nomor tujuan
     * @param string $message Pesan test
     * @return array
     */
    public function testConnection($target, $message)
    {
        try {
            $result = $this->sendMessage($target, $message);
            
            if ($result['success']) {
                return [
                    'success' => true,
                    'message' => 'Koneksi berhasil! Pesan test telah dikirim.',
                    'data' => $result['data']
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal mengirim pesan test: ' . ($result['message'] ?? 'Unknown error'),
                'error' => $result['error'] ?? null
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ];
        }
    }
} 