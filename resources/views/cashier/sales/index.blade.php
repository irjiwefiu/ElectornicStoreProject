@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-6">

    <h2 class="text-xl font-bold mb-4">📜 Sales History</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Invoice</th>
                    <th class="p-3 text-left">Subtotal</th>
                    <th class="p-3 text-left">Total</th>
                    <th class="p-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 text-center">{{ $sale->invoice_no }}</td>
                        <td class="p-3 text-center">{{ number_format($sale->subtotal, 2) }}</td>
                        <td class="p-3 text-center">{{ number_format($sale->total, 2) }}</td>
                        <td class="p-3 text-center">{{ $sale->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            No sales found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
