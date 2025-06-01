<div class="flex flex-col items-center space-y-6 py-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ $fileName }}</h3>
        
        <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
            <p><span class="font-medium">Tipe:</span> {{ $fileType }}</p>
            <p><span class="font-medium">Ukuran:</span> {{ $fileSize }}</p>
        </div>
    </div>
    
    <div class="text-center">
        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $message }}</p>
    </div>
    
    <div class="flex space-x-3">
        <a 
            href="{{ $fileUrl }}" 
            target="_blank"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Buka di Tab Baru
        </a>
        
        <a 
            href="{{ $fileUrl }}" 
            download="{{ $fileName }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download File
        </a>
    </div>
</div> 