@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                📦 Edit Purchase
            </h1>
            <p class="text-sm text-gray-500">
                Invoice: <span class="font-semibold text-blue-600">{{ $purchase->invoice_no }}</span> • 
                Date: {{ $purchase->purchase_date->format('M d, Y') }}
            </p>
        </div>
        <a href="{{ route('admin.purchases.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
            &larr; Back to List
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            <strong class="block mb-2">Please fix the following errors:</strong>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.purchases.update', $purchase->id) }}" method="POST" id="purchase-form">
        @csrf
        @method('PUT')

        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                    <select name="supplier_id" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Invoice No</label>
                    <input type="text" name="invoice_no" value="{{ old('invoice_no', $purchase->invoice_no) }}" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Date</label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-semibold text-gray-700">Purchase Items</h3>
                <button type="button" id="add-row" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md transition">
                    + Add Product
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-3" style="min-width: 300px;">Product</th>
                            <th class="px-6 py-3">Quantity</th>
                            <th class="px-6 py-3">Cost Price</th>
                            <th class="px-6 py-3 text-right">Subtotal</th>
                            <th class="px-6 py-3 text-center w-10"></th>
                        </tr>
                    </thead>
                    <tbody id="item-list" class="divide-y divide-gray-100">
                        @php $items = old('items', $purchase->items); @endphp
                        @foreach($items as $index => $item)
                        <tr class="item-row group">
                            <td class="px-6 py-4">
                                <select name="items[{{ $index }}][product_id]" class="product-select w-full rounded-lg border-gray-300 focus:ring-blue-500" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}"
                                            {{ (isset($item['product_id']) && $item['product_id'] == $product->id) ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" name="items[{{ $index }}][qty]" value="{{ $item['qty'] ?? 1 }}" 
                                       class="qty-input w-24 rounded-lg border-gray-300 focus:ring-blue-500" min="1" required>
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" step="0.01" name="items[{{ $index }}][cost_price]" value="{{ $item['cost_price'] ?? 0 }}" 
                                       class="price-input w-32 rounded-lg border-gray-300 focus:ring-blue-500" required>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-gray-700">
                                <span class="subtotal-display">0.00</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" class="remove-row text-red-400 hover:text-red-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t border-gray-100">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-700 uppercase tracking-wider">Grand Total:</td>
                            <td class="px-6 py-4 text-right font-extrabold text-xl text-blue-600" id="grand-total">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('admin.purchases.index') }}" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-10 py-2 rounded-lg bg-gray-900 text-white hover:bg-black shadow-md transition">
                Update Purchase & Inventory
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemList = document.getElementById('item-list');
    const addRowBtn = document.getElementById('add-row');
    const grandTotalDisplay = document.getElementById('grand-total');
    let rowCount = {{ count($items) }};

    function updateCalculations() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const subtotal = qty * price;
            row.querySelector('.subtotal-display').innerText = subtotal.toLocaleString(undefined, {minimumFractionDigits: 2});
            total += subtotal;
        });
        grandTotalDisplay.innerText = total.toLocaleString(undefined, {minimumFractionDigits: 2});
    }

    // Add Row
    addRowBtn.addEventListener('click', function() {
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelectorAll('input').forEach(i => i.value = i.classList.contains('qty-input') ? 1 : 0);
        newRow.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        newRow.querySelector('.subtotal-display').innerText = "0.00";
        
        newRow.querySelectorAll('[name]').forEach(input => {
            const name = input.getAttribute('name');
            input.setAttribute('name', name.replace(/\[\d+\]/, `[${rowCount}]`));
        });

        itemList.appendChild(newRow);
        rowCount++;
        updateCalculations();
    });

    // Remove Row
    itemList.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-row');
        if (removeBtn) {
            if (document.querySelectorAll('.item-row').length > 1) {
                removeBtn.closest('tr').remove();
                updateCalculations();
            }
        }
    });

    // Handle Changes
    itemList.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const selected = e.target.options[e.target.selectedIndex];
            e.target.closest('tr').querySelector('.price-input').value = selected.dataset.price || 0;
            updateCalculations();
        }
    });

    itemList.addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input') || e.target.classList.contains('price-input')) {
            updateCalculations();
        }
    });

    // Initial Calculation
    updateCalculations();
});
</script>
@endpush
@endsection