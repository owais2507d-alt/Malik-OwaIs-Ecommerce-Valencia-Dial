@extends('layouts.admin')

@section('title', 'Bespoke Inventory - Valencia')

@section('content')
    <!-- Dashboard Sub-Header Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight" style="color: var(--text-main);">Hi, Administrator</h1>
            <p class="text-stone-400 text-xs mt-0.5">Manage, track and catalog current live store luxury watch stocks.</p>
        </div>
        <a href="{{ route('admin.watches.create') }}" class="smooth-transition text-xs font-semibold px-5 py-3 shadow-md rounded-xl text-white hover:opacity-90 flex items-center space-x-2" 
           style="background-color: var(--bg-topbar);">
            <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>Add Masterpiece</span>
        </a>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="text-xs py-3.5 px-4 rounded-xl font-medium border flex items-center space-x-2 bg-emerald-50 border-emerald-200 text-emerald-700">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Fox Style Clean White Surface Card -->
    <div class="rounded-2xl shadow-sm border border-stone-100 overflow-hidden" style="background-color: var(--bg-card);">
        <div class="p-5 border-b border-stone-100 flex items-center justify-between">
            <h3 class="text-sm font-bold" style="color: var(--text-main);">Active Vault Stock</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="text-[11px] uppercase tracking-wider font-semibold text-stone-400 border-b border-stone-100 bg-stone-50/70">
                        <th class="py-4 px-6 w-24 text-center">Preview</th>
                        <th class="py-4 px-6">Product Details</th>
                        <th class="py-4 px-6">Brand House</th>
                        <th class="py-4 px-6">Valuation</th>
                        <th class="py-4 px-6">Stock Status</th>
                        <th class="py-4 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-xs divide-stone-100" style="color: var(--text-main);">
                    @forelse($watches as $watch)
                        <tr class="hover:bg-stone-50/50 transition-colors duration-150">
                            <!-- Image -->
                            <td class="py-4 px-6 text-center">
                                @if($watch->image)
                                    <div class="w-11 h-12 bg-stone-50 border border-stone-200 rounded-lg overflow-hidden p-0.5 inline-block">
                                        <img src="{{ asset('storage/' . $watch->image) }}" alt="Watch" class="w-full h-full object-cover rounded-md">
                                    </div>
                                @else
                                    <div class="w-11 h-12 bg-stone-100 rounded-lg flex items-center justify-center text-[9px] text-stone-400 font-bold inline-lock pt-4">N/A</div>
                                @endif
                            </td>
                            
                            <!-- Name & Desc -->
                            <td class="py-4 px-6">
                                <span class="text-sm font-bold block" style="color: var(--text-main);">{{ $watch->name }}</span>
                                <span class="text-stone-400 text-xs font-normal max-w-xs block truncate mt-0.5">{{ $watch->description ?? 'No tracking chronicles logged.' }}</span>
                            </td>
                            
                            <!-- Brand -->
                            <td class="py-4 px-6 font-medium text-stone-600">{{ $watch->brand }}</td>
                            
                            <!-- Price -->
                            <td class="py-4 px-6 font-bold text-sm" style="color: var(--text-main);">
                                ${{ number_format($watch->price, 2) }}
                            </td>
                            
                            <!-- Stock Status badge -->
                            <td class="py-4 px-6">
                                @if($watch->stock > 0)
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-600">
                                        {{ $watch->stock }} Units Available
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-red-50 border border-red-100 text-red-600">
                                        Out of Stock
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Actions Buttons -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2.5">
                                    <a href="{{ route('admin.watches.edit', $watch->id) }}" class="smooth-transition text-stone-400 hover:text-blue-600 p-1.5 hover:bg-blue-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.watches.destroy', $watch->id) }}" method="POST" onsubmit="return confirm('Remove this masterpiece from active records?');" class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="smooth-transition text-stone-400 hover:text-red-600 p-1.5 hover:bg-red-50 rounded-lg cursor-pointer border-0 inline-flex items-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-16v1a3 3 0 003 3h10M9 3h6m-6 0a1 1 0 001-1v1a1 1 0 00-1-1H9z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-stone-400 font-medium tracking-wide">
                                Your showcase matrix is completely empty.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection