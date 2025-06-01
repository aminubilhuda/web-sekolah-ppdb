<div class="p-6 text-center">
    <h3 class="text-lg font-semibold mb-4">Test Modal Preview</h3>
    
    <div class="space-y-2 text-sm">
        <p><strong>File Name:</strong> {{ $fileName ?? 'Not provided' }}</p>
        <p><strong>File URL:</strong> {{ $fileUrl ?? 'Not provided' }}</p>
        <p><strong>File Size:</strong> {{ $fileSize ?? 'Not provided' }}</p>
        <p><strong>File Extension:</strong> {{ $fileExtension ?? 'Not provided' }}</p>
    </div>
    
    @if(isset($fileUrl) && !empty($fileUrl))
        <div class="mt-4">
            <img src="{{ $fileUrl }}" alt="{{ $fileName ?? 'Image' }}" class="max-w-full h-auto max-h-64 mx-auto rounded">
        </div>
    @endif
    
    <div class="mt-4 text-xs text-gray-500">
        Modal debugging - File Manager Test
    </div>
</div> 