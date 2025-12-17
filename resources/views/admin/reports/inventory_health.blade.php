@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-bold">⚠️ Inventory Health Report</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-dark fw-bold">Products Below Minimum Stock Level ({{ $lowStock->count() }} items)</div>
        <div class="card-body">
            @if($lowStock->isEmpty())
                <div class="alert alert-success">All products are currently above their minimum stock levels.</div>
            @else
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th width="10%">Current Stock</th>
                            <th width="10%">Minimum Stock</th>
                            <th width="10%">Order Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowStock as $product)
                        <tr class="{{ $product->stock_qty == 0 ? 'table-danger' : '' }}">
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                            <td class="fw-bold">{{ $product->stock_qty }}</td>
                            <td>{{ $product->min_stock }}</td>
                            <td class="fw-bold text-primary">{{ $product->min_stock * 2 }}</td> {{-- Suggested order quantity (e.g., 2x min stock) --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-danger text-green fw-bold"> <b>Products Out of Stock (Zero Stock) ({{ $zeroStock->count() }} items) </b></div>
        <div class="card-body">
            @if($zeroStock->isEmpty())
                <div class="alert alert-info">No products are completely out of stock.</div>
            @else
                {{-- Display the same table but filtered for zero stock, or use a simplified table --}}
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Product Name</th>
                            <th>Last Supplier</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zeroStock as $product)
                            <tr>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                                <td class="text-danger fw-bold">OUT OF STOCK</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection