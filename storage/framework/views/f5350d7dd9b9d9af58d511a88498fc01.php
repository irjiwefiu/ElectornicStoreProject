

<?php $__env->startSection('page-title', 'Stock Adjustments'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">📦 Stock Adjustments</h2>

        <a href="<?php echo e(route('admin.stock_adjustments.create')); ?>"
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
                <?php $__empty_1 = true; $__currentLoopData = $adjustments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="">
                        <td class="p-3 text-center"><?php echo e($adj->product->name); ?></td>
                        <td class="p-3 text-center">
                            <span class="<?php echo e($adj->type === 'increase' ? 'text-green-600' : 'text-red-600'); ?>">
                                <?php echo e(ucfirst($adj->type)); ?>

                            </span>
                        </td>
                        <td class="p-3 text-center"><?php echo e($adj->qty); ?></td>
                        <td class="p-3 text-center"><?php echo e($adj->reason); ?></td>
                        <td class="p-3 text-center"><?php echo e($adj->created_at->format('d M Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            No stock adjustments found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\electronics-store-app - Copy\resources\views/admin/stock_adjustments/index.blade.php ENDPATH**/ ?>