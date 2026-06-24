@extends('layouts.admin')

@section('title', 'Modify Masterpiece - Valencia Admin')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-semibold text-gray-800">Modify Masterpiece</h1>
            <p class="text-gray-600 mt-1">{{ $watch->name ?? 'Watch' }}</p>
        </div>
        <a href="{{ route('admin.watches.index') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-300 hover:border-gray-400 rounded-2xl text-gray-700 hover:text-gray-900 transition-all">
            <i class="fas fa-arrow-left"></i>
            <span>Cancel & Return</span>
        </a>
    </div>

    <div class="card p-8">
        <form action="{{ route('admin.watches.update', $watch->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Watch Name</label>
                    <input type="text" name="name" value="{{ old('name', $watch->name) }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                    @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $watch->brand) }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                    @error('brand') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (USD)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $watch->price) }}" required
                               class="w-full pl-8 pr-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>
                    @error('price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                    <input type="number" name="stock" value="{{ old('stock', $watch->stock) }}" required
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                    @error('stock') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="5" 
                          class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all resize-y">{{ old('description', $watch->description) }}</textarea>
                @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Image Section -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Current Image & New Image</label>
                
                @if($watch->image)
                <div class="mb-6 flex items-center gap-5 bg-gray-50 p-4 rounded-2xl">
                    <div class="w-28 h-28 rounded-2xl overflow-hidden border border-gray-200 shadow-sm">
                        <img src="{{ asset('storage/' . $watch->image) }}" 
                             alt="{{ $watch->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">Current Image</p>
                        <p class="text-sm text-gray-500">Leave the field below empty to keep current image.</p>
                    </div>
                </div>
                @endif

                <div class="border-2 border-dashed border-gray-300 rounded-3xl p-8 text-center hover:border-blue-400 transition-all">
                    <input type="file" name="image" accept="image/*" id="imageUpload"
                           class="hidden">
                    <label for="imageUpload" class="cursor-pointer flex flex-col items-center">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <span class="text-blue-600 font-medium">Click to upload new image</span>
                        <span class="text-xs text-gray-500 mt-1">JPG, PNG, WebP (Max 5MB)</span>
                    </label>
                </div>
                @error('image') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-6 border-t">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 rounded-2xl shadow-lg shadow-blue-500/30 transition-all active:scale-95">
                    Save Changes
                </button>
                
                <a href="{{ route('admin.watches.index') }}" 
                   class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-4 rounded-2xl text-center transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>

@endsection