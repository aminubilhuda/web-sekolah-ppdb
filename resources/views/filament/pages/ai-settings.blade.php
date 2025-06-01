<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 rounded-lg p-6 text-white">
            <div class="flex items-center space-x-3">
                <x-heroicon-o-sparkles class="h-8 w-8" />
                <div>
                    <h2 class="text-xl font-bold">AI Writer Gemini</h2>
                    <p class="text-yellow-100">Tingkatkan produktivitas menulis dengan kecerdasan buatan</p>
                </div>
            </div>
        </div>

        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit" size="lg">
                    <x-heroicon-m-cog-6-tooth class="w-5 h-5 mr-2" />
                    Simpan Pengaturan
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page> 