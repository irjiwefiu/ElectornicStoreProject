

<?php $__env->startSection('page-title', 'Category Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">🏷 Categories</h2>

        <a href="<?php echo e(route('admin.categories.create')); ?>"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Category
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Description</th>
                <th class="p-3 text-center">Products</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3"><?php echo e($category->id); ?></td>
                    <td class="p-3 font-medium"><?php echo e($category->name); ?></td>
                    <td class="p-3 text-sm text-gray-600">
                        <?php echo e(Str::limit($category->description, 60)); ?>

                    </td>
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 text-xs rounded
                            <?php echo e($category->products_count ? 'bg-blue-100 text-blue-700' : 'bg-gray-200'); ?>">
                            <?php echo e($category->products_count); ?>

                        </span>
                    </td>
                    <td class="p-3 text-right space-x-2">
                        <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        <form class="inline"
                              method="POST"
                              action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>"
                              onsubmit="return confirm('Delete this category?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="text-red-600 hover:underline"
                                <?php echo e($category->products_count ? 'disabled' : ''); ?>>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        No categories found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>