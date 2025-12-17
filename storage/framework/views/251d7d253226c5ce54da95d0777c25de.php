

<?php $__env->startSection('page-title', 'Add Purchase'); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('admin.purchases.store')); ?>">
<?php echo csrf_field(); ?>

<div class="max-w-6xl bg-white rounded-xl shadow p-6">

    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">🛒 New Purchase</h2>
        <a href="<?php echo e(route('admin.purchases.index')); ?>"
           class="px-4 py-2 border rounded hover:bg-gray-100">
            ← Back
        </a>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div>
            <label class="block text-sm font-medium mb-1">Supplier</label>
            <select name="supplier_id"
                    class="w-full border rounded px-3 py-2" required>
                <option value="">Select Supplier</option>
                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Invoice No</label>
            <input type="text" name="invoice_no"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Purchase Date</label>
            <input type="date" name="purchase_date"
                   value="<?php echo e(date('Y-m-d')); ?>"
                   class="w-full border rounded px-3 py-2">
        </div>

    </div>

    
    <div class="overflow-x-auto mb-4">
        <table class="w-full text-sm border rounded">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-2">Product</th>
                    <th class="p-2 w-32">Unit Cost</th>
                    <th class="p-2 w-24">Qty</th>
                    <th class="p-2 w-32">Total</th>
                    <th class="p-2 w-10"></th>
                </tr>
            </thead>
            <tbody id="itemsBody">
                <tr>
                    <td class="p-2">
                        <select name="items[0][product_id]"
                                class="w-full border rounded px-2 py-1" required>
                            <option value="">Select product</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>">
                                    <?php echo e($product->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>

                    <td class="p-2">
                        <input type="number" step="0.01" min="0"
                               name="items[0][cost_price]"
                               class="w-full border rounded px-2 py-1 cost"
                               oninput="calculateRow(this)" required>
                    </td>

                    <td class="p-2">
                        <input type="number" min="1"
                               name="items[0][qty]"
                               class="w-full border rounded px-2 py-1 qty"
                               oninput="calculateRow(this)" required>
                    </td>

                    <td class="p-2">
                        <input type="text"
                               class="w-full border rounded px-2 py-1 bg-gray-100 total"
                               readonly>
                    </td>

                    <td class="p-2 text-center">
                        <button type="button"
                                onclick="removeRow(this)"
                                class="text-red-500 font-bold">✕</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <button type="button"
            onclick="addRow()"
            class="px-3 py-2 border rounded hover:bg-gray-100 mb-4">
        + Add Item
    </button>

    
    <div class="flex justify-between items-center mt-6">
        <h3 class="text-lg font-bold">
            Grand Total: Rs <span id="grandTotal">0.00</span>
        </h3>

        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            💾 Save Purchase
        </button>
    </div>

</div>
</form>

<script>
let rowIndex = 1;

function addRow() {
    const tbody = document.getElementById('itemsBody');

    tbody.insertAdjacentHTML('beforeend', `
        <tr>
            <td class="p-2">
                <select name="items[${rowIndex}][product_id]"
                        class="w-full border rounded px-2 py-1" required>
                    <option value="">Select product</option>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>

            <td class="p-2">
                <input type="number" step="0.01" min="0"
                       name="items[${rowIndex}][cost_price]"
                       class="w-full border rounded px-2 py-1 cost"
                       oninput="calculateRow(this)" required>
            </td>

            <td class="p-2">
                <input type="number" min="1"
                       name="items[${rowIndex}][qty]"
                       class="w-full border rounded px-2 py-1 qty"
                       oninput="calculateRow(this)" required>
            </td>

            <td class="p-2">
                <input type="text"
                       class="w-full border rounded px-2 py-1 bg-gray-100 total"
                       readonly>
            </td>

            <td class="p-2 text-center">
                <button type="button"
                        onclick="removeRow(this)"
                        class="text-red-500 font-bold">✕</button>
            </td>
        </tr>
    `);

    rowIndex++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
    calculateGrandTotal();
}

function calculateRow(input) {
    const row = input.closest('tr');
    const cost = parseFloat(row.querySelector('.cost').value) || 0;
    const qty = parseInt(row.querySelector('.qty').value) || 0;

    row.querySelector('.total').value = (cost * qty).toFixed(2);
    calculateGrandTotal();
}

function calculateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.total').forEach(el => {
        total += parseFloat(el.value) || 0;
    });
    document.getElementById('grandTotal').innerText = total.toFixed(2);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\resources\views/admin/purchases/create.blade.php ENDPATH**/ ?>