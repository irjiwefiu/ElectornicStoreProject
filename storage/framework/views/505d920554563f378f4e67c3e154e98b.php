<?php $__env->startSection('content'); ?>
<div class="flex justify-center items-center min-h-screen">
    <form method="POST" action="<?php echo e(route('login')); ?>"
          class="bg-white p-6 rounded-xl shadow w-96">
        <?php echo csrf_field(); ?>

        <h2 class="text-xl font-bold mb-4 text-center">🔐 Login</h2>

        
        <?php if($errors->any()): ?>
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded text-sm">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email"
               value="<?php echo e(old('email')); ?>"
               class="w-full mb-3 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
               required>

        <input type="password" name="password" placeholder="Password"
               class="w-full mb-4 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
               required>

        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
            Login
        </button>

        
        <div class="mt-4 text-center text-sm">
            Don’t have an account?
            <a href="<?php echo e(route('register')); ?>" class="text-blue-600 font-semibold hover:underline">
                Register
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\resources\views/auth/login.blade.php ENDPATH**/ ?>