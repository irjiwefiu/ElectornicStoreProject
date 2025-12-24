<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    
    
    <?php if(session('success')): ?>
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm text-green-700"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm text-red-700"><?php echo e(session('error')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    📊 Daily Sales Report
                </h1>
                <p class="text-sm text-gray-500"><?php echo e(today()->format('l, M d, Y')); ?></p>
            </div>
            <div class="flex gap-4">
                <?php
                    $totalRevenue = $dailySales->sum('total_amount');
                    $totalSales = $dailySales->count();
                ?>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase font-semibold">Total Revenue</p>
                    <p class="text-xl font-bold text-green-600">$<?php echo e(number_format($totalRevenue, 2)); ?></p>
                </div>
                <div class="border-l pl-4 text-right">
                    <p class="text-xs text-gray-400 uppercase font-semibold">Transactions</p>
                    <p class="text-xl font-bold text-blue-600"><?php echo e($totalSales); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase font-semibold text-xs border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">Invoice ID</th>
                            <th class="px-6 py-4">Time</th>
                            <th class="px-6 py-4">Cashier</th>
                            <th class="px-6 py-4 text-center">Items Sold</th>
                            <th class="px-6 py-4">Total Amount</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $dailySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-700">#<?php echo e($sale->id); ?></td>
                            <td class="px-6 py-4 text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($sale->created_at)->format('h:i A')); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                    <?php echo e($sale->user->name ?? 'System'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-600">
                                <?php echo e($sale->items->sum('qty') ?? 0); ?>

                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                $<?php echo e(number_format($sale->total_amount, 2)); ?>

                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    
                                    <a href="<?php echo e(route('cashier.sales.invoice', $sale->id)); ?>" class="text-gray-400 hover:text-blue-600 transition-colors" title="View Invoice">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>

                                    
                                    <a href="<?php echo e(route('admin.sales.edit', $sale->id)); ?>" class="text-gray-400 hover:text-amber-500 transition-colors" title="Edit Sale">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    
                                    <form action="" method="POST" class="inline" onsubmit="return confirm('WARNING: Deleting this sale will ADD the items back to inventory stock. Proceed?')">
                                        <?php echo csrf_field(); ?>
                                        
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors pt-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-7 h-7 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-400 italic font-medium">No sales recorded today.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ElectornicStoreProject\resources\views/admin/reports/daily_sales.blade.php ENDPATH**/ ?>