

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="mb-4"> <b>Supplier Spending Report</b></h2>

    <div class="card shadow-sm">
        <div class="card-header">Total Spending Grouped by Supplier</div>
        <div class="card-body">
            <?php if($supplierPurchases->isEmpty()): ?>
                <div class="alert alert-info">No purchase history found.</div>
            <?php else: ?>
                <?php
                    $grandTotalSpent = $supplierPurchases->sum('total_spent');
                ?>
                <p class="lead fw-bold">Grand Total Spent on Inventory: <span class="text-primary">$<?php echo e(number_format($grandTotalSpent, 2)); ?></span></p>

                <table class="table table-bordered table-striped table-hover mt-3">
                    <thead>
                        <tr>
                            <th width="5%">Rank</th>
                            <th width="20%">Supplier Name</th>
                            <th width="15%">Total Invoices</th>
                            <th width="20%">Total Amount Spent</th>
                            <th width="15%">Percentage of Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $supplierPurchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-bold" class="text-center"><?php echo e($index + 1); ?></td>
                            <td class="text-center"><?php echo e($summary->supplier->name ?? 'Deleted Supplier'); ?></td>
                            <td class="text-center"><?php echo e($summary->total_invoices); ?></td>
                            <td class="text-center" class="fw-bold text-success">$<?php echo e(number_format($summary->total_spent, 2)); ?></td>
                            <td class="text-center">
                                <?php
                                    $percentage = ($summary->total_spent / $grandTotalSpent) * 100;
                                ?>
                                <?php echo e(number_format($percentage, 2)); ?>%
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\electronics-store-app - Copy\resources\views/admin/reports/supplier_purchases.blade.php ENDPATH**/ ?>