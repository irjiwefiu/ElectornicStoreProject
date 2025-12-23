@extends('layouts.app')

@section('page-title', 'Category Management')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">🏷 Categories</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your product categories and their images.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition shadow-md font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Category
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm flex items-center justify-between animate-fade-in-down">
            <div>
                <span class="font-bold">Success!</span> {{ session('success') }}
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">&times;</button>
        </div>
    @endif

    {{-- Table Section --}}
    <div class="overflow-x-auto rounded-lg border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 font-semibold">ID</th>
                    <th class="p-4 font-semibold">Image</th>
                    <th class="p-4 font-semibold">Details</th>
                    <th class="p-4 font-semibold text-center">Products</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-blue-50/50 transition duration-150 ease-in-out group">
                        
                        {{-- ID --}}
                        <td class="p-4 text-gray-500 font-mono text-sm">#{{ $category->id }}</td>
                        
                        {{-- Image Column (FORCED INLINE STYLES) --}}
                        <td class="p-4">
                            @php
                                $imageSrc = $category->image ? asset('storage/' . $category->image) : null;
                            @endphp

                            @if($imageSrc)
                                {{-- We apply style="width: 50px; height: 50px;" directly here --}}
                                <div class="rounded overflow-hidden shadow-sm border border-gray-200 group-hover:border-blue-200 transition" 
                                     style="width: 50px; height: 50px;">
                                    
                                    <img src="{{ $imageSrc }}" 
                                         alt="{{ $category->name }}"
                                         loading="lazy"
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         class="cursor-pointer hover:scale-110 transition duration-300"
                                         onclick="openImageModal('{{ $imageSrc }}')"
                                         title="Click to enlarge"
                                         onerror="this.onerror=null; this.src='https://placehold.co/400?text=Err';"> 
                                </div>
                            @else
                                {{-- Placeholder also forced to 50px --}}
                                <div class="bg-gray-100 rounded flex items-center justify-center border border-gray-200 text-gray-400"
                                     style="width: 50px; height: 50px;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>

                        {{-- Name & Description --}}
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $category->name }}</div>
                            <div class="text-xs text-gray-500 mt-1 max-w-xs truncate">
                                {{ $category->description ?? 'No description provided.' }}
                            </div>
                        </td>

                        {{-- Product Count --}}
                        <td class="p-4 text-center">
                            @if($category->products_count > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $category->products_count }} items
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    Empty
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                {{-- Edit Button --}}
                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                   class="text-gray-400 hover:text-blue-600 transition p-1 rounded-full hover:bg-blue-50"
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-gray-400 hover:text-red-600 transition p-1 rounded-full hover:bg-red-50 {{ $category->products_count ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            title="Delete"
                                            {{ $category->products_count ? 'disabled' : '' }}>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500 bg-gray-50 rounded-b-lg">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-lg font-medium">No categories found</p>
                                <p class="text-sm mt-1">Get started by adding your first category.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL FOR IMAGE PREVIEW --}}
<div id="imageModal" 
     class="fixed inset-0 z-50 hidden bg-gray-900/90 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300"
     onclick="closeImageModal()">
    
    <div class="relative max-w-4xl w-full flex flex-col items-center">
        <button class="absolute -top-12 right-0 text-white hover:text-gray-300 transition focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <img id="modalImageDisplay" src="" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain ring-4 ring-white/10">
        <p class="text-white/70 mt-4 text-sm font-light">Click anywhere to close</p>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const imgDisplay = document.getElementById('modalImageDisplay');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        imgDisplay.src = imageSrc;
        modal.classList.remove('hidden');
        modal.classList.add('flex'); 
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        
        // Restore body scroll
        document.body.style.overflow = 'auto';

        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        setTimeout(() => {
             document.getElementById('modalImageDisplay').src = ''; 
        }, 200);
    }
</script>
@endsection