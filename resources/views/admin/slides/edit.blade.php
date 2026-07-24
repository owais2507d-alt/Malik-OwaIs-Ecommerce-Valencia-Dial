@extends('layouts.admin')

@section('title', 'Edit Slide')

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
    .current-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 12px;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.slides.index') }}" class="text-gray-500 hover:text-gray-700 text-sm inline-flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left text-xs"></i>
            Back to Slides
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Edit Slide</h2>
        <p class="text-gray-500 mt-1">Update carousel slide details</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title', $slide->title) }}" class="form-input" placeholder="e.g. Timeless Elegance" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $slide->subtitle) }}" class="form-input" placeholder="e.g. Since 1987">
                    @error('subtitle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Order</label>
                    <input type="number" name="order" value="{{ old('order', $slide->order) }}" class="form-input" min="0">
                    @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-input" placeholder="Slide description...">{{ old('description', $slide->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">CTA Text</label>
                    <input type="text" name="cta_text" value="{{ old('cta_text', $slide->cta_text) }}" class="form-input" placeholder="e.g. Shop Now">
                    @error('cta_text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">CTA Link</label>
                    <input type="text" name="cta_link" value="{{ old('cta_link', $slide->cta_link) }}" class="form-input" placeholder="e.g. /shop">
                    @error('cta_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Background Image</label>
                    @if($slide->image)
                    <img src="{{ asset('storage/' . $slide->image) }}" class="current-image mb-3">
                    @endif
                    <div class="image-upload-area" onclick="document.getElementById('imageInput').click()">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500">Click to replace image</p>
                        <p class="text-xs text-gray-400 mt-1">1920x1080 recommended (max 5MB)</p>
                    </div>
                    <input id="imageInput" type="file" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                    <div id="imagePreview" class="mt-3 hidden">
                        <img src="" class="w-full h-40 object-cover rounded-xl">
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $slide->is_active) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $slide->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-sm font-medium transition-all">
                    <i class="fas fa-save mr-2"></i>
                    Update Slide
                </button>
                <a href="{{ route('admin.slides.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const img = preview.querySelector('img');
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
