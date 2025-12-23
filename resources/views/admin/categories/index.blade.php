@extends('layouts.app')

@section('page-title', 'Category Management')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">🏷 Categories</h2>

        <a href="{{ route('admin.categories.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Description</th>
                <th class="p-3 text-center">Products</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $category->id }}</td>
                    <td class="p-3 font-medium">{{ $category->name }}</td>
                    <td class="p-3 text-sm text-gray-600">
                        {{ Str::limit($category->description, 60) }}
                    </td>
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $category->products_count ? 'bg-blue-100 text-blue-700' : 'bg-gray-200' }}">
                            {{ $category->products_count }}
                        </span>
                    </td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        <form class="inline"
                              method="POST"
                              action="{{ route('admin.categories.destroy', $category->id) }}"
                              onsubmit="return confirm('Delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline"
                                {{ $category->products_count ? 'disabled' : '' }}>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        No categories found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
