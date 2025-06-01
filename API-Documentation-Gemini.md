# 🤖 Gemini AI API Documentation

## Overview

API Gemini AI untuk sistem Web Sekolah PPDB. Implementasi ini terinspirasi dari [tutorial TechSolutionStuff](https://techsolutionstuff.com/post/integrate-google-gemini-ai-in-laravel-12) namun dengan fitur yang lebih lengkap dan modern.

## Base URL

```
http://127.0.0.1:8000/api/gemini
```

## Authentication

Untuk production, sebaiknya tambahkan middleware auth pada routes.

---

## 🔗 Endpoints

### 1. Test Connection

**GET** `/test`

Test koneksi ke Gemini AI.

**Response Success:**

```json
{
    "success": true,
    "data": {
        "status": "connected",
        "model": "gemini-2.0-flash",
        "api_available": true,
        "timestamp": "2025-01-19T12:00:00.000000Z"
    },
    "message": "Gemini AI connection successful"
}
```

**Response Error:**

```json
{
    "success": false,
    "data": {
        "status": "disconnected",
        "model": "gemini-2.0-flash",
        "api_available": false,
        "timestamp": "2025-01-19T12:00:00.000000Z"
    },
    "error": "Connection Failed",
    "message": "API key tidak valid atau tidak memiliki akses. Periksa kembali API key Anda."
}
```

---

### 2. Get Model Information

**GET** `/models`

Mendapatkan informasi model yang tersedia dan konfigurasi saat ini.

**Response:**

```json
{
    "success": true,
    "data": {
        "current_model": "gemini-2.0-flash",
        "current_model_info": {
            "description": "Model terbaru dengan performa terbaik dan kecepatan tinggi",
            "max_tokens": 8192,
            "supports": ["text", "image", "video", "audio"],
            "recommended": true
        },
        "available_models": {
            "gemini-2.0-flash": "Gemini 2.0 Flash (Rekomendasi - Terbaru & Tercepat)",
            "gemini-1.5-pro": "Gemini 1.5 Pro (Kualitas Tinggi)",
            "gemini-1.5-flash": "Gemini 1.5 Flash (Cepat & Efisien)",
            "gemini-pro": "Gemini Pro (Legacy)"
        },
        "api_configured": true,
        "timestamp": "2025-01-19T12:00:00.000000Z"
    },
    "message": "Model information retrieved successfully"
}
```

---

### 3. Generate Content

**POST** `/generate`

Generate konten menggunakan Gemini AI.

**Request Body:**

```json
{
    "prompt": "Tulis artikel tentang pentingnya teknologi dalam pendidikan",
    "type": "berita",
    "params": {
        "judul": "Teknologi dalam Pendidikan Modern",
        "kategori": "Teknologi",
        "tanggal": "19 Januari 2025"
    }
}
```

**Parameters:**

-   `prompt` (required, string, max:8000): Text prompt untuk AI
-   `type` (optional, string): jenis konten (`berita`, `pengumuman`, `sambutan`)
-   `params` (optional, object): parameter tambahan untuk type tertentu

**Response Success:**

```json
{
    "success": true,
    "data": {
        "generated_text": "# Teknologi dalam Pendidikan Modern\n\nTeknologi telah mengubah landscape pendidikan...",
        "type": "berita",
        "model": "gemini-2.0-flash",
        "prompt_length": 65,
        "response_length": 1250,
        "timestamp": "2025-01-19T12:00:00.000000Z"
    },
    "message": "Content generated successfully"
}
```

**Response Error:**

```json
{
    "success": false,
    "error": "Generation Failed",
    "message": "API key tidak valid atau tidak memiliki akses. Periksa kembali API key Anda.",
    "model": "gemini-2.0-flash"
}
```

---

### 4. Generate Advanced Content

**POST** `/generate-advanced`

Generate konten dengan parameter lanjutan.

**Request Body:**

```json
{
    "prompt": "Buat sambutan kepala sekolah untuk tahun ajaran baru",
    "context": "SMK Negeri 1 Jakarta, fokus pada teknologi dan inovasi",
    "temperature": 0.8,
    "max_tokens": 4000,
    "top_k": 50,
    "top_p": 0.9
}
```

**Parameters:**

-   `prompt` (required, string, max:8000): Text prompt
-   `context` (optional, string, max:2000): Konteks tambahan
-   `temperature` (optional, float, 0-1): Kreativitas output (default: 0.7)
-   `max_tokens` (optional, int, 1-8192): Maksimal token output
-   `top_k` (optional, int, 1-100): Top-K sampling
-   `top_p` (optional, float, 0-1): Top-P sampling

**Response:**

```json
{
    "success": true,
    "data": {
        "generated_text": "Assalamualaikum Wr. Wb.\n\nPuji syukur kepada Allah SWT...",
        "model": "gemini-2.0-flash",
        "parameters": {
            "temperature": 0.8,
            "max_tokens": 4000,
            "top_k": 50,
            "top_p": 0.9
        },
        "prompt_with_context": true,
        "timestamp": "2025-01-19T12:00:00.000000Z"
    },
    "message": "Advanced content generated successfully"
}
```

---

## 📝 Example Usage

### cURL Examples

**Test Connection:**

```bash
curl -X GET http://127.0.0.1:8000/api/gemini/test \
     -H "Content-Type: application/json"
```

**Generate Berita:**

```bash
curl -X POST http://127.0.0.1:8000/api/gemini/generate \
     -H "Content-Type: application/json" \
     -d '{
       "prompt": "Prestasi siswa dalam olimpiade matematika",
       "type": "berita",
       "params": {
         "judul": "Siswa Meraih Juara 1 Olimpiade Matematika",
         "kategori": "Prestasi",
         "tanggal": "19 Januari 2025"
       }
     }'
```

**Generate Pengumuman:**

```bash
curl -X POST http://127.0.0.1:8000/api/gemini/generate \
     -H "Content-Type: application/json" \
     -d '{
       "prompt": "Libur semester dan jadwal masuk kembali",
       "type": "pengumuman",
       "params": {
         "judul": "Pengumuman Libur Semester",
         "target": "seluruh siswa dan guru",
         "tanggal": "19 Januari 2025"
       }
     }'
```

### JavaScript/Fetch Example

```javascript
// Test connection
const testConnection = async () => {
    try {
        const response = await fetch("http://127.0.0.1:8000/api/gemini/test");
        const data = await response.json();
        console.log("Connection status:", data);
    } catch (error) {
        console.error("Error:", error);
    }
};

// Generate content
const generateContent = async () => {
    try {
        const response = await fetch(
            "http://127.0.0.1:8000/api/gemini/generate",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    prompt: "Tulis artikel tentang pentingnya literasi digital",
                    type: "berita",
                    params: {
                        judul: "Literasi Digital di Era Modern",
                        kategori: "Pendidikan",
                    },
                }),
            }
        );

        const data = await response.json();
        console.log("Generated content:", data.data.generated_text);
    } catch (error) {
        console.error("Error:", error);
    }
};
```

### PHP Example

```php
// Test connection
$response = Http::get('http://127.0.0.1:8000/api/gemini/test');
$data = $response->json();

if ($data['success']) {
    echo "AI Connected: " . $data['data']['model'];
} else {
    echo "Connection failed: " . $data['message'];
}

// Generate content
$response = Http::post('http://127.0.0.1:8000/api/gemini/generate', [
    'prompt' => 'Tulis pengumuman tentang pendaftaran ekstrakurikuler',
    'type' => 'pengumuman',
    'params' => [
        'judul' => 'Pendaftaran Ekstrakurikuler 2025',
        'target' => 'siswa kelas X dan XI'
    ]
]);

$generated = $response->json()['data']['generated_text'];
echo $generated;
```

---

## 🚨 Error Codes

| Status Code | Error Type        | Description                   |
| ----------- | ----------------- | ----------------------------- |
| 422         | Validation Error  | Request body tidak valid      |
| 500         | Generation Failed | Gagal generate konten dari AI |
| 500         | Connection Failed | Gagal koneksi ke Gemini API   |

## 📊 Response Formats

Semua response menggunakan format JSON dengan struktur konsisten:

**Success Response:**

```json
{
  "success": true,
  "data": { ... },
  "message": "Success message"
}
```

**Error Response:**

```json
{
  "success": false,
  "error": "Error Type",
  "message": "Error description",
  "messages": { ... } // Untuk validation errors
}
```

---

## 🔧 Configuration

Pastikan konfigurasi berikut di file `.env`:

```env
GEMINI_API_KEY=your_api_key_here
GEMINI_MODEL=gemini-2.0-flash
```

## 📚 References

-   [Tutorial TechSolutionStuff](https://techsolutionstuff.com/post/integrate-google-gemini-ai-in-laravel-12)
-   [Google Gemini API Documentation](https://ai.google.dev/gemini-api/docs/quickstart)
-   [Google AI Studio](https://aistudio.google.com/app/apikey)

---

## 🎯 Features Comparison

| Feature             | Tutorial Basic  | Our Implementation            |
| ------------------- | --------------- | ----------------------------- |
| Model Support       | gemini-pro only | All Gemini models             |
| Error Handling      | Basic           | Comprehensive                 |
| Request Structure   | Old format      | Latest API format             |
| Content Types       | Generic only    | Berita, Pengumuman, Sambutan  |
| Advanced Parameters | No              | Yes (temperature, top_k, etc) |
| Safety Settings     | No              | Yes                           |
| Model Information   | No              | Yes                           |
| Connection Testing  | No              | Yes                           |

Implementasi ini menggunakan struktur API terbaru Google Gemini dengan fitur yang lebih lengkap dan robust dibandingkan tutorial dasar.
