@extends('layouts.app')

@section('page-title', 'POS / New Sale')

@section('content')
<form method="POST" action="{{ route('cashier.sales.store') }}" id="posForm">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ================= PRODUCTS ================= --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h2 class="font-bold mb-4 text-lg">🛒 Products</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($products as $product)
                <button type="button"
                    onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sale_price }})"
                    class="border rounded-lg p-3 hover:bg-gray-100 text-left transition">
                    <div class="font-semibold">{{ $product->name }}</div>
                    <div class="text-sm text-gray-500">
                        Rs {{ number_format($product->sale_price) }}
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    {{-- ================= CART ================= --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-bold mb-4 text-lg">🧾 Cart</h2>

        <table class="w-full text-sm mb-4">
            <thead class="border-b">
                <tr class="text-left">
                    <th>Item</th>
                    <th width="60">Qty</th>
                    <th width="80">Total</th>
                    <th width="30"></th>
                </tr>
            </thead>
            <tbody id="cart-body"></tbody>
        </table>

        {{-- TOTAL --}}
        <div class="flex justify-between font-bold mb-2">
            <span>Subtotal</span>
            <span>Rs <span id="subtotal">0</span></span>
        </div>

        {{-- PAID --}}
        <div class="mb-2">
            <label class="text-sm">Paid Amount</label>
            <input type="number" step="0.01" id="paid_amount"
                   class="w-full border rounded px-2 py-1"
                   oninput="calculateChange()">
        </div>

        {{-- CHANGE --}}
        <div class="flex justify-between font-bold mb-4">
            <span>Change</span>
            <span>Rs <span id="change">0</span></span>
        </div>

        {{-- HIDDEN TOTALS --}}
        <input type="hidden" name="subtotal" id="subtotal_input">
        <input type="hidden" name="total" id="total_input">
        <input type="hidden" name="paid_amount" id="paid_input">

        {{-- ACTION --}}
        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            💾 Save Sale
        </button>
    </div>

</div>
</form>

{{-- ================= JS ================= --}}
<script>
let cart = {};

function addToCart(id, name, price) {
    if (!cart[id]) {
        cart[id] = { product_id: id, name, price, qty: 1 };
    } else {
        cart[id].qty++;
    }
    renderCart();
}

function removeItem(id) {
    delete cart[id];
    renderCart();
}

function updateQty(id, qty) {
    cart[id].qty = Math.max(1, parseInt(qty));
    renderCart();
}

function renderCart() {
    let body = document.getElementById('cart-body');
    let subtotal = 0;
    body.innerHTML = '';

    let index = 0;
    Object.values(cart).forEach(item => {
        let lineTotal = item.qty * item.price;
        subtotal += lineTotal;

        body.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>
                    <input type="number" min="1" value="${item.qty}"
                        onchange="updateQty(${item.product_id}, this.value)"
                        class="w-14 border rounded px-1">
                </td>
                <td>Rs ${lineTotal}</td>
                <td>
                    <button type="button" onclick="removeItem(${item.product_id})"
                        class="text-red-500 font-bold">×</button>
                </td>

                <input type="hidden" name="items[${index}][product_id]" value="${item.product_id}">
                <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                <input type="hidden" name="items[${index}][sale_price]" value="${item.price}">
            </tr>
        `;
        index++;
    });

    document.getElementById('subtotal').innerText = subtotal;
    document.getElementById('subtotal_input').value = subtotal;
    document.getElementById('total_input').value = subtotal;
    calculateChange();
}

function calculateChange() {
    let subtotal = parseFloat(document.getElementById('subtotal').innerText) || 0;
    let paid = parseFloat(document.getElementById('paid_amount').value) || 0;

    document.getElementById('paid_input').value = paid;
    document.getElementById('change').innerText = (paid - subtotal).toFixed(2);
}

// Prevent empty cart
document.getElementById('posForm').addEventListener('submit', function (e) {
    if (Object.keys(cart).length === 0) {
        e.preventDefault();
        alert('Cart is empty');
    }
});
</script>
@endsection
