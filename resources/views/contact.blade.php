@extends('layouts.app')

@section('title', 'Kontak')
@section('meta_description', 'Hubungi kami untuk informasi lebih lanjut tentang SMK.')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-primary-600">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="{{ asset('images/contact-bg.jpg') }}" alt="Contact Background">
            <div class="absolute inset-0 bg-primary-600 mix-blend-multiply"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Kontak</h1>
            <p class="mt-6 text-xl text-primary-100 max-w-3xl">Hubungi kami untuk informasi lebih lanjut tentang SMK.</p>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Contact Form -->
                <div class="lg:col-span-8">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                            
                            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                                @csrf
                                
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <!-- Nama -->
                                    <div>
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama" id="nama" 
                                            class="form-input @error('nama') border-red-500 @enderror" 
                                            value="{{ old('nama') }}" required>
                                        @error('nama')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" 
                                            class="form-input @error('email') border-red-500 @enderror" 
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Subjek -->
                                <div>
                                    <label for="subjek" class="form-label">Subjek</label>
                                    <input type="text" name="subjek" id="subjek" 
                                        class="form-input @error('subjek') border-red-500 @enderror" 
                                        value="{{ old('subjek') }}" required>
                                    @error('subjek')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Pesan -->
                                <div>
                                    <label for="pesan" class="form-label">Pesan</label>
                                    <textarea name="pesan" id="pesan" rows="4" 
                                        class="form-input @error('pesan') border-red-500 @enderror" 
                                        required>{{ old('pesan') }}</textarea>
                                    @error('pesan')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary w-full">
                                        Kirim Pesan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mt-12 lg:mt-0 lg:col-span-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                            
                            <div class="space-y-6">
                                <!-- Alamat -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">Alamat</h3>
                                        <p class="mt-1 text-gray-600">
                                            Jl. Pendidikan No. 123<br>
                                            Kota, Provinsi<br>
                                            Indonesia
                                        </p>
                                    </div>
                                </div>

                                <!-- Telepon -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">Telepon</h3>
                                        <p class="mt-1 text-gray-600">
                                            (021) 1234567<br>
                                            (021) 7654321
                                        </p>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">Email</h3>
                                        <p class="mt-1 text-gray-600">
                                            info@sekolah.sch.id<br>
                                            admin@sekolah.sch.id
                                        </p>
                                    </div>
                                </div>

                                <!-- Jam Operasional -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">Jam Operasional</h3>
                                        <p class="mt-1 text-gray-600">
                                            Senin - Jumat: 07:00 - 16:00<br>
                                            Sabtu: 07:00 - 12:00<br>
                                            Minggu: Tutup
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8 card">
                        <div class="card-body">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Media Sosial</h2>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">YouTube</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-body p-0">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6666666666665!2d106.66666666666666!3d-6.166666666666666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTAnMDAuMCJTIDEwNsKwNDAnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Animasi scroll
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.transform');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-4');
                }
            });
        });

        elements.forEach(element => {
            element.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-1000');
            observer.observe(element);
        });
    });
</script>
@endpush 