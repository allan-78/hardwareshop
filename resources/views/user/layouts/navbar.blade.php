@inject('cartService', 'App\Services\CartService')

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Hardware Shop" height="32">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categories</a>
                </li>
            </ul>

            <form action="{{ route('search') }}" method="GET" class="d-flex me-3">
                <div class="input-group">
                    <input type="search" name="q" class="form-control" placeholder="Search products...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="d-flex align-items-center">
                <a href="{{ route('cart.index') }}" class="btn btn-link position-relative me-3">
                    <i class="bi bi-cart fs-5"></i>
                    @if($cartService->getCartCount() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cartService->getCartCount() }}
                        </span>
                    @endif
                </a>

                @auth
                    <div class="nav-item dropdown">
                        <button class="nav-link dropdown-toggle d-flex align-items-center border-0 bg-transparent" 
                                type="button"
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="rounded-circle me-2 object-cover"
                                 width="32" 
                                 height="32"
                                 style="object-fit: cover;">
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                <i class="bi bi-box me-2"></i>My Orders
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
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