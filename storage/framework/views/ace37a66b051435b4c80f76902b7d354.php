

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow p-6">
    <h1 class="mb-4 text-xl"><b>📊 Daily Sales Report - <?php echo e(today()->format('M d, Y')); ?></b></h1>

    <div class="card shadow-sm mb-4">
        <h2 class="card-header bg-success "><b>Summary</b></h2>
        <div class="card-body">
            <?php
                $totalRevenue = $dailySales->sum('total_amount');
                $totalSales = $dailySales->count();
            ?>
            <div class="row">
                <div class="col-md-6">
                    <p class="lead fw-bold">Total Revenue Today: <span class="text-success">$<?php echo e(number_format($totalRevenue, 2)); ?></span></p>
                </div>
                <div class="col-md-6">
                    <p class="lead fw-bold">Total Sales Transactions: <span class="text-info"><?php echo e($totalSales); ?></span></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header"><b>Detailed Transactions</b></div>
        <div class="card-body">
            <?php if($dailySales->isEmpty()): ?>
                <div class="alert alert-warning">No sales recorded today.</div>
            <?php else: ?>
                <table class="">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="20%">Time</th>
                            <th width="10%">Cashier</th>
                            <th width="10%">Items Sold</th>
                            <th width="10%">Total Amount</th>
                            <th width="10%">Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dailySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($sale->id); ?></td>
                            <td class="text-center"><?php echo e(\Carbon\Carbon::parse($sale->created_at)->format('h:i:s A')); ?></td>
                            <td class="text-center"><?php echo e($sale->user->name ?? 'N/A'); ?></td>
                            
                            <td class="text-center"><?php echo e($sale->items->sum('qty') ?? 0); ?></td> 
                            <td class="text-center">$<?php echo e(number_format($sale->total_amount, 2)); ?></td>
                            <td class="text-center">cash</td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\resources\views/admin/reports/daily_sales.blade.php ENDPATH**/ ?>