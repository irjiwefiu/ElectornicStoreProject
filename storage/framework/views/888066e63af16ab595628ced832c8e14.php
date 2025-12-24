<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    
    
    <?php if(session('success')): ?>
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
            <p class="text-sm text-green-700"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    🤝 Supplier Spending Report
                </h1>
                <p class="text-sm text-gray-500">Summary of inventory investment by supplier</p>
            </div>
            
            <?php if(!$supplierPurchases->isEmpty()): ?>
                <?php $grandTotalSpent = $supplierPurchases->sum('total_spent'); ?>
                <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-100 text-right">
                    <p class="text-xs text-blue-500 uppercase font-bold tracking-wider">Grand Total Spent</p>
                    <p class="text-2xl font-black text-blue-700">$<?php echo e(number_format($grandTotalSpent, 2)); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white border border-gray-100 rounded-lg overflow-hidden">
            <?php if($supplierPurchases->isEmpty()): ?>
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="text-gray-400 italic font-medium">No purchase history found.</p>
                </div>
            <?php else: ?>
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase font-semibold text-xs border-b">
                        <tr>
                            <th class="px-6 py-4 text-center">Rank</th>
                            <th class="px-6 py-4">Supplier Name</th>
                            <th class="px-6 py-4 text-center">Invoices</th>
                            <th class="px-6 py-4">Total Amount</th>
                            <th class="px-6 py-4">Spending %</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $supplierPurchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full <?php echo e($index == 0 ? 'bg-amber-100 text-amber-700 font-bold' : 'bg-gray-100 text-gray-600'); ?>">
                                    <?php echo e($index + 1); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-800"><?php echo e($summary->supplier->name ?? 'Deleted Supplier'); ?></p>
                                <p class="text-xs text-gray-400">ID: #<?php echo e($summary->supplier_id); ?></p>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-600">
                                <?php echo e($summary->total_invoices); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span class="text-green-600 font-bold text-base">
                                    $<?php echo e(number_format($summary->total_spent, 2)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php $percentage = ($summary->total_spent / $grandTotalSpent) * 100; ?>
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-gray-100 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500"><?php echo e(number_format($percentage, 1)); ?>%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3">
                                    
                                    <a href="#" class="text-gray-400 hover:text-amber-500 transition-colors" title="Edit Supplier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    <button class="text-gray-400 hover:text-red-500 transition-colors" title="Delete History">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ElectornicStoreProject\resources\views/admin/reports/supplier_purchases.blade.php ENDPATH**/ ?>