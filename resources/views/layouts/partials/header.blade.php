<header class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 shadow-lg">
    <div class="container mx-auto px-4 py-2">
        <div class="flex items-center justify-between">
            <!-- Contact Information -->
            <div class="flex-shrink-0 hidden lg:flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-white/90 hover:text-white transition-all duration-300">
                    <i class="fas fa-phone-alt text-xs"></i>
                    <span class="text-xs font-normal">{{ $profil->no_hp ?? '(021) 1234567' }}</span>
                </div>
                <div class="w-px h-4 bg-white/30"></div>
                <div class="flex items-center space-x-2 text-white/90 hover:text-white transition-all duration-300">
                    <i class="fas fa-envelope text-xs"></i>
                    <span class="text-xs font-normal">{{ $profil->email ?? 'info@sekolah.sch.id' }}</span>
                </div>
            </div>

            <!-- Mobile Contact Info -->
            <div class="flex lg:hidden items-center">
                <div class="text-white text-xs font-normal">
                    <i class="fas fa-phone-alt mr-1"></i>
                    {{ $profil->no_hp ?? '(021) 1234567' }}
                </div>
            </div>

            <!-- Social Media Icons -->
            <div class="flex items-center space-x-2">
                <span class="hidden md:block text-white/80 text-xs font-normal mr-1">Ikuti Kami:</span>
                <div class="flex items-center space-x-1">
                    @if($profil && $profil->facebook)
                    <a href="{{ $profil->facebook }}" target="_blank" 
                       class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-blue-600 hover:scale-110 transition-all duration-300 hover:shadow-lg">
                        <i class="fab fa-facebook-f text-xs"></i>
                    </a>
                    @endif
                    
                    @if($profil && $profil->instagram)
                    <a href="{{ $profil->instagram }}" target="_blank" 
                       class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-gradient-to-br hover:from-purple-500 hover:to-pink-500 hover:scale-110 transition-all duration-300 hover:shadow-lg">
                        <i class="fab fa-instagram text-xs"></i>
                    </a>
                    @endif
                    
                    @if($profil && $profil->twitter)
                    <a href="{{ $profil->twitter }}" target="_blank" 
                       class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-blue-400 hover:scale-110 transition-all duration-300 hover:shadow-lg">
                        <i class="fab fa-twitter text-xs"></i>
                    </a>
                    @endif
                    
                    @if($profil && $profil->youtube)
                    <a href="{{ $profil->youtube }}" target="_blank" 
                       class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-red-600 hover:scale-110 transition-all duration-300 hover:shadow-lg">
                        <i class="fab fa-youtube text-xs"></i>
                    </a>
                    @endif
                    
                    @if($profil && $profil->tiktok)
                    <a href="{{ $profil->tiktok }}" target="_blank" 
                       class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-gray-800 hover:scale-110 transition-all duration-300 hover:shadow-lg">
                        <i class="fab fa-tiktok text-xs"></i>
                    </a>
                    @endif
                    
                    @if($profil && $profil->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->whatsapp) }}" target="_blank" 
                       class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-green-500 hover:scale-110 transition-all duration-300 hover:shadow-lg">
                        <i class="fab fa-whatsapp text-xs"></i>
                    </a>
                    @endif
                    
                    @if($profil && $profil->telegram)
                    <a href="{{ $profil->telegram }}" target="_blank" 
                       class="w-6 h-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-blue-500 hover:scale-110 transition-all duration-300 hover:shadow-lg">
                        <i class="fab fa-telegram text-xs"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header> 