@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Stock Adjustment</h1>
            <p class="text-sm text-gray-500">Correcting log entry #{{ $stockAdjustment->id }}</p>
        </div>
    </div>

    @if ($errors->any() || session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            {{ session('error') }}
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl p-6">
        <form action="{{ route('admin.stock_adjustments.update', $stockAdjustment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                    <select name="product_id" class="w-full rounded-lg border-gray-300 focus:ring-blue-500" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $stockAdjustment->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Current: {{ $product->stock_qty }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adjustment Type</label>
                        <select name="type" class="w-full rounded-lg border-gray-300 focus:ring-blue-500" required>
                            <option value="increase" {{ old('type', $stockAdjustment->type) == 'increase' ? 'selected' : '' }}>Add (+) Stock</option>
                            <option value="decrease" {{ old('type', $stockAdjustment->type) == 'decrease' ? 'selected' : '' }}>Remove (-) Stock</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" name="qty" value="{{ old('qty', $stockAdjustment->qty) }}" 
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500" min="1" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Adjustment</label>
                    <textarea name="reason" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-blue-500" required placeholder="e.g. Damage, Inventory count error...">{{ old('reason', $stockAdjustment->reason) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.stock_adjustments.index') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                    Update & Correct Inventory
                </button>
            </div>
        </form>
    </div>
</div>
@endsection