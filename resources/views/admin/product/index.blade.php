@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="fas fa-box"></i> Danh Sách Sản Phẩm</h2>
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm sản phẩm
            </a>
        </div>

        @if(session('success'))
            <script>
                iziToast.success({
                    title: 'Thành công',
                    message: '{{ session('success') }}',
                    position: 'topRight',
                    timeout: 3000
                });
            </script>
        @endif
        @if(session('error'))
            <script>
                iziToast.error({
                    title: 'Lỗi',
                    message: '{{ session('error') }}',
                    position: 'topRight',
                    timeout: 3000
                });
            </script>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Hình Ảnh</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td class="text-start">{{ $product->name }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" width="80">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ number_format($product->price) }} VNĐ</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="{{ route('admin.product.delete', $product->id) }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm {{ $product->name }} ?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
