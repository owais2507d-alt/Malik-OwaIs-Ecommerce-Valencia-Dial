@extends('layouts.admin')

@section('title', 'Bespoke Inventory - Valencia')

@section('content')

<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <h1 class="text-4xl font-semibold tracking-tight text-gray-900">Vault Inventory</h1>
            <p class="text-gray-600 mt-2 text-lg">Exclusive Timepieces • Live Collection</p>
        </div>

        <a href="{{ route('admin.watches.create') }}" 
           class="group inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-7 py-4 rounded-3xl shadow-xl shadow-blue-500/30 transition-all duration-200 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform group-active:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Add Masterpiece</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-3xl px-6 py-4 flex items-center gap-3">
            <span class="text-2xl">🎉</span>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="card overflow-hidden">

        <!-- Table Header -->
        <div class="px-6 py-5 border-b flex flex-col sm:flex-row gap-4 items-center justify-between bg-white">
            <h3 class="font-semibold text-xl text-gray-800">Active Stock ({{ $watches->count() }})</h3>
            
            <div class="relative w-full sm:w-80">
                <input type="text" id="searchInput" placeholder="Search by name, brand..." 
                       class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-3xl focus:outline-none focus:border-blue-400 text-sm">
                <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b text-xs uppercase font-semibold text-gray-500">
                        <th class="py-5 px-6 text-left">Preview</th>
                        <th class="py-5 px-6 text-left">Masterpiece</th>
                        <th class="py-5 px-6 text-left">Brand</th>
                        <th class="py-5 px-6 text-right">Valuation</th>
                        <th class="py-5 px-6 text-center">Stock</th>
                        <th class="py-5 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($watches as $watch)
                    <tr class="hover:bg-blue-50/50 transition-colors group">
                        <td class="px-6 py-5">
                            @if($watch->image)
                                <div class="w-16 h-16 rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                                    <img src="{{ asset('storage/' . $watch->image) }}" alt="{{ $watch->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                </div>
                            @else
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 text-xs">No Image</div>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="font-semibold text-gray-900">{{ $watch->name }}</div>
                            <div class="text-xs text-gray-500 line-clamp-2 mt-1">{{ Str::limit($watch->description, 85) }}</div>
                        </td>
                        <td class="px-6 py-5 font-medium text-gray-700">{{ $watch->brand }}</td>
                        <td class="px-6 py-5 text-right font-bold text-lg text-gray-900">
                            ${{ number_format($watch->price, 2) }}
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($watch->stock > 0)
                                <span class="inline-flex px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-2xl text-xs font-semibold">
                                    {{ $watch->stock }} Available
                                </span>
                            @else
                                <span class="inline-flex px-4 py-1.5 bg-red-100 text-red-700 rounded-2xl text-xs font-semibold">
                                    Out of Stock
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-4">
                                <a href="{{ route('admin.watches.edit', $watch->id) }}" 
                                   class="text-blue-600 hover:text-blue-700 transition-colors">
                                    <i class="fas fa-edit text-xl"></i>
                                </a>
                                <form action="{{ route('admin.watches.destroy', $watch->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this masterpiece?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 transition-colors">
                                        <i class="fas fa-trash text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-box-open text-5xl mb-4"></i>
                                <p class="text-xl">Vault is empty</p>
                                <p class="text-sm mt-2">Add your first masterpiece</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden p-4 space-y-5">
            @forelse($watches as $watch)
            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex gap-5">
                    @if($watch->image)
                        <div class="w-24 h-24 rounded-2xl overflow-hidden flex-shrink-0 border">
                            <img src="{{ asset('storage/' . $watch->image) }}" alt="" class="w-full h-full object-cover">
                        </div>
                    @endif
                    
                    <div class="flex-1">
                        <div class="font-semibold text-lg text-gray-900">{{ $watch->name }}</div>
                        <div class="text-gray-600">{{ $watch->brand }}</div>
                        <div class="text-2xl font-bold text-gray-900 mt-2">${{ number_format($watch->price) }}</div>
                        
                        <div class="mt-4">
                            @if($watch->stock > 0)
                                <span class="text-emerald-600 bg-emerald-50 px-3 py-1 rounded-2xl text-sm font-medium">● {{ $watch->stock }} in stock</span>
                            @else
                                <span class="text-red-600 bg-red-50 px-3 py-1 rounded-2xl text-sm font-medium">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-6">
                    <a href="{{ route('admin.watches.edit', $watch->id) }}" 
                       class="text-center py-3 bg-blue-50 text-blue-700 rounded-2xl font-semibold hover:bg-blue-100 transition-all">
                        Edit
                    </a>
                    <form action="{{ route('admin.watches.destroy', $watch->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this masterpiece?')" 
                                class="w-full py-3 bg-red-50 text-red-600 rounded-2xl font-semibold hover:bg-red-100 transition-all">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <i class="fas fa-box-open text-6xl mb-4 opacity-50"></i>
                <p class="text-xl">No watches yet</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    // Live Search
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const term = this.value.toLowerCase().trim();
            
            // Desktop Table Rows
            document.querySelectorAll('tbody tr').forEach(row => {
                if (row.textContent.toLowerCase().includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Mobile Cards
            document.querySelectorAll('.md\\:hidden .bg-white').forEach(card => {
                if (card.textContent.toLowerCase().includes(term)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
</script>
@endpush