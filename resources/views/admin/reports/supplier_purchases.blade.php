@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="mb-4"> <b>Supplier Spending Report</b></h2>

    <div class="card shadow-sm">
        <div class="card-header">Total Spending Grouped by Supplier</div>
        <div class="card-body">
            @if($supplierPurchases->isEmpty())
                <div class="alert alert-info">No purchase history found.</div>
            @else
                @php
                    $grandTotalSpent = $supplierPurchases->sum('total_spent');
                @endphp
                <p class="lead fw-bold">Grand Total Spent on Inventory: <span class="text-primary">${{ number_format($grandTotalSpent, 2) }}</span></p>

                <table class="table table-bordered table-striped table-hover mt-3">
                    <thead>
                        <tr>
                            <th width="5%">Rank</th>
                            <th width="20%">Supplier Name</th>
                            <th width="15%">Total Invoices</th>
                            <th width="20%">Total Amount Spent</th>
                            <th width="15%">Percentage of Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplierPurchases as $index => $summary)
                        <tr>
                            <td class="fw-bold" class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $summary->supplier->name ?? 'Deleted Supplier' }}</td>
                            <td class="text-center">{{ $summary->total_invoices }}</td>
                            <td class="text-center" class="fw-bold text-success">${{ number_format($summary->total_spent, 2) }}</td>
                            <td class="text-center">
                                @php
                                    $percentage = ($summary->total_spent / $grandTotalSpent) * 100;
                                @endphp
                                {{ number_format($percentage, 2) }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection