

<?php $__env->startSection('page-title', 'Add Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-bold mb-4">➕ New Category</h2>

    <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="<?php echo e(route('admin.categories.index')); ?>"
               class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancel
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save Category
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\electronics-store-app - Copy\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>