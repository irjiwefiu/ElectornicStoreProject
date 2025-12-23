

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto bg-white p-6 shadow rounded" id="receipt">

    <h2 class="text-center font-bold text-xl mb-2">🧾 Receipt</h2>
    <p class="text-center text-sm mb-4">Invoice #<?php echo e($sale->invoice_no); ?></p>

    <table class="w-full text-sm mb-4">
        <?php $__currentLoopData = $sale->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item->product->name); ?></td>
            <td class="text-center"><?php echo e($item->qty); ?></td>
            <td class="text-right">Rs <?php echo e($item->subtotal); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

    <hr>

    <div class="flex justify-between font-bold mt-2">
        <span>Total</span>
        <span>Rs <?php echo e($sale->total); ?></span>
    </div>

    <div class="flex justify-between text-sm">
        <span>Paid</span>
        <span>Rs <?php echo e($sale->paid_amount); ?></span>
    </div>

    <div class="flex justify-between text-sm mb-4">
        <span>Change</span>
        <span>Rs <?php echo e($sale->change_return); ?></span>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app\resources\views/cashier/sales/invoice.blade.php ENDPATH**/ ?>