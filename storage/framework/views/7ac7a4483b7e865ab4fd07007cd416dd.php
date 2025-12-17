

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-bold">⚠️ Inventory Health Report</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-dark fw-bold">Products Below Minimum Stock Level (<?php echo e($lowStock->count()); ?> items)</div>
        <div class="card-body">
            <?php if($lowStock->isEmpty()): ?>
                <div class="alert alert-success">All products are currently above their minimum stock levels.</div>
            <?php else: ?>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th width="10%">Current Stock</th>
                            <th width="10%">Minimum Stock</th>
                            <th width="10%">Order Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $lowStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="<?php echo e($product->stock_qty == 0 ? 'table-danger' : ''); ?>">
                            <td><?php echo e($product->sku); ?></td>
                            <td><?php echo e($product->name); ?></td>
                            <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                            <td><?php echo e($product->supplier->name ?? 'N/A'); ?></td>
                            <td class="fw-bold"><?php echo e($product->stock_qty); ?></td>
                            <td><?php echo e($product->min_stock); ?></td>
                            <td class="fw-bold text-primary"><?php echo e($product->min_stock * 2); ?></td> 
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-danger text-green fw-bold"> <b>Products Out of Stock (Zero Stock) (<?php echo e($zeroStock->count()); ?> items) </b></div>
        <div class="card-body">
            <?php if($zeroStock->isEmpty()): ?>
                <div class="alert alert-info">No products are completely out of stock.</div>
            <?php else: ?>
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Product Name</th>
                            <th>Last Supplier</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $zeroStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($product->sku); ?></td>
                                <td><?php echo e($product->name); ?></td>
                                <td><?php echo e($product->supplier->name ?? 'N/A'); ?></td>
                                <td class="text-danger fw-bold">OUT OF STOCK</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\resources\views/admin/reports/inventory_health.blade.php ENDPATH**/ ?>