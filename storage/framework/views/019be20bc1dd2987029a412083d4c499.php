

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">⚙️ New Stock Adjustment</h2>

    <?php if($message = Session::get('error')): ?>
        <div class="alert alert-danger"><?php echo e($message); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.stock_adjustments.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="product_id" class="form-label">Product to Adjust:</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">Select Product (Current Stock Qty)</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" data-stock="<?php echo e($product->stock_qty); ?>" <?php echo e(old('product_id') == $product->id ? 'selected' : ''); ?>>
                                    <?php echo e($product->name); ?> (SKU: <?php echo e($product->sku); ?>) - Current Stock: <?php echo e($product->stock_qty); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Adjustment Type:</label>
                        <select name="type" class="form-select" required>
                            <option value="increase" <?php echo e(old('type') == 'increase' ? 'selected' : ''); ?>>Increase (Add Stock)</option>
                            <option value="decrease" <?php echo e(old('type') == 'decrease' ? 'selected' : ''); ?>>Decrease (Remove/Write-off Stock)</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="qty" class="form-label">Quantity:</label>
                        <input type="number" name="qty" class="form-control" value="<?php echo e(old('qty')); ?>" min="1" required>
                    </div>
                    
                    <div class="col-md-12 mb-4">
                        <label for="reason" class="form-label">Reason for Adjustment (Required for Audit):</label>
                        <textarea name="reason" class="form-control" style="height:100px" required><?php echo e(old('reason')); ?></textarea>
                    </div>
                </div>

                <a href="<?php echo e(route('admin.stock_adjustments.index')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Logs</a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-wrench"></i> Apply Adjustment
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\resources\views/admin/stock_adjustments/create.blade.php ENDPATH**/ ?>