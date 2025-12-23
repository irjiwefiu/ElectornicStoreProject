@extends('layouts.app')

@section('page-title', 'Add Category')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-bold mb-4">➕ New Category</h2>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
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
