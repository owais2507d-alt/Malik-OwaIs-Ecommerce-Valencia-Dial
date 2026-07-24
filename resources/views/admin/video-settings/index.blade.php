@extends('layouts.admin')

@section('title', 'Video Section Settings')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Video Section</h2>
            <p class="text-gray-500 mt-1 text-sm">Manage the background video section on the home page</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.video-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">
            <div class="space-y-8">

                <div class="border-b border-gray-100 pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Upload Video File</h3>
                    <p class="text-gray-500 text-xs mb-4">Upload an MP4, WebM, or OGG video file (max 200MB). This takes priority over the YouTube URL.</p>

                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-blue-400 transition cursor-pointer" id="dropZone">
                        <input type="file" name="video_section_file" id="videoFileInput" accept="video/mp4,video/webm,video/ogg,video/avi,video/quicktime" class="hidden">
                        <div id="uploadPlaceholder">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-3"></i>
                            <p class="text-sm text-gray-500">Drag & drop a video file or <span class="text-blue-600 font-semibold">browse</span></p>
                            <p class="text-xs text-gray-400 mt-1">MP4, WebM, OGG — Max 200MB</p>
                        </div>
                        <div id="fileSelected" class="hidden">
                            <i class="fas fa-file-video text-4xl text-emerald-500 mb-3"></i>
                            <p class="text-sm text-gray-700 font-semibold" id="fileName"></p>
                            <p class="text-xs text-gray-400 mt-1" id="fileSize"></p>
                            <button type="button" id="removeSelectedFile" class="mt-3 text-xs text-red-500 hover:text-red-700 font-medium">
                                <i class="fas fa-times mr-1"></i> Remove
                            </button>
                        </div>
                    </div>

                    @if($videoSectionFile)
                    <div class="mt-4 flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file-video text-emerald-500"></i>
                            <span class="text-sm text-gray-700">Current file: <strong>{{ basename($videoSectionFile) }}</strong></span>
                        </div>
                        <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                            <input type="checkbox" name="remove_video_file" value="1">
                            <span>Remove</span>
                        </label>
                    </div>
                    @endif

                    @error('video_section_file')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">YouTube Video URL</label>
                    <p class="text-gray-500 text-xs mb-3">Only used when no video file is uploaded above</p>
                    <input type="url" name="video_section_url"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                        placeholder="https://www.youtube.com/embed/VIDEO_ID"
                        value="{{ old('video_section_url', $videoSectionUrl) }}">
                    @error('video_section_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">Subtitle</label>
                    <p class="text-gray-500 text-xs mb-3">Small label above the title</p>
                    <input type="text" name="video_section_subtitle"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                        placeholder="Watch"
                        value="{{ old('video_section_subtitle', $videoSectionSubtitle) }}">
                    @error('video_section_subtitle')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">Title</label>
                    <p class="text-gray-500 text-xs mb-3">Main heading text</p>
                    <input type="text" name="video_section_title"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                        placeholder="THE CRAFT BEHIND THE CRAFT"
                        value="{{ old('video_section_title', $videoSectionTitle) }}">
                    @error('video_section_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">Description</label>
                    <p class="text-gray-500 text-xs mb-3">Paragraph shown below the title</p>
                    <textarea name="video_section_description" rows="4"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400 resize-none"
                        placeholder="Witness the artistry of master horologists at work...">{{ old('video_section_description', $videoSectionDescription) }}</textarea>
                    @error('video_section_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-2xl transition-all">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-2xl transition-all active:scale-95">
                <i class="fas fa-save mr-2"></i> Save Settings
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const fileInput = document.getElementById('videoFileInput');
    const dropZone = document.getElementById('dropZone');
    const placeholder = document.getElementById('uploadPlaceholder');
    const fileSelected = document.getElementById('fileSelected');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeBtn = document.getElementById('removeSelectedFile');

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect();
        }
    });

    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect() {
        if (fileInput.files.length) {
            const file = fileInput.files[0];
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            placeholder.classList.add('hidden');
            fileSelected.classList.remove('hidden');
        }
    }

    removeBtn.addEventListener('click', () => {
        fileInput.value = '';
        placeholder.classList.remove('hidden');
        fileSelected.classList.add('hidden');
    });
</script>
@endpush
@endsection
