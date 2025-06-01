@extends('layouts.app')

@section('title', 'Kontak')
@section('meta_description', 'Hubungi kami untuk informasi lebih lanjut tentang SMK.')

@section('content')
    <!-- Hero Section dengan Gradient Modern -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900">
        <div class="absolute inset-0 bg-black/20"></div>
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tight">
                    <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                        Hubungi
                    </span>
                    <br>
                    <span class="text-white">Kami</span>
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                    Kami siap membantu menjawab pertanyaan Anda tentang pendidikan di SMK kami
                </p>
                <div class="mt-10 flex justify-center">
                    <div class="animate-bounce">
                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Contact Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Mari Berkoneksi</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Pilih cara yang paling nyaman untuk menghubungi kami
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Contact Form - Enhanced -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8">
                            <h3 class="text-3xl font-bold text-white mb-2">Kirim Pesan</h3>
                            <p class="text-blue-100">Kami akan merespons dalam 24 jam</p>
                        </div>
                        
                        <div class="p-8">
                            <!-- Success/Error Messages -->
                            @if(session('success'))
                                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <form action="{{ route('web.contact.store') }}" method="POST" class="space-y-6">
                                @csrf
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Nama -->
                                    <div class="group">
                                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nama Lengkap
                                        </label>
                                        <div class="relative">
                                            <input type="text" name="nama" id="nama" 
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors duration-200 @error('nama') border-red-400 @enderror" 
                                                value="{{ old('nama') }}" 
                                                placeholder="Masukkan nama lengkap"
                                                required>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('nama')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="group">
                                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Email
                                        </label>
                                        <div class="relative">
                                            <input type="email" name="email" id="email" 
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors duration-200 @error('email') border-red-400 @enderror" 
                                                value="{{ old('email') }}" 
                                                placeholder="nama@email.com"
                                                required>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Subjek -->
                                <div class="group">
                                    <label for="subjek" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Subjek
                                    </label>
                                    <input type="text" name="subjek" id="subjek" 
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors duration-200 @error('subjek') border-red-400 @enderror" 
                                        value="{{ old('subjek') }}" 
                                        placeholder="Topik pesan Anda"
                                        required>
                                    @error('subjek')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Pesan -->
                                <div class="group">
                                    <label for="pesan" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pesan
                                    </label>
                                    <textarea name="pesan" id="pesan" rows="5" 
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors duration-200 resize-none @error('pesan') border-red-400 @enderror" 
                                        placeholder="Tulis pesan Anda di sini..."
                                        required>{{ old('pesan') }}</textarea>
                                    @error('pesan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
                                        <span class="flex items-center justify-center space-x-2">
                                            <span>Kirim Pesan</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Info Cards -->
                <div class="space-y-6">
                    
                    <!-- Quick Contact -->
                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Hubungi Langsung</h3>
                            <p class="text-gray-600 text-sm mb-4">Telepon atau WhatsApp</p>
                        </div>
                        
                        @if($profil && $profil->no_hp)
                            <a href="tel:{{ $profil->no_hp }}" class="block w-full bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-3 px-4 rounded-xl transition-colors duration-200 text-center mb-3">
                                📞 {{ $profil->no_hp }}
                            </a>
                        @else
                            <a href="tel:+6212345678" class="block w-full bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-3 px-4 rounded-xl transition-colors duration-200 text-center mb-3">
                                📞 (021) 1234567
                            </a>
                        @endif
                        
                        @if($profil && $profil->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->whatsapp) }}" target="_blank" class="block w-full bg-green-50 hover:bg-green-100 text-green-700 font-semibold py-3 px-4 rounded-xl transition-colors duration-200 text-center">
                                💬 WhatsApp
                            </a>
                        @else
                            <a href="https://wa.me/6212345678" target="_blank" class="block w-full bg-green-50 hover:bg-green-100 text-green-700 font-semibold py-3 px-4 rounded-xl transition-colors duration-200 text-center">
                                💬 WhatsApp
                            </a>
                        @endif
                    </div>

                    <!-- Address Info -->
                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Alamat Sekolah</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    @if($profil && $profil->alamat)
                                        {{ $profil->alamat }}@if($profil->kecamatan), {{ $profil->kecamatan }}@endif<br>
                                        @if($profil->kabupaten && $profil->provinsi){{ $profil->kabupaten }}, {{ $profil->provinsi }}@endif<br>
                                        @if($profil->kode_pos){{ $profil->kode_pos }}@endif
                                    @else
                                        Jl. Pendidikan No. 123<br>
                                        Kota, Provinsi<br>
                                        Indonesia
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Email Info -->
                    <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Email</h3>
                                <div class="space-y-1">
                                    @if($profil && $profil->email)
                                        <a href="mailto:{{ $profil->email }}" class="text-blue-600 hover:text-blue-800 block">{{ $profil->email }}</a>
                                        @if($profil->website)
                                            <a href="{{ $profil->website }}" target="_blank" class="text-gray-500 text-sm hover:text-gray-700 block">{{ str_replace(['http://', 'https://'], '', $profil->website) }}</a>
                                        @endif
                                    @else
                                        <a href="mailto:info@sekolah.sch.id" class="text-blue-600 hover:text-blue-800 block">info@sekolah.sch.id</a>
                                        <a href="mailto:admin@sekolah.sch.id" class="text-blue-600 hover:text-blue-800 block">admin@sekolah.sch.id</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-3xl shadow-lg p-6 text-white">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold mb-2">Jam Operasional</h3>
                                <div class="space-y-1 text-green-100">
                                    <p>Senin - Jumat: 07:00 - 15:10</p>
                                    <p>Sabtu - Minggu: Tutup</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Section -->
    <div class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Ikuti Media Sosial Kami</h2>
            <p class="text-xl text-gray-600 mb-10">Tetap terhubung dan dapatkan update terbaru</p>
            
            <div class="flex flex-wrap justify-center gap-4">
                @if($profil && $profil->facebook)
                <a href="{{ $profil->facebook }}" target="_blank" class="group bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-2xl transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                        <span class="font-semibold">Facebook</span>
                    </div>
                </a>
                @endif
                
                @if($profil && $profil->instagram)
                <a href="{{ $profil->instagram }}" target="_blank" class="group bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white p-4 rounded-2xl transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                        </svg>
                        <span class="font-semibold">Instagram</span>
                    </div>
                </a>
                @endif
                
                @if($profil && $profil->youtube)
                <a href="{{ $profil->youtube }}" target="_blank" class="group bg-red-600 hover:bg-red-700 text-white p-4 rounded-2xl transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                        </svg>
                        <span class="font-semibold">YouTube</span>
                    </div>
                </a>
                @endif
                
                @if($profil && $profil->tiktok)
                <a href="{{ $profil->tiktok }}" target="_blank" class="group bg-gray-900 hover:bg-black text-white p-4 rounded-2xl transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                        <span class="font-semibold">TikTok</span>
                    </div>
                </a>
                @endif
                
                @if(!$profil || (!$profil->facebook && !$profil->instagram && !$profil->youtube && !$profil->tiktok))
                <!-- Default social media jika belum ada data -->
                <div class="text-gray-500 text-sm bg-gray-100 p-4 rounded-2xl">
                    Media sosial akan tersedia segera
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Map Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi Sekolah</h2>
                <p class="text-xl text-gray-600">Temukan kami di peta</p>
            </div>
            
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="h-96 lg:h-[500px]">
                    <iframe 
                        src="@if($profil && $profil->lokasi_maps){{ $profil->lokasi_maps }}@else{{ 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6666666666665!2d106.66666666666666!3d-6.166666666666666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTAnMDAuMCJTIDEwNsKwNDAnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid' }}@endif" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"
                        class="w-full h-full">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Enhanced scroll animations
    document.addEventListener('DOMContentLoaded', function() {
        // Intersection Observer untuk animasi
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe semua elemen yang ingin dianimasi
        document.querySelectorAll('.bg-white, .card').forEach(el => {
            el.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-700');
            observer.observe(el);
        });

        // Form enhancement
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Button click effect
        const buttons = document.querySelectorAll('button, .btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('div');
                ripple.classList.add('ripple');
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });
</script>

<style>
    .animate-fade-in {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
    
    .group:focus-within .group-focus-within\:text-blue-500 {
        color: #3b82f6;
    }
    
    .focused {
        transform: scale(1.02);
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>
@endpush 