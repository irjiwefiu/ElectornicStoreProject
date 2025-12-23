<header class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h1 class="text-lg font-semibold">
        @yield('page-title', 'Dashboard')
    </h1>

    <div class="flex items-center gap-6">

        {{-- Navigation Links --}}
        <nav class="flex items-center gap-4 text-sm">

            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                Dashboard
            </a>

            @auth
                {{-- ADMIN NAV --}}
                @if(auth()->user()->role === 'admin')

                    <a href="{{ route('admin.categories.index') }}"
                       class="{{ request()->routeIs('admin.categories.*') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                        Categories
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                       class="{{ request()->routeIs('admin.products.*') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                        Products
                    </a>

                    <a href="{{ route('admin.reports.daily_sales') }}"
                       class="{{ request()->routeIs('admin.reports.*') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                        Reports
                    </a>

                @endif

                {{-- CASHIER NAV --}}
                @if(auth()->user()->role === 'cashier')

                    <a href="{{ route('cashier.sales.create') }}"
                       class="{{ request()->routeIs('cashier.sales.create') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                        POS
                    </a>

                    <a href="{{ route('cashier.sales.index') }}"
                       class="{{ request()->routeIs('cashier.sales.index') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                        Sales
                    </a>

                @endif
            @endauth
        </nav>

        {{-- User Info + Logout --}}
        @auth
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">
                    {{ auth()->user()->name }} ({{ auth()->user()->role }})
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 hover:underline text-sm">
                        Logout
                    </button>
                </form>
            </div>
        @endauth

    </div>
</header>
