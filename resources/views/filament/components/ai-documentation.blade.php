<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center space-x-2 mb-3">
                <x-heroicon-o-document-text class="h-5 w-5 text-blue-600" />
                <h4 class="font-semibold text-gray-900">Dokumentasi Resmi</h4>
            </div>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="https://ai.google.dev/gemini-api/docs/quickstart?lang=python&hl=id" 
                       target="_blank" 
                       class="text-blue-600 hover:text-blue-800 flex items-center">
                        <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4 mr-1" />
                        Panduan Memulai Gemini API
                    </a>
                </li>
                <li>
                    <a href="https://aistudio.google.com/app/apikey" 
                       target="_blank" 
                       class="text-blue-600 hover:text-blue-800 flex items-center">
                        <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4 mr-1" />
                        Dapatkan API Key Gratis
                    </a>
                </li>
                <li>
                    <a href="https://ai.google.dev/gemini-api/docs/models/gemini" 
                       target="_blank" 
                       class="text-blue-600 hover:text-blue-800 flex items-center">
                        <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4 mr-1" />
                        Dokumentasi Model Gemini
                    </a>
                </li>
            </ul>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center space-x-2 mb-3">
                <x-heroicon-o-cog-6-tooth class="h-5 w-5 text-green-600" />
                <h4 class="font-semibold text-gray-900">Tools & Resources</h4>
            </div>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="https://aistudio.google.com/" 
                       target="_blank" 
                       class="text-green-600 hover:text-green-800 flex items-center">
                        <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4 mr-1" />
                        Google AI Studio
                    </a>
                </li>
                <li>
                    <a href="https://ai.google.dev/pricing" 
                       target="_blank" 
                       class="text-green-600 hover:text-green-800 flex items-center">
                        <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4 mr-1" />
                        Pricing & Quota Info
                    </a>
                </li>
                <li>
                    <a href="https://ai.google.dev/gemini-api/docs/safety-settings" 
                       target="_blank" 
                       class="text-green-600 hover:text-green-800 flex items-center">
                        <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4 mr-1" />
                        Safety Settings Guide
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
        <div class="flex items-start space-x-3">
            <x-heroicon-o-light-bulb class="h-5 w-5 text-indigo-600 mt-0.5 flex-shrink-0" />
            <div>
                <h4 class="font-semibold text-indigo-900 mb-2">Informasi Penting</h4>
                <div class="text-sm text-indigo-700 space-y-1">
                    <p>• <strong>Free Tier:</strong> Google Gemini API menyediakan free tier yang generous untuk development</p>
                    <p>• <strong>Rate Limits:</strong> 15 requests per minute untuk free tier, 1500 per day</p>
                    <p>• <strong>Model Terbaru:</strong> Gemini 2.0 Flash adalah model terbaru dengan performa optimal</p>
                    <p>• <strong>Data Privacy:</strong> Input dan output tidak digunakan untuk training model</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <h4 class="font-semibold text-gray-900 mb-2">📋 Checklist Setup AI Writer:</h4>
        <div class="space-y-2 text-sm">
            <label class="flex items-center">
                <input type="checkbox" class="rounded text-blue-600 mr-2" disabled>
                <span class="text-gray-700">Dapatkan API key dari Google AI Studio</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" class="rounded text-blue-600 mr-2" disabled>
                <span class="text-gray-700">Masukkan API key di form di atas</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" class="rounded text-blue-600 mr-2" disabled>
                <span class="text-gray-700">Pilih model Gemini 2.0 Flash (recommended)</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" class="rounded text-blue-600 mr-2" disabled>
                <span class="text-gray-700">Test koneksi dengan tombol di atas</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" class="rounded text-blue-600 mr-2" disabled>
                <span class="text-gray-700">Siap menggunakan AI Writer di resource lainnya!</span>
            </label>
        </div>
    </div>
</div> 