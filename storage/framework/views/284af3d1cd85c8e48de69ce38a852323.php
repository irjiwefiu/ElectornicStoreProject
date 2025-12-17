<tr>
    <td>
        <select name="items[<?php echo e($index); ?>][product_id]" class="form-select product-select" required>
            <option value="">Select Product</option>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($product->id); ?>"
                        data-cost="<?php echo e($product->cost_price); ?>"
                        <?php if(old("items.$index.product_id")==$product->id): echo 'selected'; endif; ?>>
                    <?php echo e($product->name); ?> — $<?php echo e(number_format($product->cost_price,2)); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </td>

    <td>
        <input type="number" step="0.01"
               name="items[<?php echo e($index); ?>][cost_price]"
               class="form-control item-cost"
               value="<?php echo e(old("items.$index.cost_price",0)); ?>">
    </td>

    <td>
        <input type="number"
               name="items[<?php echo e($index); ?>][qty]"
               class="form-control item-qty"
               value="<?php echo e(old("items.$index.qty",1)); ?>" min="1">
    </td>

    <td>
        <input type="text" class="form-control item-total text-success fw-bold" readonly>
    </td>

    <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline-danger remove-item">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
<?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\resources\views/admin/purchases/_purchase_item_row.blade.php ENDPATH**/ ?>