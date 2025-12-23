@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">⚙️ New Stock Adjustment</h2>

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">{{ $message }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.stock_adjustments.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="product_id" class="form-label">Product to Adjust:</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">Select Product (Current Stock Qty)</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-stock="{{ $product->stock_qty }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (SKU: {{ $product->sku }}) - Current Stock: {{ $product->stock_qty }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Adjustment Type:</label>
                        <select name="type" class="form-select" required>
                            <option value="increase" {{ old('type') == 'increase' ? 'selected' : '' }}>Increase (Add Stock)</option>
                            <option value="decrease" {{ old('type') == 'decrease' ? 'selected' : '' }}>Decrease (Remove/Write-off Stock)</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="qty" class="form-label">Quantity:</label>
                        <input type="number" name="qty" class="form-control" value="{{ old('qty') }}" min="1" required>
                    </div>
                    
                    <div class="col-md-12 mb-4">
                        <label for="reason" class="form-label">Reason for Adjustment (Required for Audit):</label>
                        <textarea name="reason" class="form-control" style="height:100px" required>{{ old('reason') }}</textarea>
                    </div>
                </div>

                <a href="{{ route('admin.stock_adjustments.index') }}" class="bg-blue-600 text-white px-6 py-4 mx-4 rounded hover:bg-blue-700"><i class="fas fa-arrow-left"></i> Back to Logs</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-4 mx-4 rounded hover:bg-blue-700">
                    <i class="fas fa-wrench"></i> Apply Adjustment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection