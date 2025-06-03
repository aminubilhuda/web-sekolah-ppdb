<x-filament::page>
    <x-filament::card>
        <form wire:submit="import">
            {{ $this->form }}

            <div class="mt-4 flex justify-end">
                <x-filament::button type="submit">
                    Import Data
                </x-filament::button>
            </div>
        </form>
    </x-filament::card>
</x-filament::page> 