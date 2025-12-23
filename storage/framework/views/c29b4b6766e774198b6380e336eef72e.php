

<?php $__env->startSection('page-title', 'Purchases'); ?>
    
    <?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">🧾 Purchases</h2>
        <a href="<?php echo e(route('admin.purchases.create')); ?>"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Purchase
        </a>
    </div>


    
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th class="text-end px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-t">
                            <td class="p-2"><?php echo e($purchase->id); ?></td>
                            <td class="p-2"><?php echo e($purchase->purchase_date->format('Y-m-d')); ?></td>
                            <td class="p-2"><?php echo e($purchase->supplier->name ?? '-'); ?></td>
                            <td class="p-2"><?php echo e($purchase->invoice_no); ?></td>
                            <td class="p-2">
                                $<?php echo e(number_format($purchase->total_amount, 2)); ?>

                            </td>
                            <td class="text-end px-4 p-2">
                                <a href="#" class="text-decoration-none text-primary fw-semibold">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No purchases found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\electronics-store-app - Copy\resources\views/admin/purchases/index.blade.php ENDPATH**/ ?>