@extends('layouts.admin')

@section('title', 'Slides')

@push('styles')
<style>
    .slide-preview {
        width: 120px;
        height: 68px;
        object-fit: cover;
        border-radius: 10px;
    }
    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        border: none;
    }
    .badge-active {
        background: #dcfce7;
        color: #166534;
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-weight: 500;
    }
    .badge-inactive {
        background: #fef2f2;
        color: #991b1b;
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Slides</h2>
            <p class="text-gray-500 mt-1">Manage homepage carousel slides</p>
        </div>
        <a href="{{ route('admin.slides.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all inline-flex items-center gap-2">
            <i class="fas fa-plus"></i>
            New Slide
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Preview</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Title</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Subtitle</th>
                        <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Order</th>
                        <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Status</th>
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($slides as $slide)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" class="slide-preview">
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-800">{{ $slide->title }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ $slide->subtitle ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-gray-600">{{ $slide->order }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="{{ $slide->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $slide->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.slides.edit', $slide) }}"
                               class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100 mr-1"
                               title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this slide?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn bg-red-50 text-red-500 hover:bg-red-100" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-gray-400">
                            <i class="fas fa-image text-4xl mb-3 block opacity-30"></i>
                            <p class="text-sm">No slides yet. Create your first slide!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($slides->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $slides->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
