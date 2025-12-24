

<?php $__env->startSection('page-title', 'Alert Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative">
    
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800"><b>🔔 System Alerts </b></h1>
            <p class="text-sm text-gray-500 mt-1">Monitor and manage system notifications and security logs.</p>
        </div>
    </div>

    
    <?php if(session('success')): ?>
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm flex items-center justify-between animate-fade-in-down">
            <div>
                <span class="font-bold">Success!</span> <?php echo e(session('success')); ?>

            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 text-2xl leading-none">&times;</button>
        </div>
    <?php endif; ?>

    
    <div class="overflow-x-auto rounded-lg border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 font-semibold">ID</th>
                    <th class="p-4 font-semibold">Details</th>
                    <th class="p-4 font-semibold">Type</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold">Date</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-blue-50/50 transition duration-150 ease-in-out group <?php echo e(!$alert->is_read ? 'bg-blue-50/30' : ''); ?>">
                        
                        
                        <td class="p-4 text-gray-400 font-mono text-sm">#<?php echo e($alert->id); ?></td>
                        
                        
                        <td class="p-4">
                            <div class="font-bold <?php echo e($alert->is_read ? 'text-gray-600' : 'text-gray-900'); ?>">
                                <?php echo e($alert->title); ?>

                            </div>
                            <div class="text-xs text-gray-500 mt-1 max-w-xs truncate" title="<?php echo e($alert->message); ?>">
                                <?php echo e(Str::limit($alert->message, 50)); ?>

                            </div>
                        </td>

                        
                        <td class="p-4">
                            <?php
                                $typeClasses = [
                                    'error' => 'bg-red-100 text-red-700',
                                    'warning' => 'bg-yellow-100 text-yellow-700',
                                    'info' => 'bg-blue-100 text-blue-700',
                                    'success' => 'bg-green-100 text-green-700',
                                ][$alert->type] ?? 'bg-gray-100 text-gray-700';
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($typeClasses); ?>">
                                <?php echo e(ucfirst($alert->type)); ?>

                            </span>
                        </td>

                        
                        <td class="p-4">
                            <?php if($alert->is_read): ?>
                                <span class="flex items-center gap-1.5 text-xs text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Read
                                </span>
                            <?php else: ?>
                                <span class="flex items-center gap-1.5 text-xs text-blue-600 font-semibold">
                                    <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                                    New
                                </span>
                            <?php endif; ?>
                        </td>

                        
                        <td class="p-4 text-sm text-gray-500">
                            <?php echo e($alert->created_at->diffForHumans()); ?>

                        </td>

                        
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                
                                
                                <?php if(!$alert->is_read): ?>
                                    <form action="<?php echo e(route('admin.alerts.read', $alert->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="text-gray-400 hover:text-blue-600 transition p-1 rounded-full hover:bg-blue-50" title="Mark as Read">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <form action="<?php echo e(route('admin.alerts.destroy', $alert->id)); ?>" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Delete this alert forever?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1 rounded-full hover:bg-red-50" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-500 bg-gray-50 rounded-b-lg">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-lg font-medium">No alerts found</p>
                                <p class="text-sm mt-1">Everything looks quiet right now.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($alerts->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($alerts->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ElectornicStoreProject\resources\views/admin/alerts/index.blade.php ENDPATH**/ ?>