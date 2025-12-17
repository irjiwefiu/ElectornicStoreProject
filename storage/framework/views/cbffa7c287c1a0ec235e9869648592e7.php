<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e(config('app.name', 'Electronics Store')); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
    
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="flex-1 flex flex-col">
        
        

        
        <main class="p-6">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\electronics-store-app\resources\views/layouts/app.blade.php ENDPATH**/ ?>