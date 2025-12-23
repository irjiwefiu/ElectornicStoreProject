

<?php $__env->startSection('page-title', 'Suppliers'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">🚚 Suppliers</h2>
        <a href="<?php echo e(route('admin.suppliers.create')); ?>"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Supplier
        </a>
    </div>

    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Name</th>
                <th class="p-2">Phone</th>
                <th class="p-2">Email</th>
                <th class="p-2 text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-t">
                    <td class="p-2"><?php echo e($supplier->name); ?></td>
                    <td class="p-2"><?php echo e($supplier->phone); ?></td>
                    <td class="p-2"><?php echo e($supplier->email); ?></td>
                    <td class="p-2 text-right">
                        <a href="<?php echo e(route('admin.suppliers.edit', $supplier->id)); ?>"
                           class="text-blue-600"><b>Edit</b></a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\electronics-store-app - Copy\resources\views/admin/suppliers/index.blade.php ENDPATH**/ ?>