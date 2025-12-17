@extends('layouts.app')

@section('page-title', 'Purchases')
    {{-- HEADER --}}
    @section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">🧾 Purchases</h2>
        <a href="{{ route('admin.purchases.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Purchase
        </a>
    </div>


    {{-- CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th class="text-end px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                        <tr class="border-t">
                            <td class="p-2">{{ $purchase->id }}</td>
                            <td class="p-2">{{ $purchase->purchase_date->format('Y-m-d') }}</td>
                            <td class="p-2">{{ $purchase->supplier->name ?? '-' }}</td>
                            <td class="p-2">{{ $purchase->invoice_no }}</td>
                            <td class="p-2">
                                ${{ number_format($purchase->total_amount, 2) }}
                            </td>
                            <td class="text-end px-4 p-2">
                                <a href="#" class="text-decoration-none text-primary fw-semibold">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No purchases found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
