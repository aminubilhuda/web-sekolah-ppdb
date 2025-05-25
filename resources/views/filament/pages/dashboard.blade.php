<x-filament-panels::page>
    @if (count($this->getHeaderWidgets()))
        <x-filament-widgets::widgets
            :widgets="$this->getHeaderWidgets()"
            :columns="$this->getHeaderWidgetsColumns()"
        />
    @endif
</x-filament-panels::page> 