

<?php $__env->startSection('content'); ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 text-center"><?php echo e($sale->invoice_no); ?></td>
                        <td class="p-3 text-center"><?php echo e(number_format($sale->subtotal, 2)); ?></td>
                        <td class="p-3 text-center"><?php echo e(number_format($sale->total, 2)); ?></td>
                        <td class="p-3 text-center"><?php echo e($sale->created_at->format('d M Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            No sales found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app\resources\views/cashier/sales/index.blade.php ENDPATH**/ ?>