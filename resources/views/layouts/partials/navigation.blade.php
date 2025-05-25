<nav class="bg-primary-600" x-data="{ mobileMenuOpen: false }">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center"> 
                 <img src="{{ $profil && $profil->logo ? asset('storage/' . $profil->logo) : asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-8 w-auto mr-2">
                <a href="{{ route('web.home') }}" class="text-white text-xl font-bold">{{ $nama_sekolah }}</a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('web.home') }}" class="text-white hover:bg-primary-700 px-3 py-2 rounded-md text-sm font-medium">Beranda</a>
                
                <!-- Profil Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-white hover:bg-primary-700 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        Profil
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                        <div class="py-1">
                            <a href="{{ route('web.profil.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Sekolah</a>
                            <a href="{{ route('web.profil.visi-misi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Visi & Misi</a>
                            <a href="{{ route('web.profil.akreditasi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Akreditasi</a>
                            <a href="{{ route('web.profil.hubungan-industri') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hubungan Industri</a>
                            <a href="{{ route('web.profil.fasilitas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Fasilitas</a>
                        </div>
                    </div>
                </div>

                <!-- Akademik Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-white hover:bg-primary-700 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        Akademik
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                        <div class="py-1">
                            <a href="{{ route('web.jurusan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Jurusan</a>
                            <a href="{{ route('web.guru.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Guru</a>
                            <a href="{{ route('web.ekstrakurikuler.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ekstrakurikuler</a>
                        </div>
                    </div>
                </div>

                <!-- Informasi Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-white hover:bg-primary-700 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        Informasi
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                        <div class="py-1">
                            <a href="{{ route('web.berita.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Berita</a>
                            <a href="{{ route('web.agenda.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Agenda</a>
                            <a href="{{ route('web.prestasi.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Prestasi</a>
                            <a href="{{ route('web.galeri.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Galeri</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('web.alumni.index') }}" class="text-white hover:bg-primary-700 px-3 py-2 rounded-md text-sm font-medium">Alumni</a>
                <a href="{{ route('web.ppdb.index') }}" class="text-white hover:bg-primary-700 px-3 py-2 rounded-md text-sm font-medium">PPDB</a>
                <a href="{{ route('web.contact.index') }}" class="text-white hover:bg-primary-700 px-3 py-2 rounded-md text-sm font-medium">Kontak</a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-primary-700 focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden" x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('web.home') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
            
            <!-- Mobile Profil -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full text-left text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium flex items-center justify-between">
                    Profil
                    <svg class="h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="pl-4 space-y-1">
                    <a href="{{ route('web.profil.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Profil Sekolah</a>
                    <a href="{{ route('web.profil.visi-misi') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Visi & Misi</a>
                    <a href="{{ route('web.profil.akreditasi') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Akreditasi</a>
                    <a href="{{ route('web.profil.hubungan-industri') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Hubungan Industri</a>
                    <a href="{{ route('web.profil.fasilitas') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Fasilitas</a>
                </div>
            </div>

            <!-- Mobile Akademik -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full text-left text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium flex items-center justify-between">
                    Akademik
                    <svg class="h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="pl-4 space-y-1">
                    <a href="{{ route('web.jurusan.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Jurusan</a>
                    <a href="{{ route('web.guru.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Guru</a>
                    <a href="{{ route('web.ekstrakurikuler.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Ekstrakurikuler</a>
                </div>
            </div>

            <!-- Mobile Informasi -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full text-left text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium flex items-center justify-between">
                    Informasi
                    <svg class="h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="pl-4 space-y-1">
                    <a href="{{ route('web.berita.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Berita</a>
                    <a href="{{ route('web.agenda.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Agenda</a>
                    <a href="{{ route('web.prestasi.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Prestasi</a>
                    <a href="{{ route('web.galeri.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Galeri</a>
                </div>
            </div>

            <a href="{{ route('web.alumni.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Alumni</a>
            <a href="{{ route('web.ppdb.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">PPDB</a>
            <a href="{{ route('web.contact.index') }}" class="text-white hover:bg-primary-700 block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
        </div>
    </div>
</nav> 