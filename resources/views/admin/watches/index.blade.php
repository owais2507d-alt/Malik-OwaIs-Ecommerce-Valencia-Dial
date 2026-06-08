@extends('layouts.admin')

@section('title', 'Watch Inventory - Valencia Admin')

@section('content')
    <!-- Breadcrumbs -->
    <div class="flex justify-between items-center">
        <div class="text-[10px] uppercase tracking-[0.3em] text-stone-500">
            Admin <span class="mx-2">/</span> <span class="text-stone-300">Vault Inventory</span>
        </div>
        <a href="{{ route('admin.watches.create') }}" class="smooth-transition text-[10px] uppercase tracking-[0.2em] px-5 py-3 font-semibold shadow-2xl flex items-center space-x-2" 
           style="background-color: var(--text-gold); color: black;" onmouseover="this.style.backgroundColor='var(--text-gold-hover)'" onmouseout="this.style.backgroundColor='var(--text-gold)'">
            <svg class="w-3.5 h-3.5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>Add Masterpiece</span>
        </a>
    </div>

    <!-- Title -->
    <div>
        <h1 class="luxury-title text-3xl md:text-4xl font-medium tracking-wide text-white">Bespoke Collection</h1>
        <p class="text-stone-500 text-xs mt-2">Curate, update, and audit active luxury items across the public boutique.</p>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="border text-xs py-3.5 px-5 rounded-none text-center tracking-wide uppercase font-medium"
             style="background-color: rgba(16, 185, 129, 0.03); border-color: rgba(16, 185, 129, 0.15); color: #34d399;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="border rounded-none overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.5)]" style="background-color: var(--bg-card); border-color: var(--border-muted);">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="text-[10px] uppercase tracking-[0.25em] text-stone-500 border-b" style="border-color: var(--border-muted); background-color: #0b0b0e;">
                        <th class="py-5 px-6 w-20 text-center">Piece</th>
                        <th class="py-5 px-6">Product Details</th>
                        <th class="py-5 px-6">Brand House</th>
                        <th class="py-5 px-6">Valuation</th>
                        <th class="py-5 px-6">Status / Stock</th>
                        <th class="py-5 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-xs font-light text-stone-300" style="divide-color: var(--border-muted);">
                    @forelse($watches as $watch)
                        <tr class="hover:bg-[#111116]/40 transition-colors duration-300">
                            <td class="py-4 px-6 text-center">
                                @if($watch->image)
                                    <div class="w-12 h-14 bg-stone-900 border overflow-hidden p-0.5 inline-block" style="border-color: var(--border-muted);">
                                        <img src="{{ asset('storage/' . $watch->image) }}" alt="Bespoke Watch" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-12 h-14 bg-stone-950 border flex items-center justify-center text-[8px] uppercase tracking-widest text-stone-600 inline-block pt-5" style="border-color: var(--border-muted);">Void</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm font-semibold text-white tracking-wide block mb-0.5">{{ $watch->name }}</span>
                                <span class="text-stone-500 text-xs font-light italic max-w-xs block truncate">{{ $watch->description ?? 'No specifications logged.' }}</span>
                            </td>
                            <td class="py-4 px-6 uppercase tracking-[0.15em] text-stone-400 font-medium text-[11px]">{{ $watch->brand }}</td>
                            <td class="py-4 px-6 font-medium text-sm" style="color: var(--text-gold);">
                                ${{ number_format($watch->price, 2) }}
                            </td>
                            <td class="py-4 px-6">
                                @if($watch->stock > 0)
                                    <span class="text-[10px] uppercase font-medium tracking-wider text-emerald-400 px-2.5 py-1 bg-emerald-950/20 border border-emerald-900/40">
                                        {{ $watch->stock }} Active Units
                                    </span>
                                @else
                                    <span class="text-[10px] uppercase font-medium tracking-wider text-red-400 px-2.5 py-1 bg-red-950/20 border border-red-900/40">
                                        Depleted Vault
                                    </span>
                                @endif
                            </td>
                            
                            <!-- UPDATED ACTIONS COLUMN -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    
                                    <!-- EDIT LINK -->
                                    <a href="{{ route('admin.watches.edit', $watch->id) }}" title="Edit Listing" class="smooth-transition text-stone-500 hover:text-white p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <!-- SECURE DELETE FORM -->
                                    <form action="{{ route('admin.watches.destroy', $watch->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently exile this masterpiece from the vault?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Exile from Vault" class="smooth-transition text-stone-600 hover:text-red-400 p-1 cursor-pointer bg-transparent border-0 inline-flex items-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-16v1a3 3 0 003 3h10M9 3h6m-6 0a1 1 0 001-1v1a1 1 0 00-1-1H9z"/></svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-stone-500 tracking-widest text-xs uppercase bg-[#0b0b0e]">
                                The inventory vault remains empty.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection