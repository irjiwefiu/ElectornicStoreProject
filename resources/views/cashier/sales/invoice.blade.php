@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 shadow rounded" id="receipt">

    <h2 class="text-center font-bold text-xl mb-2">🧾 Receipt</h2>
    <p class="text-center text-sm mb-4">Invoice #{{ $sale->invoice_no }}</p>

    <table class="w-full text-sm mb-4">
        @foreach($sale->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td class="text-center">{{ $item->qty }}</td>
            <td class="text-right">₨ {{ $item->subtotal }}</td>
        </tr>
        @endforeach
    </table>

    <hr>

    <div class="flex justify-between font-bold mt-2">
        <span>Total</span>
        <span>₨ {{ $sale->total }}</span>
    </div>

    <div class="flex justify-between text-sm">
        <span>Paid</span>
        <span>₨ {{ $sale->paid_amount }}</span>
    </div>

    <div class="flex justify-between text-sm mb-4">
        <span>Change</span>
        <span>₨ {{ $sale->change_return }}</span>
    </div>

    <button onclick="printReceipt()"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        🖨 Print Receipt
    </button>
</div>

<script>
function printReceipt() {
    let content = document.getElementById('receipt').innerHTML;
    let win = window.open('', '', 'width=400,height=600');
    win.document.write('<html><body>' + content + '</body></html>');
    win.document.close();
    win.print();
}
</script>
@endsection
