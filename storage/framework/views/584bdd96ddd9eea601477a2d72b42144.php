<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2 mb-6">
            ⚠️ Inventory Health Report
        </h2>

        
        <div class="mb-8 border border-amber-100 rounded-lg overflow-hidden">
            <div class="bg-amber-50 px-6 py-4 border-b border-amber-100 flex justify-between items-center">
                <h3 class="text-amber-800 font-bold">Products Below Minimum Stock Level (<?php echo e($lowStock->count()); ?>)</h3>
                <span class="bg-amber-200 text-amber-800 text-xs px-2 py-1 rounded-full uppercase font-bold text-center">Warning</span>
            </div>
            
            <div class="p-0">
                <?php if($lowStock->isEmpty()): ?>
                    <div class="p-6 text-green-600 bg-green-50 text-center font-medium">
                        ✅ All products are currently above their minimum stock levels.
                    </div>
                <?php else: ?>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase font-semibold text-xs border-b">
                            <tr>
                                <th class="px-6 py-3">SKU</th>
                                <th class="px-6 py-3">Product Name</th>
                                <th class="px-6 py-3">Current Stock</th>
                                <th class="px-6 py-3">Min Stock</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-center">
                            <?php $__currentLoopData = $lowStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-mono text-gray-600"><?php echo e($product->sku); ?></td>
                                <td class="px-6 py-4 font-bold text-gray-800"><?php echo e($product->name); ?></td>
                                <td class="px-6 py-4 text-red-600 font-bold"><?php echo e($product->stock_qty); ?></td>
                                <td class="px-6 py-4 text-gray-500"><?php echo e($product->min_stock); ?></td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        
                                        <a href="#" class="text-gray-400 hover:text-amber-500" title="Update Stock">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        <button class="text-gray-400 hover:text-red-500" title="Remove Product">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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

        
        <div class="border border-red-100 rounded-lg overflow-hidden">
            <div class="bg-red-50 px-6 py-4 border-b border-red-100">
                <h3 class="text-red-800 font-bold">Products Out of Stock (<?php echo e($zeroStock->count()); ?>)</h3>
            </div>
            
            <div class="p-0">
                <?php if($zeroStock->isEmpty()): ?>
                    <div class="p-6 text-gray-500 italic text-center">
                        No products are completely out of stock.
                    </div>
                <?php else: ?>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase font-semibold text-xs border-b">
                            <tr>
                                <th class="px-6 py-3">SKU</th>
                                <th class="px-6 py-3">Product Name</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $zeroStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="bg-red-50/30 hover:bg-red-50/50">
                                <td class="px-6 py-4 font-mono"><?php echo e($product->sku); ?></td>
                                <td class="px-6 py-4 font-bold"><?php echo e($product->name); ?></td>
                                <td class="px-6 py-4">
                                    <span class="bg-red-600 text-white text-[10px] px-2 py-0.5 rounded font-bold">OUT OF STOCK</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="#" class="text-gray-400 hover:text-amber-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                        <button class="text-gray-400 hover:text-red-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
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
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ElectornicStoreProject\resources\views/admin/reports/inventory_health.blade.php ENDPATH**/ ?>