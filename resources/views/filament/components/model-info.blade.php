<div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <div class="flex items-start space-x-3">
        <div class="flex-shrink-0">
            <x-heroicon-o-information-circle class="h-5 w-5 text-blue-600 mt-0.5" />
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-blue-900 mb-2">{{ $recommended }}</h4>
            <p class="text-sm text-blue-700 mb-3">{{ $description }}</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="bg-white p-3 rounded border border-blue-100">
                    <div class="text-xs text-blue-600 font-medium">Max Output Tokens</div>
                    <div class="text-sm font-semibold text-blue-800">{{ $max_tokens }}</div>
                </div>
                <div class="bg-white p-3 rounded border border-blue-100">
                    <div class="text-xs text-blue-600 font-medium">Mendukung Input</div>
                    <div class="text-sm font-semibold text-blue-800">{{ $supports }}</div>
                </div>
            </div>
        </div>
    </div>
</div> 