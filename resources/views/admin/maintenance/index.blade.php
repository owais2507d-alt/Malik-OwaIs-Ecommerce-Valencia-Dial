@php
    $isActive = request()->routeIs('admin.maintenance.*');
@endphp

@extends('layouts.admin')

@section('title', 'Maintenance Settings')

@push('styles')
<style>
    .m-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }
    .m-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .status-badge {
        transition: all 0.4s ease;
    }
    .toggle-track {
        width: 52px;
        height: 28px;
        border-radius: 14px;
        cursor: pointer;
        transition: background 0.3s ease;
        position: relative;
    }
    .toggle-track .toggle-thumb {
        width: 22px;
        height: 22px;
        background: white;
        border-radius: 50%;
        position: absolute;
        top: 3px;
        left: 3px;
        transition: transform 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .toggle-track.active {
        background: #059669;
    }
    .toggle-track.active .toggle-thumb {
        transform: translateX(24px);
    }
    .toggle-track.inactive {
        background: #d1d5db;
    }
    .preview-box {
        background: #0c0c0e;
        border-radius: 16px;
        border: 1px solid rgba(212, 175, 55, 0.15);
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Maintenance</h2>
            <p class="text-gray-500 mt-1 text-sm">Control public access and configure the maintenance page</p>
        </div>
        <span class="status-badge px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider {{ $maintenanceMode === '1' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
            <i class="fas fa-circle text-[8px] mr-2 {{ $maintenanceMode === '1' ? 'text-red-500' : 'text-emerald-500' }}"></i>
            {{ $maintenanceMode === '1' ? 'Site is Down' : 'Site is Live' }}
        </span>
    </div>

    @if(session('success'))
        <div class="m-card p-4 mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.maintenance.update') }}" method="POST">
        @csrf

        {{-- Main Toggle Card --}}
        <div class="m-card p-8 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Maintenance Mode</h3>
                    <p class="text-gray-500 text-sm mt-1">When enabled, all frontend traffic sees the 503 maintenance page. Admin panel remains accessible.</p>
                </div>
                <label class="toggle-track {{ $maintenanceMode === '1' ? 'active' : 'inactive' }}" id="toggleTrack">
                    <input type="hidden" name="maintenance_mode" id="maintenanceModeInput" value="{{ $maintenanceMode }}">
                    <div class="toggle-thumb" id="toggleThumb"></div>
                </label>
            </div>
        </div>

        {{-- Settings Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            
            {{-- Maintenance Message --}}
            <div class="m-card p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Maintenance Message</h3>
                <p class="text-gray-500 text-xs mb-4">Displayed on the 503 error page</p>
                <textarea name="maintenance_message" rows="5" 
                    class="w-full border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400 resize-none"
                    placeholder="Enter a message for your visitors...">{{ old('maintenance_message', $maintenanceMessage) }}</textarea>
                @error('maintenance_message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- End Time + IP Whitelist --}}
            <div class="space-y-6">
                <div class="m-card p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Estimated Return</h3>
                    <p class="text-gray-500 text-xs mb-4">Optional — shown on the maintenance page</p>
                    <input type="text" name="maintenance_end_time" 
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                        placeholder="e.g. Returning in 2 hours, Back by 6 PM EST"
                        value="{{ old('maintenance_end_time', $maintenanceEndTime) }}">
                    @error('maintenance_end_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="m-card p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">IP Whitelist</h3>
                    <p class="text-gray-500 text-xs mb-4">Comma-separated IPs that can bypass maintenance</p>
                    <input type="text" name="maintenance_whitelist_ips" 
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
                        placeholder="192.168.1.1, 10.0.0.1"
                        value="{{ old('maintenance_whitelist_ips', $whitelistIps) }}">
                    @error('maintenance_whitelist_ips')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Live Preview --}}
        <div class="m-card p-8 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Preview Maintenance Page</h3>
                <button type="button" id="refreshPreview" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                    <i class="fas fa-sync-alt mr-1"></i> Refresh Preview
                </button>
            </div>
            <div class="preview-box p-8 text-center" id="previewBox">
                <div class="max-w-lg mx-auto">
                    <div class="mb-4">
                        <svg class="w-16 h-16 mx-auto text-[#d4af37] opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.5">
                            <circle cx="12" cy="12" r="3" fill="currentColor"/>
                            <path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-2 tracking-wide" style="font-family: 'Playfair Display', serif;">
                        503 — <span class="text-[#d4af37]">Maintenance</span>
                    </h4>
                    <div class="w-12 h-[1px] mx-auto mb-4" style="background: rgba(212,175,55,0.3);"></div>
                    <p class="text-stone-400 text-sm leading-relaxed" id="previewMessage">
                        {{ $maintenanceMessage ?: 'Our atelier is currently undergoing enhancements...' }}
                    </p>
                    <p class="text-[#d4af37] text-xs mt-4 tracking-wider uppercase font-medium" id="previewEndTime">
                        {{ $maintenanceEndTime ? "~ {$maintenanceEndTime}" : '' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
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
@endsection

@push('scripts')
<script>
    // Toggle switch
    const toggleTrack = document.getElementById('toggleTrack');
    const toggleInput = document.getElementById('maintenanceModeInput');
    const statusBadge = document.querySelector('.status-badge');

    if (toggleTrack) {
        toggleTrack.addEventListener('click', function() {
            const current = toggleInput.value;
            const newVal = current === '1' ? '0' : '1';
            toggleInput.value = newVal;

            if (newVal === '1') {
                this.classList.remove('inactive');
                this.classList.add('active');
                statusBadge.innerHTML = '<i class="fas fa-circle text-[8px] mr-2 text-red-500"></i> Site is Down';
                statusBadge.className = 'status-badge px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-red-100 text-red-700';
            } else {
                this.classList.remove('active');
                this.classList.add('inactive');
                statusBadge.innerHTML = '<i class="fas fa-circle text-[8px] mr-2 text-emerald-500"></i> Site is Live';
                statusBadge.className = 'status-badge px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700';
            }
        });
    }

    // Live preview update
    const messageInput = document.querySelector('textarea[name="maintenance_message"]');
    const endTimeInput = document.querySelector('input[name="maintenance_end_time"]');
    const previewMessage = document.getElementById('previewMessage');
    const previewEndTime = document.getElementById('previewEndTime');

    if (messageInput && previewMessage) {
        messageInput.addEventListener('input', function() {
            previewMessage.textContent = this.value || 'Our atelier is currently undergoing enhancements...';
        });
    }

    if (endTimeInput && previewEndTime) {
        endTimeInput.addEventListener('input', function() {
            previewEndTime.textContent = this.value ? '~ ' + this.value : '';
        });
    }

    document.getElementById('refreshPreview')?.addEventListener('click', function() {
        if (messageInput) messageInput.dispatchEvent(new Event('input'));
        if (endTimeInput) endTimeInput.dispatchEvent(new Event('input'));
    });
</script>
@endpush
