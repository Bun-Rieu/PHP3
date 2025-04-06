@extends('layouts.admin')

@section('title', 'Trang Quản Trị')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Chào mừng đến với Trang Quản Trị</h1>
    <p>Chọn các chức năng quản lý dưới đây:</p>

    <div class="row">
    <!-- Thẻ hiển thị số lượng sản phẩm -->
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body text-center">
                <h2 class="display-4 font-weight-bold">6</h2>
                <p class="mb-2">Sản phẩm</p>
                <a href="{{ route('admin.product.index') }}" class="btn btn-light btn-sm">
                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Thẻ hiển thị số lượng danh mục sản phẩm -->
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body text-center">
            <h2 class="display-4 font-weight-bold">2</h2>
                <p class="mb-2">Danh mục sản phẩm</p>
                <a href="{{ route('admin.category.index') }}" class="btn btn-light btn-sm">
                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Thẻ hiển thị số lượng bài viết -->
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body text-center">
                <h2 class="display-4 font-weight-bold">0</h2>
                <p class="mb-2">Bài viết</p>
                <a  class="btn btn-light btn-sm">
                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Thẻ hiển thị số lượng đơn hàng chưa xử lý -->
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body text-center">
                <h2 class="display-4 font-weight-bold">0</h2>
                <p class="mb-2">Đơn hàng chưa xử lý</p>
                <a  class="btn btn-light btn-sm">
                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>


</div>
@endsection
