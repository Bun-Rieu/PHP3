<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang Chủ') shop</title>
    <link rel="icon" type="image/png"
        href="https://printgo.vn/uploads/media/772948/logo-thoi-trang-nam-1_1584632300.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    @yield('styles')

</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
</style>

<body>


    <!-- Top Bar -->
    <div class="shopee-top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="navbar-brand shopee-logo" href="{{ url('/') }}">
                    @php
                        $logo = \App\Models\Logo::where('is_active', true)->first();
                    @endphp
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo->image) }}" alt="Thêm logo ở trang admin" height="40"
                            onerror="this.src='{{ asset('images/default-logo.png') }}';">
                    @else
                        <span class="text-white">Thêm logo ở trang admin</span>
                    @endif
                </a>


                <form class="d-flex mx-auto shopee-search" method="GET" action="{{ route('product.index') }}">
                    <div class="input-group">
                        <input type="text" class="form-control me-2" placeholder="Bạn đang tìm gì......" name="search"
                            value="{{ request()->input('search') }}">
                        <button class="btn btn-orange border" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>

                <a href="{{ route('user.product.index') }}" class="text-white">Sản phẩm</a>

                <li class="nav-item">
                    <a href="{{ url('/cart') }}" class="text-white mx-4"><i class="fas fa-shopping-cart"></i> </a>
                </li>

                <!-- Right Side Links -->
                <div class="shopee-top-links">
                    @guest
                        <a href="{{ route('register') }}" class="text-white">Đăng Ký</a>
                        <span class="text-white mx-2">|</span>
                        <a href="{{ route('login') }}" class="text-white">Đăng Nhập</a>
                    @endguest
                    @auth
                        <a href="#" class="text-white dropdown-toggle" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item text-black" href="{{ url('/about') }}">Hồ sơ</a></li>
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item text-black" href="{{ url('/admin') }}">Quản trị</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    @endauth
                </div>
            </div>
        </div>
    </div>


    <!-- Categories Bar -->
    <!-- <div class="shopee-categories-bar">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center">
                @if (isset($categories) && $categories->isNotEmpty())
                    @foreach ($categories as $category)
                        <div class="category-item">
                            <a href="{{ route('product.index', ['category' => $category->id]) }}" class="category-link">{{ $category->name }}</a>

                            @if ($category->brands->isNotEmpty())
                                <div class="brand-dropdown">
                                    @foreach ($category->brands as $brand)
                                        <a href="{{ route('product.index', ['category' => $category->id, 'brand' => $brand->id]) }}" class="brand-link">{{ $brand->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div> -->


    <div class="container mt-4">
        @yield('content')
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
