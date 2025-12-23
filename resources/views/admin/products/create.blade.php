@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">➕ Add New Product</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            
            {{-- ✅ SUCCESS MESSAGE ALERT --}}
            {{-- This checks if the controller sent a 'success' message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Validation Errors --}}
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

            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="row">
                    {{-- Naming and Identification --}}
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="barcode" class="form-label">Barcode:</label>
                        <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}" placeholder="Unique Barcode">
                    </div>
                    
                    {{-- Relationships (Categories & Suppliers) --}}
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category:</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="supplier_id" class="form-label">Supplier:</label>
                        <select name="supplier_id" class="form-select" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pricing and Inventory Controls --}}
                    <div class="col-md-4 mb-3">
                        <label for="cost_price" class="form-label">Cost Price ($):</label>
                        <input type="number" step="0.01" name="cost_price" class="form-control" value="{{ old('cost_price', 0.00) }}" required>
                        <small class="text-muted">Price paid to supplier.</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sale_price" class="form-label">Sale Price ($):</label>
                        <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', 0.00) }}" required>
                        <small class="text-muted">Must be greater than cost price.</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="min_stock" class="form-label">Minimum Stock Level:</label>
                        <input type="number" name="min_stock" class="form-control" value="{{ old('min_stock', 5) }}" required>
                        <small class="text-muted">Triggers low-stock warning.</small>
                    </div>
                    
                    <div class="col-md-12 mb-4">
                        <p class="alert alert-info">Stock Quantity will start at **0** and must be added via the **Purchases** module.</p>
                    </div>
                </div>

                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Product</button>
            </form>
        </div>
    </div>
</div>
@endsection