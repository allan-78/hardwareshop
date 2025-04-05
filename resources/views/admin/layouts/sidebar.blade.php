<aside class="w-64 bg-gray-800 min-h-screen">
    <div class="flex items-center justify-center h-16 bg-gray-900">
        <span class="text-white text-lg font-semibold">{{ config('app.name') }}</span>
    </div>
    <nav class="mt-5">
        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            <x-icon name="dashboard" class="mr-3 h-6 w-6"/>
            Dashboard
        </x-nav-link>

        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
            <x-icon name="shopping-bag" class="mr-3 h-6 w-6"/>
            Products
        </x-nav-link>

        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
            <x-icon name="shopping-cart" class="mr-3 h-6 w-6"/>
            Orders
        </x-nav-link>

        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
            <x-icon name="collection" class="mr-3 h-6 w-6"/>
            Categories
        </x-nav-link>

        <x-nav-link :href="route('admin.brands.index')" :active="request()->routeIs('admin.brands.*')">
            <x-icon name="tag" class="mr-3 h-6 w-6"/>
            Brands
        </x-nav-link>

        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
            <x-icon name="users" class="mr-3 h-6 w-6"/>
            Users
        </x-nav-link>

        <x-nav-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.*')">
            <x-icon name="star" class="mr-3 h-6 w-6"/>
            Reviews
        </x-nav-link>
    </nav>
</aside>