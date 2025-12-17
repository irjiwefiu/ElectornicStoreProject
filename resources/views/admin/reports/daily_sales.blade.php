@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <h1 class="mb-4 text-xl"><b>📊 Daily Sales Report - {{ today()->format('M d, Y') }}</b></h1>

    <div class="card shadow-sm mb-4">
        <h2 class="card-header bg-success "><b>Summary</b></h2>
        <div class="card-body">
            @php
                $totalRevenue = $dailySales->sum('total_amount');
                $totalSales = $dailySales->count();
            @endphp
            <div class="row">
                <div class="col-md-6">
                    <p class="lead fw-bold">Total Revenue Today: <span class="text-success">${{ number_format($totalRevenue, 2) }}</span></p>
                </div>
                <div class="col-md-6">
                    <p class="lead fw-bold">Total Sales Transactions: <span class="text-info">{{ $totalSales }}</span></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header"><b>Detailed Transactions</b></div>
        <div class="card-body">
            @if($dailySales->isEmpty())
                <div class="alert alert-warning">No sales recorded today.</div>
            @else
                <table class="">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="20%">Time</th>
                            <th width="10%">Cashier</th>
                            <th width="10%">Items Sold</th>
                            <th width="10%">Total Amount</th>
                            <th width="10%">Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dailySales as $sale)
                        <tr>
                            <td class="text-center">{{ $sale->id }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($sale->created_at)->format('h:i:s A') }}</td>
                            <td class="text-center">{{ $sale->user->name ?? 'N/A' }}</td>
                            {{-- Assuming 'items' relationship exists on Sale model --}}
                            <td class="text-center">{{ $sale->items->sum('qty') ?? 0 }}</td> 
                            <td class="text-center">${{ number_format($sale->total_amount, 2) }}</td>
                            <td class="text-center">cash</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection