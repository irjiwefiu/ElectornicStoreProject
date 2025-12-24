

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Stock Adjustment</h1>
            <p class="text-sm text-gray-500">Correcting log entry #<?php echo e($stockAdjustment->id); ?></p>
        </div>
    </div>

    <?php if($errors->any() || session('error')): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            <?php echo e(session('error')); ?>

            <ul class="list-disc list-inside text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow-lg rounded-xl p-6">
        <form action="<?php echo e(route('admin.stock_adjustments.update', $stockAdjustment->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                    <select name="product_id" class="w-full rounded-lg border-gray-300 focus:ring-blue-500" required>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($product->id); ?>" <?php echo e(old('product_id', $stockAdjustment->product_id) == $product->id ? 'selected' : ''); ?>>
                                <?php echo e($product->name); ?> (Current: <?php echo e($product->stock_qty); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adjustment Type</label>
                        <select name="type" class="w-full rounded-lg border-gray-300 focus:ring-blue-500" required>
                            <option value="increase" <?php echo e(old('type', $stockAdjustment->type) == 'increase' ? 'selected' : ''); ?>>Add (+) Stock</option>
                            <option value="decrease" <?php echo e(old('type', $stockAdjustment->type) == 'decrease' ? 'selected' : ''); ?>>Remove (-) Stock</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" name="qty" value="<?php echo e(old('qty', $stockAdjustment->qty)); ?>" 
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500" min="1" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Adjustment</label>
                    <textarea name="reason" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-blue-500" required placeholder="e.g. Damage, Inventory count error..."><?php echo e(old('reason', $stockAdjustment->reason)); ?></textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="<?php echo e(route('admin.stock_adjustments.index')); ?>" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                    Update & Correct Inventory
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ElectornicStoreProject\resources\views/admin/stock_adjustments/edit.blade.php ENDPATH**/ ?>