<?php $__env->startSection('page-title', 'Edit Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-bold mb-4">✏️ Edit Category</h2>

    
    <form method="POST" action="<?php echo e(route('admin.categories.update', $category->id)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name"
                   value="<?php echo e(old('name', $category->name)); ?>"
                   class="w-full border rounded px-3 py-2 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border rounded px-3 py-2"><?php echo e(old('description', $category->description)); ?></textarea>
        </div>

        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Category Image</label>
            
            
            <?php if($category->image): ?>
                <div class="mb-2">
                    <p class="text-xs text-gray-500 mb-1">Current Image:</p>
                    <img src="<?php echo e(asset('storage/' . $category->image)); ?>" 
                         alt="Current Image" 
                         class="w-24 h-24 object-cover rounded border">
                </div>
            <?php endif; ?>

            
            <input type="file" name="image" accept="image/*"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200 <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <p class="text-xs text-gray-500 mt-1">Leave blank to keep the current image.</p>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex justify-end gap-3">
            <a href="<?php echo e(route('admin.categories.index')); ?>"
               class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancel
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ElectornicStoreProject\resources\views/admin/categories/edit.blade.php ENDPATH**/ ?>