@extends('layouts.app')

@section('page-title', 'Products')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">📦 Products</h2>
        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Product
        </a>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Category</th>
                <th class="p-2 text-left">Price</th>
                <th class="p-2 text-left">Stock</th>
                <th class="p-2 text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-2">{{ $product->name }}</td>
                    <td class="p-2">{{ $product->category->name }}</td>
                    <td class="p-2">Rs {{ number_format($product->sale_price) }}</td>
                    <td class="p-2">{{ $product->stock_qty }}</td>
                    <td class="p-2 text-right">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="text-blue-600"><b>Edit</b></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-6">No products found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
