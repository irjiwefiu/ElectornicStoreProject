@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">
    <h1 class="text-2xl font-bold mb-6">📊 Reports</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="{{ route('admin.reports.daily_sales') }}"
           class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
            <h2 class="text-lg font-semibold">📈 Daily Sales</h2>
            <p class="text-sm text-gray-500 mt-2">
                View daily revenue & transactions
            </p>
        </a>

        <a href="{{ route('admin.reports.inventory_health') }}"
           class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
            <h2 class="text-lg font-semibold">📦 Inventory Health</h2>
            <p class="text-sm text-gray-500 mt-2">
                Low stock & inventory status
            </p>
        </a>

        <a href="{{ route('admin.reports.supplier_purchases') }}"
           class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
            <h2 class="text-lg font-semibold">🚚 Supplier Purchases</h2>
            <p class="text-sm text-gray-500 mt-2">
                Purchases by supplier
            </p>
        </a>

    </div>
</div>
@endsection
