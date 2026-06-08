@extends('layouts.admin')

@section('title', 'Modify Watch - Valencia Admin')

@section('content')
    <!-- Header -->
    <div class="mb-2 flex justify-between items-center border-b pb-6" style="border-color: var(--border-muted);">
        <div>
            <h1 class="luxury-title text-3xl font-medium tracking-wide text-white uppercase">Modify Masterpiece</h1>
            <p class="text-stone-500 text-xs mt-1">Update specifications or pricing for: {{ $watch->name }}</p>
        </div>
        <a href="{{ route('admin.watches.index') }}" class="smooth-transition text-[10px] uppercase tracking-widest border px-4 py-2 font-medium text-stone-400" 
           style="border-color: var(--border-input);" onmouseover="this.style.color='var(--text-gold)'; this.style.borderColor='var(--text-gold)'" onmouseout="this.style.color='#a8a29e'; this.style.borderColor='var(--border-input)'">
            Cancel & Return
        </a>
    </div>

    <!-- Edit Form Container -->
    <div class="border p-8 shadow-2xl max-w-3xl" style="background-color: var(--bg-card); border-color: var(--border-muted);">
        <form action="{{ route('admin.watches.update', $watch->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT') {{-- Laravel ko batane ke liye k yeh update request hai --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-1.5">
                    <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Watch Name</label>
                    <input type="text" name="name" value="{{ old('name', $watch->name) }}" required
                           class="smooth-transition w-full bg-[#0c0c0e] border rounded-none px-4 py-3 text-white text-sm focus:outline-none" style="border-color: var(--border-input);"
                           onfocus="this.style.borderColor='var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">
                    @error('name') <span class="text-red-400 text-xs block font-light">{{ $message }}</span> @enderror
                </div>

                <!-- Brand -->
                <div class="space-y-1.5">
                    <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $watch->brand) }}" required
                           class="smooth-transition w-full bg-[#0c0c0e] border rounded-none px-4 py-3 text-white text-sm focus:outline-none" style="border-color: var(--border-input);"
                           onfocus="this.style.borderColor='var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">
                    @error('brand') <span class="text-red-400 text-xs block font-light">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Price -->
                <div class="space-y-1.5">
                    <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $watch->price) }}" required
                           class="smooth-transition w-full bg-[#0c0c0e] border rounded-none px-4 py-3 text-white text-sm focus:outline-none" style="border-color: var(--border-input);"
                           onfocus="this.style.borderColor='var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">
                    @error('price') <span class="text-red-400 text-xs block font-light">{{ $message }}</span> @enderror
                </div>

                <!-- Stock -->
                <div class="space-y-1.5">
                    <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Available Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $watch->stock) }}" required
                           class="smooth-transition w-full bg-[#0c0c0e] border rounded-none px-4 py-3 text-white text-sm focus:outline-none" style="border-color: var(--border-input);"
                           onfocus="this.style.borderColor='var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">
                    @error('stock') <span class="text-red-400 text-xs block font-light">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Description</label>
                <textarea name="description" rows="4" class="smooth-transition w-full bg-[#0c0c0e] border rounded-none px-4 py-3 text-white text-sm focus:outline-none resize-none" style="border-color: var(--border-input);"
                          onfocus="this.style.borderColor='var(--text-gold)'" onblur="this.style.borderColor='var(--border-input)'">{{ old('description', $watch->description) }}</textarea>
                @error('description') <span class="text-red-400 text-xs block font-light">{{ $message }}</span> @enderror
            </div>

            <!-- Current Image Preview & Upload -->
            <div class="space-y-3">
                <label class="block text-stone-400 text-[10px] uppercase tracking-[0.25em] font-medium">Watch Image</label>
                
                @if($watch->image)
                    <div class="flex items-center space-x-4 p-3 bg-[#0c0c0e] border" style="border-color: var(--border-input);">
                        <div class="w-12 h-14 bg-stone-900 border overflow-hidden p-0.5" style="border-color: var(--border-muted);">
                            <img src="{{ asset('storage/' . $watch->image) }}" alt="Current Watch" class="w-full h-full object-cover">
                        </div>
                        <span class="text-xs text-stone-500 italic">Current masterpiece portrait. Leave field below empty to retain.</span>
                    </div>
                @endif

                <input type="file" name="image" accept="image/*" class="w-full bg-[#0c0c0e] border rounded-none px-4 py-2.5 text-stone-400 text-sm focus:outline-none cursor-pointer file:bg-transparent file:border-0 file:text-[var(--text-gold)] file:font-medium file:mr-4 file:uppercase file:text-xs file:tracking-widest" style="border-color: var(--border-input);">
                @error('image') <span class="text-red-400 text-xs block font-light">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="smooth-transition w-full font-semibold text-xs uppercase tracking-[0.25em] py-4 rounded-none shadow-xl mt-4 text-center cursor-pointer"
                    style="background-color: var(--text-gold); color: black;"
                    onmouseover="this.style.backgroundColor='var(--text-gold-hover)';" onmouseout="this.style.backgroundColor='var(--text-gold)';">
                Apply Changes
            </button>
        </form>
    </div>
@endsection