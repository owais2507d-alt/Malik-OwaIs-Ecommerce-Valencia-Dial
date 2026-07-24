@extends('layouts.admin')

@section('title', 'Edit Deal')

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
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.deals.index') }}" class="text-gray-500 hover:text-gray-700 text-sm inline-flex items-center gap-2 mb-4">
            <i class="fas fa-arrow-left text-xs"></i>
            Back to Deals
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Edit Deal Banner</h2>
        <p class="text-gray-500 mt-1">Update promotional banner details</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.deals.update', $deal) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title', $deal->title) }}" class="form-input" placeholder="e.g. Summer Sale Ends In" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="2" class="form-input" placeholder="Short description for the banner...">{{ old('description', $deal->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Badge Text</label>
                    <input type="text" name="badge_text" value="{{ old('badge_text', $deal->badge_text) }}" class="form-input" placeholder="e.g. Limited Time">
                    @error('badge_text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">End Date & Time</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date', $deal->end_date->format('Y-m-d\TH:i')) }}" class="form-input" required>
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">CTA Text</label>
                    <input type="text" name="cta_text" value="{{ old('cta_text', $deal->cta_text) }}" class="form-input" placeholder="e.g. Shop the Sale">
                    @error('cta_text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">CTA Link</label>
                    <input type="text" name="cta_link" value="{{ old('cta_link', $deal->cta_link) }}" class="form-input" placeholder="e.g. /shop">
                    @error('cta_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $deal->is_active) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $deal->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-sm font-medium transition-all">
                    <i class="fas fa-save mr-2"></i>
                    Update Deal Banner
                </button>
                <a href="{{ route('admin.deals.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
