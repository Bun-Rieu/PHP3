<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} | Admin Dashboard</title>
    <link rel="icon" type="image/png" href="https://printgo.vn/uploads/media/772948/logo-thoi-trang-nam-1_1584632300.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="/" class="text-decoration-none"><h4 class="text-white text-center mb-4">Admin Shop</h4></a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="/admin#dashboard">
                    <i class="bi bi-house-door me-2"></i>Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#categoriesMenu" role="button">
                    <div><i class="bi bi-bookmark"></i> Danh Mục</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="categoriesMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" href="{{ route('admin.category.index') }}">Quản lí danh mục</a></li>
                        <li><a class="nav-link" href="{{ route('admin.brand.index') }}">Quản lí thương hiệu</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#productsMenu" role="button">
                    <div><i class="bi bi-box me-2"></i>Sản Phẩm</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="productsMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" href="{{ route('admin.product.index') }}                                                                                            ">Danh sách sản phẩm</a></li>
                        <li><a class="nav-link" href="{{ route('admin.product.create') }}">Thêm sản phẩm</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#blogMenu" role="button">
                    <div><i class="bi bi-bookmark"></i> Bài viết</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="blogMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" >Quản lí bài viết</a></li>
                        <li><a class="nav-link" >Quản lí thư viện</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#sliderMenu" role="button">
                    <div><i class="bi bi-bookmark"></i> Slider</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="sliderMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" >Danh sách hình sliderShow</a></li>
                        <li><a class="nav-link" >Danh mục sliderShow</a></li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#logoMenu" role="button">
                    <div><i class="bi bi-box me-2"></i>Hình ảnh</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="logoMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" >Logo & Banner</a></li>
                        <li><a class="nav-link" href="{{ route('admin.logo.create') }}" >Thêm logo</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#orderMenu" role="button">
                    <div><i class="bi bi-bookmark"></i> Đơn hàng</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="orderMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" >Quản lí đơn hàng</a></li>
                        <li><a class="nav-link" >Lịch sử đơn hàng</a></li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="/admin/users#users">
                    <i class="bi bi-person me-2"></i>Users
                </a>
            </li>

            <!-- Menu phân cấp Settings -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#settingsMenu" role="button">
                    <div><i class="bi bi-gear me-2"></i>Settings</div>
                    <i class="bi bi-chevron-down"></i>
                </a>

            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admin/reports#reports">
                    <i class="bi bi-bar-chart me-2"></i>Reports
                </a>
            </li>
        </ul>
    </div>

    <!-- Nội dung chính -->
    <div class="content container-fluid">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.sidebar .nav-link');

            function removeActive() {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('data-bs-toggle') === 'collapse') {
                        return;
                    }

                    removeActive();
                    this.classList.add('active');

                    const href = this.getAttribute('href');
                    window.location.href = href;
                });
            });

            function setActiveFromHash() {
                const hash = window.location.hash;
                if (hash) {
                    removeActive();
                    const targetLink = document.querySelector(`.sidebar .nav-link[href*="${hash}"]`);
                    if (targetLink) {
                        targetLink.classList.add('active');
                    }
                } else {
                    removeActive();
                    document.querySelector('.sidebar .nav-link').classList.add('active');
                }
            }

            setActiveFromHash();
            window.addEventListener('hashchange', setActiveFromHash);
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
