<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabuku</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="navbar bg-base-100 shadow-sm">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="-1"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    @if (Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.books.index') }}">Manajemen Buku</a></li>
                        <li><a href="{{ route('admin.categories.index') }}">Manajemen Kategori</a></li>
                        <li><a href="{{ route('admin.users.index') }}">Manajemen Pengguna</a></li>
                        <li><a href="{{ route('admin.orders.index') }}">Manajemen Transaksi</a></li>
                    @else
                        <li>
                            <a href="{{ route('user.book.index') }}">Koleksi Buku</a>
                        </li>
                        <li>
                            <a href="{{ route('user.order.index') }}">Pesanan Saya</a>
                        </li>
                        <li>
                            <a href="{{ route('user.about-us') }}">About Us</a>
                        </li>
                    @endif
                </ul>
            </div>
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard.index') : route('user.dashboard.index') }}"
                class="btn btn-ghost text-xl">Kabuku</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                @if (Auth::user()->role === 'admin')
                    <li><a href="{{ route('admin.books.index') }}">Manajemen Buku</a></li>
                    <li><a href="{{ route('admin.categories.index') }}">Manajemen Kategori</a></li>
                    <li><a href="{{ route('admin.users.index') }}">Manajemen Pengguna</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">Manajemen Transaksi</a></li>
                @else
                    <li>
                        <a href="{{ route('user.book.index') }}">Koleksi Buku</a>
                    </li>
                    <li>
                        <a href="{{ route('user.order.index') }}">Pesanan Saya</a>
                    </li>
                    <li>
                        <a href="{{ route('user.about-us') }}">About Us</a>
                    </li>
                @endif
            </ul>
        </div>
        @auth
            <div class="navbar-end gap-4">
                @if (Auth::user()->role === 'user')
                    <a href="{{ route('user.cart.index') }}" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="badge badge-sm indicator-item">{{ Auth::user()->cart()->count() }}</span>
                        </div>
                    </a>

                    <a href="https://wa.me/62859102628529?text=Halo%2C%20saya%20mau%20tanya%20mengenai%20pesanan%20saya."
                        target="_blank" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-5 w-5" fill="currentColor">
                            <path
                                d="M112 128C85.5 128 64 149.5 64 176C64 191.1 71.1 205.3 83.2 214.4L291.2 370.4C308.3 383.2 331.7 383.2 348.8 370.4L556.8 214.4C568.9 205.3 576 191.1 576 176C576 149.5 554.5 128 528 128L112 128zM64 260L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 260L377.6 408.8C343.5 434.4 296.5 434.4 262.4 408.8L64 260z" />
                        </svg>
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn">Logout</button>
                </form>
            </div>
        @else
            <div class="navbar-end">
                <a href="{{ route('login') }}" class="btn">Login</a>
            </div>
        @endauth
    </div>

    <div class="my-4 mx-8 h-screen">
        @yield('content')
    </div>
</body>

</html>
