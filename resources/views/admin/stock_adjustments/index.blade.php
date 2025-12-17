@extends('layouts.app')

@section('page-title', 'Stock Adjustments')

@section('content')
<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">📦 Stock Adjustments</h2>

        <a href="{{ route('admin.stock_adjustments.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + New Adjustment
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Product</th>
                    <th class="p-2 text-left">Type</th>
                    <th class="p-2 text-left">Quantity</th>
                    <th class="p-2 text-left">Reason</th>
                    <th class="p-2 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adjustments as $adj)
                    <tr class="">
                        <td class="p-3 text-center">{{ $adj->product->name }}</td>
                        <td class="p-3 text-center">
                            <span class="{{ $adj->type === 'increase' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($adj->type) }}
                            </span>
                        </td>
                        <td class="p-3 text-center">{{ $adj->qty }}</td>
                        <td class="p-3 text-center">{{ $adj->reason }}</td>
                        <td class="p-3 text-center">{{ $adj->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            No stock adjustments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
