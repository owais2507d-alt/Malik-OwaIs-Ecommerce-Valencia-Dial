@extends('layouts.admin')

@section('title', 'Edit Category')

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
        letter-spacing: 0.02em;
    }
    .image-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px dashed #d1d5db;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700 text-sm inline-flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left text-xs"></i>
            Back to Categories
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Edit Category</h2>
        <p class="text-gray-500 mt-1">Update "{{ $category->name }}" details</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="form-label">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                           class="form-input @error('name') border-red-400 @enderror"
                           placeholder="e.g. Luxury Watches">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4"
                              class="form-input @error('description') border-red-400 @enderror"
                              placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label class="form-label">Category Image</label>
                    <div class="flex items-center gap-6">
                        <div class="image-preview bg-gray-50 flex items-center justify-center text-gray-400">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover" id="current-img">
                            @else
                                <i class="fas fa-image text-2xl" id="preview-icon"></i>
                            @endif
                            <img id="preview-img" src="#" alt="Preview" class="w-full h-full object-cover hidden">
                        </div>
                        <div class="flex-1">
                            <label class="cursor-pointer bg-gray-50 hover:bg-gray-100 border border-dashed border-gray-300 rounded-xl px-6 py-4 text-center block transition-colors">
                                <i class="fas fa-upload text-gray-400 text-lg mb-1"></i>
                                <p class="text-sm text-gray-600 font-medium">Click to change image</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG or WebP (max 2MB)</p>
                                <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
                            </label>
                            @if($category->image)
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Leave empty to keep current image
                            </p>
                            @endif
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="form-label">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="active"
                                   {{ old('status', $category->status) === 'active' ? 'checked' : '' }}
                                   class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="inactive"
                                   {{ old('status', $category->status) === 'inactive' ? 'checked' : '' }}
                                   class="text-red-600 focus:ring-red-500">
                            <span class="text-sm text-gray-700">Inactive</span>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 pt-8 border-t border-gray-100 mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-sm font-medium transition-all">
                    <i class="fas fa-save mr-2"></i>
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium px-6 py-3">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const previewImg = document.getElementById('preview-img');
                previewImg.src = ev.target.result;
                previewImg.classList.remove('hidden');
                const currentImg = document.getElementById('current-img');
                if (currentImg) currentImg.classList.add('hidden');
                const icon = document.getElementById('preview-icon');
                if (icon) icon.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
