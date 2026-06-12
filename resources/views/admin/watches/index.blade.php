@extends('layouts.admin')

@section('title', 'Watch Inventory - Valencia Admin')

@section('content')
    <div class="flex justify-between items-center">
        <div class="text-[10px] uppercase tracking-[0.3em] text-stone-400">
            Admin <span class="mx-2 text-stone-300">/</span> <span class="text-stone-900 font-semibold">Vault Inventory</span>
        </div>
        <a href="{{ route('admin.watches.create') }}" class="smooth-transition text-[10px] uppercase tracking-[0.25em] px-5 py-3.5 font-bold shadow-sm flex items-center space-x-2 bg-black text-white hover:bg-stone-800 border border-black">
            <svg class="w-3.5 h-3.5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>Add Masterpiece</span>
        </a>
    </div>

    <div class="space-y-1">
        <h1 class="luxury-title text-3xl md:text-4xl font-light tracking-wide text-stone-900">Bespoke Collection</h1>
        <p class="text-stone-500 text-xs font-light">Curate, update, and audit active luxury items across the public boutique.</p>
    </div>

    @if(session('success'))
        <div class="border text-xs py-3.5 px-5 rounded-none text-center tracking-wide uppercase font-semibold bg-emerald-50 border-emerald-200 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="border rounded-none overflow-hidden shadow-sm bg-white border-stone-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="text-[10px] uppercase tracking-[0.25em] text-stone-500 border-b border-stone-200 bg-stone-50">
                        <th class="py-5 px-6 w-20 text-center font-semibold">Piece</th>
                        <th class="py-5 px-6 font-semibold">Product Details</th>
                        <th class="py-5 px-6 font-semibold">Brand House</th>
                        <th class="py-5 px-6 font-semibold">Valuation</th>
                        <th class="py-5 px-6 font-semibold">Status / Stock</th>
                        <th class="py-5 px-6 text-center font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-xs font-light text-stone-700 divide-stone-100">
                    @forelse($watches as $watch)
                        <tr class="hover:bg-stone-50/80 transition-colors duration-200">
                            <td class="py-4 px-6 text-center">
                                @if($watch->image)
                                    <div class="w-12 h-14 bg-stone-50 border border-stone-200 overflow-hidden p-0.5 inline-block">
                                        <img src="{{ asset('storage/' . $watch->image) }}" alt="Bespoke Watch" class="w-full h-full object-cover select-none">
                                    </div>
                                @else
                                    <div class="w-12 h-14 bg-stone-100 border border-stone-200 flex items-center justify-center text-[8px] uppercase tracking-widest text-stone-400 font-medium inline-bloc pt-5">Void</div>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6">
                                <span class="text-sm font-medium text-stone-900 tracking-wide block mb-0.5">{{ $watch->name }}</span>
                                <span class="text-stone-400 text-xs font-light max-w-xs block truncate">{{ $watch->description ?? 'No specifications logged.' }}</span>
                            </td>
                            
                            <td class="py-4 px-6 uppercase tracking-[0.15em] text-stone-600 font-semibold text-[10px]">{{ $watch->brand }}</td>
                            
                            <td class="py-4 px-6 font-semibold text-sm text-stone-900">
                                ${{ number_format($watch->price, 2) }}
                            </td>
                            
                            <td class="py-4 px-6">
                                @if($watch->stock > 0)
                                    <span class="text-[9px] uppercase font-bold tracking-wider text-emerald-700 px-2.5 py-1 bg-emerald-50 border border-emerald-200">
                                        {{ $watch->stock }} Units Available
                                    </span>
                                @else
                                    <span class="text-[9px] uppercase font-bold tracking-wider text-red-600 px-2.5 py-1 bg-red-50 border border-red-100">
                                        Depleted Vault
                                    </span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-4">
                                    
                                    <a href="{{ route('admin.watches.edit', $watch->id) }}" title="Modify Frame" class="smooth-transition text-stone-400 hover:text-stone-900 p-1">
                                        <svg class="w-4 h-4 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form action="{{ route('admin.watches.destroy', $watch->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently exile this masterpiece from the vault?');" class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Exile from Vault" class="smooth-transition text-stone-300 hover:text-red-600 p-1 cursor-pointer bg-transparent border-0 inline-flex items-center outline-none">
                                            <svg class="w-4 h-4 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-16v1a3 3 0 003 3h10M9 3h6m-6 0a1 1 0 001-1v1a1 1 0 00-1-1H9z"/></svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-stone-400 tracking-widest text-xs uppercase bg-stone-50/50">
                                The inventory vault remains empty.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection