@extends('layouts.admin')

@section('title', 'Add Masterpiece - Valencia Admin')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-semibold text-gray-900">Catalog New Masterpiece</h1>
            <p class="text-gray-600 mt-1">Add an exclusive timepiece to the Valencia Vault</p>
        </div>
        
        <a href="{{ route('admin.watches.index') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-300 hover:border-gray-400 rounded-2xl text-gray-700 hover:text-gray-900 transition-all">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Vault</span>
        </a>
    </div>

    <form action="{{ route('admin.watches.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf

        <!-- Main Form -->
        <div class="lg:col-span-8">
            <div class="card p-8 lg:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Watch Name</label>
                        <input type="text" name="name" id="name" placeholder="e.g., Rolex Daytona 126500LN" required
                               class="w-full px-6 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-base">
                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Brand</label>
                        <input type="text" name="brand" id="brand" placeholder="e.g., Rolex" required
                               class="w-full px-6 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-base">
                        @error('brand') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price (USD)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">$</span>
                            <input type="number" step="0.01" name="price" placeholder="125000.00" required
                                   class="w-full pl-10 pr-6 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-base font-medium">
                        </div>
                        @error('price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stock Quantity</label>
                        <input type="number" name="stock" value="1" required
                               class="w-full px-6 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-base">
                        @error('stock') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Description</label>
                    <textarea name="description" rows="7" placeholder="Describe the movement, case material, dial details, complications and unique story..."
                              class="w-full px-6 py-5 border border-gray-300 rounded-3xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all resize-y"></textarea>
                    @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Image Upload Sidebar -->
        <div class="lg:col-span-4 space-y-6">

            <div class="card p-8">
                <label class="block text-sm font-semibold text-gray-700 mb-4">Masterpiece Portrait</label>
                
                <div id="preview-container" 
                     class="w-full aspect-square border-2 border-dashed border-gray-300 rounded-3xl flex flex-col items-center justify-center overflow-hidden hover:border-blue-400 transition-all cursor-pointer relative bg-gray-50">
                    
                    <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                    
                    <div id="preview-placeholder" class="text-center px-6">
                        <i class="fas fa-cloud-upload-alt text-6xl text-gray-300 mb-4"></i>
                        <p class="font-medium text-gray-600">Drop image here or click to upload</p>
                        <p class="text-xs text-gray-400 mt-2">JPG, PNG, WebP • Max 8MB</p>
                    </div>
                </div>

                <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewImage()">

                <button type="button" onclick="document.getElementById('image').click()" 
                        class="mt-5 w-full py-3.5 border border-gray-300 hover:bg-gray-50 rounded-2xl text-sm font-medium transition-all">
                    Choose Image
                </button>
            </div>

            <!-- Submit -->
            <div class="card p-8">
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 rounded-2xl shadow-xl shadow-blue-500/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Save Masterpiece to Vault
                </button>
            </div>

        </div>
    </form>

</div>

@endsection

@push('scripts')
<script>
    function previewImage() {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('preview-placeholder');
        const file = document.getElementById('image').files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }

        if (file) reader.readAsDataURL(file);
    }

    // Click anywhere on preview area to upload
    document.getElementById('preview-container').addEventListener('click', () => {
        document.getElementById('image').click();
    });
</script>
@endpush