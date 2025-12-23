@extends('layouts.app')

@section('page-title', 'Edit Category')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-bold mb-4">✏️ Edit Category</h2>

    {{-- 1. Added enctype for file support --}}
    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name"
                   value="{{ old('name', $category->name) }}"
                   class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror"
                   required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border rounded px-3 py-2">{{ old('description', $category->description) }}</textarea>
        </div>

        {{-- 2. New Section: Current Image & Upload New --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Category Image</label>
            
            {{-- Show existing image if available --}}
            @if($category->image)
                <div class="mb-2">
                    <p class="text-xs text-gray-500 mb-1">Current Image:</p>
                    <img src="{{ asset('storage/' . $category->image) }}" 
                         alt="Current Image" 
                         class="w-24 h-24 object-cover rounded border">
                </div>
            @endif

            {{-- File Input --}}
            <input type="file" name="image" accept="image/*"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200 @error('image') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Leave blank to keep the current image.</p>
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}"
               class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancel
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection