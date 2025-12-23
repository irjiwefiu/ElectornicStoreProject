@extends('layouts.app')

@section('page-title', 'Add Category')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-bold mb-4">➕ New Category</h2>

    {{-- Added enctype="multipart/form-data" which is required for file uploads --}}
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror"
                   required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">{{ old('description') }}</textarea>
        </div>

        {{-- New Image Input Field --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Category Image</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200 @error('image') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Allowed formats: JPG, PNG. Max size: 2MB.</p>
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}"
               class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancel
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save Category
            </button>
        </div>
    </form>
</div>
@endsection