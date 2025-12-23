

<?php $__env->startSection('page-title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">📦 Products</h2>
        <a href="<?php echo e(route('admin.products.create')); ?>"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Product
        </a>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Category</th>
                <th class="p-2 text-left">Price</th>
                <th class="p-2 text-left">Stock</th>
                <th class="p-2 text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-2"><?php echo e($product->name); ?></td>
                    <td class="p-2"><?php echo e($product->category->name); ?></td>
                    <td class="p-2">Rs <?php echo e(number_format($product->sale_price)); ?></td>
                    <td class="p-2"><?php echo e($product->stock_qty); ?></td>
                    <td class="p-2 text-right">
                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                           class="text-blue-600"><b>Edit</b></a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center py-6">No products found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\electronics-store-app - Copy\resources\views/admin/products/index.blade.php ENDPATH**/ ?>