@extends('layouts.admin')

@section('title', 'Edit Product')

@push('styles')
<style>
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.2s;
        background: #f9fafb;
    }
    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        background: white;
    }
    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.9rem;
        background: #f9fafb;
        transition: all 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236b7280' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
    }
    .form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        background: white;
    }
    .image-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: all 0.2s;
        cursor: pointer;
    }
    .image-upload-area:hover {
        border-color: #3b82f6;
        background: #f0f7ff;
    }
    .current-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 text-sm inline-flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left text-xs"></i>
            Back to Products
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Edit Product</h2>
        <p class="text-gray-500 mt-1">Update "{{ $product->name }}" details</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="form-label">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                           class="form-input @error('name') border-red-400 @enderror"
                           placeholder="e.g. Rolex Submariner Date">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                           class="form-input @error('brand') border-red-400 @enderror"
                           placeholder="e.g. Rolex, IWC, Cartier">
                    @error('brand') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select @error('category_id') border-red-400 @enderror">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="form-label">Status</label>
                    <div class="flex gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="active"
                                   {{ old('status', $product->status) === 'active' ? 'checked' : '' }}
                                   class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="inactive"
                                   {{ old('status', $product->status) === 'inactive' ? 'checked' : '' }}
                                   class="text-red-600 focus:ring-red-500">
                            <span class="text-sm text-gray-700">Inactive</span>
                        </label>
                    </div>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="form-label">Price (USD) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">$</span>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                               class="form-input pl-8 @error('price') border-red-400 @enderror"
                               placeholder="0.00">
                    </div>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label class="form-label">Stock Quantity <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                           class="form-input @error('stock') border-red-400 @enderror"
                           placeholder="1">
                    @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label class="form-label">Description</label>
                <textarea name="description" rows="5"
                          class="form-input @error('description') border-red-400 @enderror"
                          placeholder="Product description, features, specifications...">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Image -->
            <div class="mt-6">
                <label class="form-label">Product Image</label>

                @if($product->image)
                <div class="flex items-center gap-4 mb-4 bg-gray-50 p-4 rounded-xl">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="current-img">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Current Image</p>
                        <p class="text-xs text-gray-400">Leave empty to keep current image</p>
                    </div>
                </div>
                @endif

                <div class="image-upload-area" id="uploadArea">
                    <div id="placeholder-content">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-3"></i>
                        <p class="text-sm font-medium text-gray-600">Click to upload new image</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP • Max 2MB</p>
                    </div>
                    <img id="preview-img" src="#" alt="Preview" class="hidden max-h-48 mx-auto rounded-lg">
                    <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
                </div>
                @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 pt-8 border-t border-gray-100 mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-sm font-medium transition-all">
                    <i class="fas fa-save mr-2"></i>
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-6 py-3">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('imageInput');
    const previewImg = document.getElementById('preview-img');
    const placeholder = document.getElementById('placeholder-content');

    uploadArea.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                previewImg.src = ev.target.result;
                previewImg.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
