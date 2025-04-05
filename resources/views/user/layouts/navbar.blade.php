@inject('cartService', 'App\Services\CartService')

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Hardware Shop" height="32">
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" 
                       href="{{ route('products.index') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" 
                       href="{{ route('categories.index') }}">Categories</a>
                </li>
            </ul>

            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="d-flex me-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search" name="q" class="form-control border-start-0" 
                           placeholder="Search products...">
                </div>
            </form>

            <!-- Cart & User Menu -->
            <div class="d-flex align-items-center">
                <a href="{{ route('cart.index') }}" class="btn btn-link position-relative">
                    <i class="bi bi-cart fs-5"></i>
                    @if($cartService->getCartCount() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cartService->getCartCount() }}
                        </span>
                    @endif
                </a>

                @auth
                    <div class="dropdown ms-3">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->profile_photo_url }}" 
                                 alt="{{ auth()->user()->name }}"
                                 class="rounded-circle"
                                 width="32"
                                 height="32">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-link">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary ms-2">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>