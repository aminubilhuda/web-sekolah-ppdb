<header class="bg-white shadow-sm flex items-center">
    <div class="container mx-auto px-4 py-1 h-8">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0 hidden md:flex items-center space-x-3">
                 <div class="flex items-center">
                    <div class="h-3 w-auto">
                        <p class="text-xs text-gray-600">Telp : {{ $profil->no_hp ?? '(021) 1234567' }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="h-3 w-auto">
                        <p class="text-xs text-gray-600">Email : {{ $profil->email ?? 'info@sekolah.sch.id' }}</p>
                    </div>
                </div>
                {{-- <a href="{{ route('web.home') }}" class="flex items-center">
                    <img src="{{ $profil && $profil->logo ? asset('storage/' . $profil->logo) : asset('images/logo.png') }}" alt="{{ config('app.name') }}" width="100" height="100" class="h-8 w-auto">
                    <div class="ml-2">
                        <h1 class="text-base font-bold text-gray-900 h-3 w-auto">
                            <span class="text-sm font-normal text-gray-600"> {{ $nama_sekolah }}</span></h1>
                    </div>
                </a> --}}
            </div>

            <!-- Contact Info -->
            {{-- <div class="hidden md:flex items-center space-x-3">
                <div class="flex items-cente">
                    <div class="h-3 w-auto">
                        <p class="text-xs text-gray-600">{{ $profil->no_hp ?? '(021) 1234567' }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="h-3 w-auto">
                        <p class="text-xs text-gray-600">{{ $profil->email ?? 'info@sekolah.sch.id' }}</p>
                    </div>
                </div>
            </div> --}}

            <!-- Social Media Icons -->
            <div class="hidden md:flex items-center space-x-4">
                @if($profil && $profil->facebook)
                <a href="{{ $profil->facebook }}" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                    <i class="fab fa-facebook-f text-lg"></i>
                </a>
                @endif
                @if($profil && $profil->instagram)
                <a href="{{ $profil->instagram }}" target="_blank" class="text-gray-600 hover:text-pink-600 transition-colors duration-200">
                    <i class="fab fa-instagram text-lg"></i>
                </a>
                @endif
                @if($profil && $profil->twitter)
                <a href="{{ $profil->twitter }}" target="_blank" class="text-gray-600 hover:text-blue-400 transition-colors duration-200">
                    <i class="fab fa-twitter text-lg"></i>
                </a>
                @endif
                @if($profil && $profil->youtube)
                <a href="{{ $profil->youtube }}" target="_blank" class="text-gray-600 hover:text-red-600 transition-colors duration-200">
                    <i class="fab fa-youtube text-lg"></i>
                </a>
                @endif
                @if($profil && $profil->tiktok)
                <a href="{{ $profil->tiktok }}" target="_blank" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <i class="fab fa-tiktok text-lg"></i>
                </a>
                @endif
                @if($profil && $profil->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->whatsapp) }}" target="_blank" class="text-gray-600 hover:text-green-600 transition-colors duration-200">
                    <i class="fab fa-whatsapp text-lg"></i>
                </a>
                @endif
                @if($profil && $profil->telegram)
                <a href="{{ $profil->telegram }}" target="_blank" class="text-gray-600 hover:text-blue-500 transition-colors duration-200">
                    <i class="fab fa-telegram text-lg"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</header> 