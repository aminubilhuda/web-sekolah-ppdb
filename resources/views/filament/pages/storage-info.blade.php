<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total_files'] }}</div>
            <div class="text-sm text-blue-800">Total File</div>
        </div>
        
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['total_size_formatted'] }}</div>
            <div class="text-sm text-green-800">Total Ukuran</div>
        </div>
        
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-purple-600">{{ $stats['total_folders'] }}</div>
            <div class="text-sm text-purple-800">Total Folder</div>
        </div>
    </div>

    @if(!empty($stats['file_types']))
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <h3 class="font-semibold text-gray-900 mb-3">📊 Distribusi Tipe File</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
            @foreach($stats['file_types'] as $type => $count)
            <div class="flex items-center justify-between p-2 bg-white rounded border">
                <span class="text-sm font-medium text-gray-700 uppercase">{{ $type ?: 'no-ext' }}</span>
                <span class="text-sm text-gray-500">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <h3 class="font-semibold text-yellow-900 mb-2">💡 Tips Optimasi Storage</h3>
        <ul class="text-yellow-800 text-sm space-y-1">
            <li>• Hapus file yang tidak terpakai secara berkala</li>
            <li>• Kompres gambar besar sebelum upload</li>
            <li>• Gunakan format file yang efisien (WebP untuk gambar)</li>
            <li>• Backup file penting ke cloud storage</li>
            <li>• Monitor penggunaan storage secara rutin</li>
        </ul>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <h3 class="font-semibold text-red-900 mb-2">⚠️ Batasan Storage</h3>
        <p class="text-red-800 text-sm">
            Pastikan ukuran storage tidak melebihi kapasitas server. 
            Jika storage penuh, website mungkin tidak dapat menerima upload file baru.
        </p>
        <div class="mt-2 text-xs text-red-600">
            Path: storage/app/public/
        </div>
    </div>
</div> 