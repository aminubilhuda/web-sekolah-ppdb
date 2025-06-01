<div class="flex flex-col space-y-4">
    <div class="w-full">
        <iframe 
            src="{{ $fileUrl }}" 
            class="w-full rounded-lg border"
            style="height: 70vh; min-height: 500px;"
            frameborder="0"
        ></iframe>
    </div>
    
    <div class="text-center text-sm text-gray-600 dark:text-gray-400">
        <p class="font-medium">{{ $fileName }}</p>
        <p class="text-xs">PDF Document</p>
    </div>
    
    <div class="flex justify-center space-x-2">
        <a 
            href="{{ $fileUrl }}" 
            target="_blank"
            class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Buka di Tab Baru
        </a>
        
        <a 
            href="{{ $fileUrl }}" 
            download="{{ $fileName }}"
            class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download
        </a>
    </div>
</div> 