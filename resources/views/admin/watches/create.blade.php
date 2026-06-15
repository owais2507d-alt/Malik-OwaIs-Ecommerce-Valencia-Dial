@extends('layouts.admin')

@section('title', 'Add Masterpiece - Valencia')

@section('content')
    <!-- Form Head Controls -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight" style="color: var(--text-main);">Catalog New Piece</h1>
            <p class="text-stone-400 text-xs mt-0.5">Fill out horology details to deploy the item live.</p>
        </div>
        <a href="{{ route('admin.watches.index') }}" class="smooth-transition text-xs font-semibold px-4 py-2.5 rounded-xl border border-stone-200 text-stone-600 bg-white hover:bg-stone-50 flex items-center space-x-1.5 shadow-sm">
            <span>← Return to Index</span>
        </a>
    </div>

    <!-- Forms Block Frame -->
    <form action="{{ route('admin.watches.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start m-0">
        @csrf

        <!-- Core Input Data Card -->
        <div class="lg:col-span-2 border border-stone-100 rounded-2xl p-6 md:p-8 space-y-5 shadow-sm bg-white">
            <div class="space-y-1">
                <label for="name" class="block text-xs font-bold text-stone-500 uppercase tracking-wider">Watch Name</label>
                <input type="text" name="name" id="name" placeholder="e.g., Patek Philippe Nautilus" required
                       class="w-full text-xs border border-stone-200 rounded-xl px-4 py-3 text-stone-800 focus:outline-none focus:border-blue-400 focus:bg-stone-50/30 smooth-transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="brand" class="block text-xs font-bold text-stone-500 uppercase tracking-wider">Brand House</label>
                    <input type="text" name="brand" id="brand" placeholder="e.g., Patek Philippe" required
                           class="w-full text-xs border border-stone-200 rounded-xl px-4 py-3 text-stone-800 focus:outline-none focus:border-blue-400 focus:bg-stone-50/30 smooth-transition">
                </div>

                <div class="space-y-1">
                    <label for="price" class="block text-xs font-bold text-stone-500 uppercase tracking-wider">Valuation (Price USD)</label>
                    <input type="number" step="0.01" name="price" id="price" placeholder="e.g., 85000.00" required
                           class="w-full text-xs border border-stone-200 rounded-xl px-4 py-3 text-stone-800 focus:outline-none focus:border-blue-400 focus:bg-stone-50/30 smooth-transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="stock" class="block text-xs font-bold text-stone-500 uppercase tracking-wider">Stock Allocation</label>
                    <input type="number" name="stock" id="stock" value="1" required
                           class="w-full text-xs border border-stone-200 rounded-xl px-4 py-3 text-stone-800 focus:outline-none focus:border-blue-400 focus:bg-stone-50/30 smooth-transition">
                </div>
            </div>

            <div class="space-y-1">
                <label for="description" class="block text-xs font-bold text-stone-500 uppercase tracking-wider">Description Chronicles</label>
                <textarea name="description" id="description" rows="5" placeholder="Elaborate the master build materials, dial texture and calibre movements..."
                          class="w-full text-xs border border-stone-200 rounded-xl px-4 py-3 text-stone-800 focus:outline-none focus:border-blue-400 focus:bg-stone-50/30 smooth-transition resize-none"></textarea>
            </div>
        </div>

        <!-- Media Portfolio Panel Side -->
        <div class="space-y-6">
            <div class="border border-stone-100 rounded-2xl p-6 space-y-4 shadow-sm bg-white text-center">
                <label class="block text-xs font-bold text-stone-500 uppercase tracking-wider text-left">Portrait Asset</label>
                
                <div class="w-full h-52 bg-stone-50 border border-dashed border-stone-200 rounded-xl flex flex-col items-center justify-center p-4 relative overflow-hidden" id="preview-container">
                    <img id="image-preview" src="#" alt="Preview" class="max-w-full max-h-full object-contain hidden z-10">
                    <div id="preview-placeholder" class="text-stone-400 space-y-1 z-0">
                        <p class="text-[11px] font-medium">No Image Uploaded</p>
                    </div>
                </div>

                <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewFile()">
                <button type="button" onclick="document.getElementById('image').click()" class="w-full text-xs font-bold py-3 rounded-xl border border-stone-200 text-stone-600 bg-stone-50 hover:bg-stone-100 smooth-transition cursor-pointer">
                    Browse File
                </button>
            </div>

            <div class="border border-stone-100 rounded-2xl p-4 shadow-sm bg-white">
                <button type="submit" class="w-full text-xs font-bold py-3.5 rounded-xl text-white smooth-transition shadow-md cursor-pointer"
                        style="background-color: var(--bg-topbar);">
                    Save Masterpiece
                </button>
            </div>
        </div>
    </form>

    <script>
        function previewFile() {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('preview-placeholder');
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }, false);

            if (file) { reader.readAsDataURL(file); }
        }
    </script>
@endsection