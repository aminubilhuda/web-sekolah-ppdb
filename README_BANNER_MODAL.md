# Fitur Modal Banner Highlight

## Deskripsi

Fitur modal banner highlight adalah popup yang akan muncul secara otomatis ketika homepage website diakses untuk pertama kali dalam sehari. Modal ini akan menampilkan gambar banner highlight yang diambil dari data profil sekolah.

## Fitur Utama

### 1. Tampil Otomatis

-   Modal akan muncul otomatis setelah 1 detik halaman homepage dimuat
-   Hanya akan muncul sekali per hari (menggunakan localStorage)
-   Tidak akan muncul jika user memiliki preferensi reduced motion

### 2. Responsif dan Modern

-   Desain yang responsif untuk semua ukuran layar
-   Animasi smooth dengan fade in dan scale effect
-   Background blur untuk fokus yang lebih baik
-   Border radius dan shadow yang modern

### 3. User Experience

-   Loading state saat gambar dimuat
-   Error handling jika gambar gagal dimuat
-   Dapat ditutup dengan:
    -   Tombol close (×)
    -   Klik di luar modal
    -   Tombol Escape
-   Mencegah scroll halaman saat modal terbuka

### 4. Optimasi Performance

-   Gambar akan diresize sesuai container
-   Lazy loading dengan check image complete
-   CSS transitions yang smooth
-   Memory efficient dengan proper cleanup

## Cara Penggunaan

### 1. Upload Banner Highlight

1. Login ke admin panel
2. Masuk ke menu "Profil Sekolah"
3. Edit profil sekolah
4. Upload gambar di field "Banner Highlight"
5. Simpan perubahan

### 2. Format Gambar yang Disarankan

-   **Rasio**: 16:9 (landscape)
-   **Resolusi**: 1920x1080px atau 1280x720px
-   **Format**: JPG, PNG
-   **Ukuran**: Maksimal 2MB
-   **Kualitas**: High resolution untuk hasil terbaik

### 3. Lokasi File

Banner highlight akan disimpan di:

```
storage/app/public/profil/banner/
```

## Pengaturan Modal

### CSS Classes

-   `.banner-modal`: Container utama modal
-   `.banner-modal-content`: Content wrapper
-   `.banner-modal-image`: Image styling
-   `.banner-modal-close`: Tombol close
-   `.banner-modal-loading`: Loading indicator

### JavaScript Functions

-   `showBannerModal()`: Menampilkan modal
-   `closeBannerModal()`: Menutup modal
-   `handleImageLoad()`: Handle saat gambar berhasil dimuat
-   `handleImageError()`: Handle error gambar
-   `shouldShowModal()`: Check apakah modal harus ditampilkan

### Kustomisasi CSS

Anda dapat mengkustomisasi tampilan modal dengan mengubah CSS variables:

```css
:root {
    --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --shadow-xl: 0 35px 60px -12px rgba(0, 0, 0, 0.3);
}
```

### Pengaturan Timing

Untuk mengubah delay modal, edit nilai timeout di JavaScript:

```javascript
setTimeout(function () {
    showBannerModal();
}, 1000); // 1000 = 1 detik
```

## Responsive Breakpoints

### Desktop (> 768px)

-   Max width: 90vw
-   Max height: 90vh
-   Padding: 20px
-   Border radius: 20px

### Tablet (≤ 768px)

-   Max width: 95vw
-   Max height: 85vh
-   Padding: 10px
-   Border radius: 15px
-   Close button: 35x35px

### Mobile (≤ 480px)

-   Max width: 98vw
-   Max height: 80vh
-   Padding: 5px
-   Border radius: 10px

## Accessibility

### ARIA Labels

-   Close button memiliki `aria-label="Tutup Modal"`
-   Image memiliki alt text yang deskriptif

### Keyboard Navigation

-   Modal dapat ditutup dengan tombol Escape
-   Focus management yang proper

### Motion Preferences

-   Respects `prefers-reduced-motion` setting
-   Animations akan di-disable jika user memilih reduced motion

## Browser Support

### Modern Browsers

-   Chrome 60+
-   Firefox 55+
-   Safari 12+
-   Edge 79+

### Features Used

-   CSS Grid dan Flexbox
-   CSS Variables
-   LocalStorage
-   CSS Backdrop Filter
-   CSS Transforms dan Transitions

## Troubleshooting

### Modal Tidak Muncul

1. Cek apakah banner_highlight sudah diupload di profil sekolah
2. Cek storage link: `php artisan storage:link`
3. Cek permission folder storage
4. Cek browser console untuk error JavaScript

### Gambar Tidak Muncul

1. Cek path gambar di database
2. Cek apakah file benar-benar ada di storage
3. Cek permission file dan folder
4. Cek format file (harus JPG/PNG)

### Modal Muncul Terus

1. Clear localStorage browser
2. Atau edit localStorage key 'bannerModalLastShown'

## Pengembangan Lanjutan

### Fitur yang Bisa Ditambahkan

1. **Multiple Banners**: Rotasi beberapa banner
2. **Scheduling**: Set waktu tampil banner
3. **Analytics**: Track berapa kali banner dilihat
4. **A/B Testing**: Test efektivitas banner
5. **Video Support**: Support video dalam modal
6. **Call to Action**: Tambah tombol aksi dalam modal

### Database Migration untuk Fitur Lanjutan

```php
Schema::table('profil_sekolah', function (Blueprint $table) {
    $table->json('banner_highlights')->nullable(); // Multiple banners
    $table->timestamp('banner_start_date')->nullable(); // Scheduling
    $table->timestamp('banner_end_date')->nullable();
    $table->boolean('banner_active')->default(true);
    $table->text('banner_cta_text')->nullable(); // Call to action
    $table->string('banner_cta_link')->nullable();
});
```

## Security Notes

### File Upload Security

-   Validasi file type dan size
-   Rename file untuk prevent direct access
-   Store outside web root jika memungkinkan
-   Scan file untuk malware

### XSS Prevention

-   Sanitize semua input
-   Escape output dalam HTML
-   Validate image dimensions

## Performance Tips

### Image Optimization

-   Compress images sebelum upload
-   Gunakan WebP format jika browser support
-   Lazy load untuk better performance
-   CDN untuk delivery yang lebih cepat

### Code Optimization

-   Minify CSS dan JavaScript
-   Use efficient selectors
-   Avoid reflow/repaint yang tidak perlu
-   Proper event listener cleanup
