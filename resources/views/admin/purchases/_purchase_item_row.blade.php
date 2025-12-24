<tr>
    <td>
        <select name="items[{{ $index }}][product_id]" class="form-select product-select" required>
            <option value="">Select Product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}"
                        data-cost="{{ $product->cost_price }}"
                        @selected(old("items.$index.product_id")==$product->id)>
                    {{ $product->name }} — ₨ {{ number_format($product->cost_price,2) }}
                </option>
            @endforeach
        </select>
    </td>

    <td>
        <input type="number" step="0.01"
               name="items[{{ $index }}][cost_price]"
               class="form-control item-cost"
               value="{{ old("items.$index.cost_price",0) }}">
    </td>

    <td>
        <input type="number"
               name="items[{{ $index }}][qty]"
               class="form-control item-qty"
               value="{{ old("items.$index.qty",1) }}" min="1">
    </td>

    <td>
        <input type="text" class="form-control item-total text-success fw-bold" readonly>
    </td>

    <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline-danger remove-item">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
