<div class="min-h-screen flex items-center justify-center bg-gray-50 p-6">
    <div class="max-w-4xl w-full bg-white p-6 rounded-lg shadow-lg">

        <!-- Modules List -->
        @if (count($modules) === 0)
            <p class="text-center text-gray-600">No modules found for this course.</p>
        @else
            <div class="space-y-6">
                @foreach ($modules as $module)
                    <div class="bg-gray-100 p-4 rounded-md shadow-sm">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $module->title }}</h2>
                        <p class="text-gray-700">{{ $module->content }}</p>
                        <p class="text-gray-700">{{ $module->filepath }}</p>
                        <p class="text-sm text-gray-500">Created on: {{ \Carbon\Carbon::parse($module->createdAt)->format('M d, Y') }}</p>
                        
                        <!-- File Link -->
                        @if ($module->filepath && \Storage::exists($module->filepath))  
                            <a href="{{ asset('storage/' . $product->image_url) }}" target="_blank">
                                Download File
                                
                            </a>
                        @else
                            <p class="text-red-500">No file uploaded.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
