@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            ✏️ Edit Product
        </h1>
        <p class="text-sm text-gray-500">
            {{ $product->name }} • Current Stock: 
            <span class="font-semibold">{{ $product->stock_qty }}</span>
        </p>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            <strong class="block mb-2">Please fix the following errors:</strong>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card -->
    <div class="bg-white shadow-lg rounded-xl p-6">

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Product Name
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <!-- Barcode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Barcode
                    </label>
                    <input type="text"
                           name="barcode"
                           value="{{ old('barcode', $product->barcode) }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Optional">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Category
                    </label>
                    <select name="category_id"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
