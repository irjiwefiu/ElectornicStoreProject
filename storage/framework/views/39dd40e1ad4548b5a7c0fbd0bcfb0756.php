<aside class="w-64 bg-slate-900 text-slate-200 min-h-screen flex flex-col">

    
    <div class="px-6 py-5 text-xl font-bold border-b border-slate-700 tracking-wide">
        ⚡ Electronics Store
    </div>

    
    <nav class="flex-1 px-3 py-4 space-y-1 text-sm">

        <?php if(auth()->guard()->check()): ?>

            <?php
                $linkBase = 'flex items-center gap-3 px-3 py-2 rounded-lg
                             transition-all duration-200 transform';

                $active = 'bg-slate-700 text-black text-lg font-extrabold scale-105 shadow-md';

                $inactive = 'text-slate-300 hover:bg-slate-700
                             hover:text-white hover:font-bold hover:scale-105';
            ?>

            
            <?php if(auth()->user()->role === 'admin'): ?>

                <div class="text-xs uppercase text-slate-400 px-3 mt-2 mb-2 tracking-wider">
                    Management
                </div>

                <a href="<?php echo e(route('admin.categories.index')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('admin.categories.*') ? $active : $inactive); ?>">
                    🗂 <span>Categories</span>
                </a>

                <a href="<?php echo e(route('admin.products.index')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('admin.products.*') ? $active : $inactive); ?>">
                    📦 <span>Products</span>
                </a>

                <a href="<?php echo e(route('admin.suppliers.index')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('admin.suppliers.*') ? $active : $inactive); ?>">
                    🚚 <span>Suppliers</span>
                </a>

                <a href="<?php echo e(route('admin.purchases.index')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('admin.purchases.*') ? $active : $inactive); ?>">
                    🧾 <span>Purchases</span>
                </a>

                <a href="<?php echo e(route('admin.stock_adjustments.index')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('admin.stock_adjustments.*') ? $active : $inactive); ?>">
                    ⚖️ <span>Stock Adjustments</span>
                </a>

                
                <div class="text-xs uppercase text-slate-400 px-3 mt-6 mb-2 tracking-wider">
                    Reports
                </div>

                <a href="<?php echo e(route('admin.reports.daily_sales')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('admin.reports.daily_sales') ? $active : $inactive); ?>">
                    📅 <span>Daily Sales</span>
                </a>

                <a href="<?php echo e(route('admin.reports.inventory_health')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('admin.reports.inventory_health') ? $active : $inactive); ?>">
                    📉 <span>Inventory Health</span>
                </a>

                <a href="<?php echo e(route('admin.reports.supplier_purchases')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('admin.reports.supplier_purchases') ? $active : $inactive); ?>">
                    🏭 <span>Supplier Purchases</span>
                </a>

            <?php endif; ?>

            
            <?php if(auth()->user()->role === 'cashier'): ?>

                <div class="text-xs uppercase text-slate-400 px-3 mt-2 mb-2 tracking-wider">
                    Sales
                </div>

                <a href="<?php echo e(route('cashier.sales.create')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('cashier.sales.create') ? $active : $inactive); ?>">
                    🧾 <span>POS / New Sale</span>
                </a>

                <a href="<?php echo e(route('cashier.sales.index')); ?>"
                   class="<?php echo e($linkBase); ?> <?php echo e(request()->routeIs('cashier.sales.index') ? $active : $inactive); ?>">
                    📜 <span>Sales History</span>
                </a>

            <?php endif; ?>

        <?php endif; ?>

    </nav>

    
<?php if(auth()->guard()->check()): ?>
    <div class="px-3 py-3 border-t border-slate-700">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg
                       text-slate-300 transition-all duration-200 transform
                       hover:bg-red-600 hover:text-white hover:scale-105">
                🚪 <span class="font-semibold">Logout</span>
            </button>
        </form>
    </div>
<?php endif; ?>

    
    <?php if(auth()->guard()->check()): ?>
        <div class="px-4 py-3 border-t border-slate-700 text-xs text-slate-400">
            Logged in as <span class="text-white font-semibold"><?php echo e(auth()->user()->role); ?></span>
        </div>
    <?php endif; ?>

</aside>
<?php /**PATH C:\xampp\htdocs\electronics-store-app - Copy\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>