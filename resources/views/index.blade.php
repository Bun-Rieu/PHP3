@extends('layouts.master')
@section('content')
    <div class="container py-4">

        <h2 class="mb-4 text-center text-orange">Sản Phẩm Nổi Bật</h2>


        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-3 product-grid">
            @foreach ($products as $product)
                <div class="col">
                    <div class="product-card">
                        <a href="{{ route('user.product.show', $product->slug) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-image"
                                alt="{{ $product->name }}">
                            <div class="card-body p-2">
                                <h6 class="product-title">{{ $product->name }}</h6>
                                <div class="price-section">
                                    <span class="price">{{ number_format($product->price) }}đ</span>

                                </div>
                                <div class="buttons d-none">
                                    <a href="{{ route('user.product.show', $product->slug) }}"
                                        class="btn btn-sm btn-orange w-100 mb-1">Mua Ngay</a>
                                    <a href="#" class="btn btn-sm btn-outline-orange w-100">Thêm Vào Giỏ</a>
                                </div>
                            </div>
                        </a>
                        <!-- Heart Icon -->
                        <div class="wishlist-icon">
                            <i class="far fa-heart"></i>
                        </div>
                        <!-- Cart Icon -->
                        <div class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">

            @if (isset($products) && $products->isEmpty())
                <div class="no-products-message">
                    <p>Không tìm thấy sản phẩm "{{ request()->input('search') }}".</p>
                </div>
            @endif
        </div>
        <br>
        <div class="d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
