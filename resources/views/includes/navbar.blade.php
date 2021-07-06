<nav
    class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
    data-aos="fade-down"
>
    <div class="container">
    <a href="{{ route('home') }}" class="navbar-brand"> 
        <img src="/images/logokhairina.png" alt="Logo" />
    </a>
    <ul class="navbar-nav mr-auto d-none d-lg-flex">
        <li class="nav-item">
            <form action="{{ Route('search-redirect') }}" method="POST">
                @csrf
                <input
                    type="text"
                    name="cari"
                    placeholder="Search..."
                    class="w-full -ml-8 pl-10 px-4 py-2 border rounded-pill focus:outline-none focus:bg-gray-600"
                    id="search"
                    value="">  
                <input type="submit" value="" style="visibility: hidden">
            </form>
        </li>   
    </ul>
      <button 
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarResponsive"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
     <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item {{ (request()->is('home')) ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item {{ (request()->is('categories')) ? 'active' : '' }}">
                <a href="{{ route('categories') }}" class="nav-link">Categories</a>
            </li>
            <li class="nav-item {{ (request()->is('contact')) ? 'active' : '' }}">
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
            </li>
        @guest
            <li class="nav-item">
                <a
                href="{{ route('login') }}"
                class="btn btn-success nav-link px-4 text-white"
                style="background: #3eb3f7;border-radius: 20px;border: 2px solid #3eb3f7;"
                >Sign In</a
                >
            </li>
        @endguest
    </ul>
    @auth

<ul class="navbar-nav d-none d-lg-flex">
    <li class="nav-item dropdown">
    <a
        href="#"
        class="nav-link"
        id="navbarDropdown"
        role="button"
        data-toggle="dropdown"
    >
        <img
        src="/images/user.png"
        alt=""
        class="rounded-circle mr-2 profil-picture"
        />
        Helo, {{ Auth::user()->name }}
    </a>
        <div class="dropdown-menu">
            <a href="{{ Auth::user()->roles == 'ADMIN' ? url('/admin') : route('dashboard') }}" class="dropdown-item">Dashboard</a>
            <div class="dropdown-divider"></div>
            <a
                href="{{ route('logout') }}" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                class="dropdown-item">
            Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </div>
        </li>
        <li class="nav-item">
            <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                @php
                    $carts = \App\Models\Cart::where('users_id', Auth::user()->id)->count();
                @endphp
                @if ($carts > 0)
                    <img src="/images/icon-cart-field.svg" alt=""/> 
                    <div class="card-badge">
                        {{ $carts }}
                    </div>
                @else
                <img src="/images/icon-cart-empty.svg" alt=""/> 
                @endif
            </a>
        </li>
    </ul>

    <!-- Mobile Menu -->
        <ul class="navbar-nav d-block d-lg-none">
            <li class="nav-item">
                <a href="{{ route('search-redirect') }}" class="nav-link">
                    Search
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cart') }}" class="nav-link">
                    Cart
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    Helo, {{ Auth::user()->name }}
                </a>
            </li>
        </ul>
        @endauth
    </div>
   </div>
</nav>