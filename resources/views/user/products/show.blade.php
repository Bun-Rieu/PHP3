    @extends('layouts.master')

    @section('content')
                <div class="container my-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Trang chủ</a></li>
                            @if ($category)
                                <li class="breadcrumb-item"><a href="#">{{ $category->name }}</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="#">Không có danh mục</a></li>
                            @endif
                            @if ($brand)
                                <li class="breadcrumb-item"><a href="#">{{ $brand->name }}</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="#">Không có thương hiệu</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>

                    <div class="container py-4">
                        <div class="row">
                            <!-- Ảnh sản phẩm -->
                            <div class="col-md-6">
                <div id="mainImageContainer" class="position-relative mb-3">
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" id="mainImage"
                            class="img-fluid rounded w-100"
                            style="height: 600px; object-fit: contain; transition: opacity 0.3s;">
                    @else
                        <img src="https://via.placeholder.com/600" alt="No Image" id="mainImage"
                            class="img-fluid rounded w-100"
                            style="height: 600px; object-fit: contain;">
                    @endif

                    <!-- Navigation arrows -->
                    <div class="position-absolute top-50 start-0 translate-middle-y">
                        <button class="btn btn-light rounded-circle" onclick="changeImage('prev')" style="opacity: 0.7;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                    <div class="position-absolute top-50 end-0 translate-middle-y">
                        <button class="btn btn-light rounded-circle" onclick="changeImage('next')" style="opacity: 0.7;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                @if ($product->images)
                    <div class="row g-2" id="thumbnailContainer">
                        <!-- First thumbnail (main product image) -->
                        <div class="col-2">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                class="img-fluid rounded thumbnail-image active"
                                style="height: 100px; width: 100px; object-fit: cover; cursor: pointer; border: 2px solid #dc3545;"
                                onclick="changeMainImage('{{ Storage::url($product->image) }}', this)">
                        </div>

                        <!-- Additional thumbnails -->
                        @foreach (json_decode($product->images, true) as $index => $image)
                            <div class="col-2">
                                <img src="{{ Storage::url($image) }}" alt="Product view {{ $index + 1 }}"
                                    class="img-fluid rounded thumbnail-image"
                                    style="height: 100px; width: 100px; object-fit: cover; cursor: pointer; border: 2px solid transparent;"
                                    onclick="changeMainImage('{{ Storage::url($image) }}', this)">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

                            <!-- Thông tin sản phẩm -->
                            <div class="col-md-6">
                                <h1 class="h3 mb-2">{{ $product->name }}<span class="con-hang">Còn Hàng</span></h1>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-warning me-2"><i class="fas fa-star"></i> 4.8</span>
                                    <span class="text-muted">| 952 Đánh Giá</span>
                                </div>

                                <div class="mb-3" id="priceDisplay">
                                    <span class="text-danger h4 fw-bold"><span id="dynamicPrice">{{ number_format($product->price, 0) }} đ</span></span>
                                </div>

                                <p class="mb-3">
                                    <strong>Loại:</strong> <span id="category">{{ $category->name }}</span>
                                    <strong>SKU:</strong> <span id="sku">{{ $product->sku }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong>Thương hiệu: </strong> <span id="brand">{{ $brand->name }}</span>
                                </p>



                                <div class="promo-box">
                                    <p class="mb-1"><i class="fas fa-gift text-danger"></i> <strong>KHUYẾN MÃI - ƯU ĐÃI</strong></p>
                                    <p class="mb-1">Nhập mã HE10 GIẢM 10% TỐI ĐA 10K</p>
                                    <p class="mb-1">Nhập mã HE50 GIẢM 50K ĐƠN TỪ 699K</p>
                                    <p class="mb-1">Nhập mã HE80 GIẢM 80K ĐƠN TỪ 999K</p>
                                    <p class="mb-0">FREESHIP đơn từ 399K</p>
                                </div>

                                <p class="mb-2">Mã giảm giá bạn có thể sử dụng:</p>
                                <div class="d-flex gap-2 mb-3">
                                    <span class="badge bg-dark p-2">HE10</span>
                                    <span class="badge bg-dark p-2">HE50</span>
                                    <span class="badge bg-dark p-2">HE80</span>
                                </div>


                                <!-- Biến thể sản phẩm -->
                                @if (
            $variations->isNotEmpty() && $variations->contains(function ($variation) {
                return !is_null($variation->size) || !is_null($variation->color);
            })
        )
                 <!-- Màu sắc -->
                                @if ($variations->contains(fn($variation) => !is_null($variation->color)))
                                    <div class="form-group mb-4">
                                    <?php        $selectedColor = $variations->filter(fn($variation) => !is_null($variation->color))->first()->color; ?>
                                        <label class="d-block mb-2"><strong>Màu sắc:</strong> {{ $selectedColor }}</label>
                                        <div class="d-flex flex-wrap gap-2">
                                        @foreach ($variations->filter(fn($variation) => !is_null($variation->color))->unique('color') as $index => $variation)
                                        <div class="d-flex align-items-center me-3 mb-2">
                                    <div class="color-option me-2">
                                        <input type="radio" id="color-{{ $variation->color }}" name="color_variation" class="btn-check"
                                            value="{{ $variation->color }}" onchange="updateVariation({{ $variation->id }})"
                                            {{ $index === 0 ? 'checked' : '' }}>
                                        <label class="color-label d-flex align-items-center justify-content-center" for="color-{{ $variation->color }}"
                                            style="width: 40px; height: 40px; background-color: {{ $variation->color }}; border-radius: 50%;"></label>
                                    </div>
                                    <span>{{ $variation->color }}</span>
                                </div>
                            @endforeach
                                </div>
                                </div>
                            @endif

                <!-- Kích Cỡ -->
                @if ($variations->contains(fn($variation) => !is_null($variation->size)))
                    <div class="form-group mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <label class="mb-2"><strong>Kích thước:</strong></label>
                            <a href="#" class="text-decoration-none text-primary small">Hướng dẫn chọn size</a>
                        </div>
                        <div class="d-flex flex-wrap gap-2" role="group" aria-label="Size select">
                            @foreach ($variations->filter(fn($variation) => !is_null($variation->size))->unique('size') as $index => $variation)
                                <div class="size-option">
                                    <input type="radio" id="size-{{ $variation->size }}" name="size_variation" class="btn-check"
                                        value="{{ $variation->size }}" onchange="updateVariation({{ $variation->id }})"
                                        {{ $index === 0 ? 'checked' : '' }}>
                                    <label class="size-label" for="size-{{ $variation->size }}">
                                        {{ $variation->size }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <p class="mt-4">Sản phẩm này không có biến thể.</p>
            @endif



                                <!-- <div class="form-group mb-4">
                                    <label class="d-block mb-2"><strong>Màu sắc:</strong> Kem</label>
                                    <div class="d-flex align-items-center">
                                        <div class="color-option me-2">
                                            <input type="radio" id="color-kem" name="color_variation" class="btn-check" value="Kem"
                                                checked>
                                            <label class="color-label d-flex align-items-center justify-content-center" for="color-kem"
                                                style="width: 40px; height: 40px; background-color: #F3EFE0; border-radius: 50%;"></label>
                                        </div>
                                        <span>Kem</span>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <label class="mb-2"><strong>Kích thước:</strong></label>
                                        <a href="#" class="text-decoration-none text-primary small">Hướng dẫn chọn size</a>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2" role="group" aria-label="Size select">
                                        <div class="size-option">
                                            <input type="radio" id="size-S" name="size_variation" class="btn-check" value="S" checked>
                                            <label class="size-label" for="size-S">S</label>
                                        </div>
                                        <div class="size-option">
                                            <input type="radio" id="size-M" name="size_variation" class="btn-check" value="M">
                                            <label class="size-label" for="size-M">M</label>
                                        </div>
                                        <div class="size-option">
                                            <input type="radio" id="size-L" name="size_variation" class="btn-check" value="L">
                                            <label class="size-label" for="size-L">L</label>
                                        </div>
                                        <div class="size-option">
                                            <input type="radio" id="size-XL" name="size_variation" class="btn-check" value="XL">
                                            <label class="size-label" for="size-XL">XL</label>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="d-flex align-items-center mb-4">
                                    <button class="quantity-btn" id="decrease-btn">-</button>
                                    <input type="text" class="quantity-input mx-2" value="1" id="quantity">
                                    <button class="quantity-btn" id="increase-btn">+</button>
                                    <span class="ms-3" id="stock">Có {{ $product->stock }} cửa hàng còn sản phẩm này</span>
                                </div>
                                <form action="{{ route('cart.store') }}" method="POST">
                                <div class="d-grid gap-2 mb-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <input type="hidden" name="product_variations_id" id="variation-id" value="{{ $variation ? $variation->id : '' }}">
                                <button type="submit" class="btn btn-outline-danger btn-lg">Thêm Vào Giỏ Hàng</button>
                                </form>
                                 <button class="btn btn-danger btn-lg" type="button">MUA NGAY</button>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <div class="text-center">
                                        <i class="fas fa-box fa-2x mb-2"></i>
                                        <p class="small">Miễn phí đổi trả<br>trong 7 ngày</p>
                                    </div>
                                    <div class="text-center">
                                        <i class="fas fa-truck fa-2x mb-2"></i>
                                        <p class="small">Giao hàng<br>toàn quốc</p>
                                    </div>
                                    <div class="text-center">
                                        <i class="fas fa-shield-alt fa-2x mb-2"></i>
                                        <p class="small">Bảo đảm<br>chất lượng</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="">Mô tả</h3>
                            <p class="mb-2"> {{ $product->description ?? 'Không có mô tả' }}</p>
                        </div>
                    </div>
                </div>



                <script>
        /**
         * Product gallery and variation handling
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Gallery handling
            let currentImageIndex = 0;
            const thumbnails = document.querySelectorAll('.thumbnail-image');
            const mainImage = document.getElementById('mainImage');

            // Initialize image gallery
            if (thumbnails.length > 0 && mainImage) {
                // Set up thumbnail click events
                thumbnails.forEach((thumbnail, index) => {
                    thumbnail.addEventListener('click', function() {
                        changeMainImage(this.src, this);
                    });
                });
            }

            /**
             * Change main product image with fade transition
             * @param {string} imageSrc - URL of the new image
             * @param {HTMLElement} thumbnail - The thumbnail element that was clicked (optional)
             */
            function changeMainImage(imageSrc, thumbnail = null) {
                if (!mainImage) {
                    console.error('Main image element not found');
                    return;
                }

                if (!imageSrc || typeof imageSrc !== 'string' || imageSrc.trim() === '') {
                    console.error('Invalid image URL:', imageSrc);
                    return;
                }

                // Add fade-out effect
                mainImage.style.opacity = '0';

                // Handle image loading errors
                mainImage.onerror = () => {
                    console.error('Failed to load image:', imageSrc);
                    mainImage.src = 'https://via.placeholder.com/600';
                    mainImage.style.opacity = '1';
                };

                // Update image with delay for transition
                setTimeout(() => {
                    mainImage.src = imageSrc;
                    mainImage.style.opacity = '1';
                }, 300);

                // Update thumbnail highlighting if provided
                if (thumbnail && thumbnails.length > 0) {
                    // Remove active class from all thumbnails
                    thumbnails.forEach(thumb => {
                        thumb.style.borderColor = 'transparent';
                    });

                    // Add active class to clicked thumbnail
                    thumbnail.style.borderColor = '#dc3545';

                    // Update current index for arrow navigation
                    for (let i = 0; i < thumbnails.length; i++) {
                        if (thumbnails[i] === thumbnail) {
                            currentImageIndex = i;
                            break;
                        }
                    }
                }
            }

            /**
             * Navigate through images using arrow buttons
             * @param {string} direction - 'next' or 'prev'
             */
            function changeImage(direction) {
                if (thumbnails.length === 0) return;

                let newIndex;
                if (direction === 'next') {
                    newIndex = (currentImageIndex + 1) % thumbnails.length;
                } else {
                    newIndex = (currentImageIndex - 1 + thumbnails.length) % thumbnails.length;
                }

                // Simulate click on the thumbnail
                changeMainImage(thumbnails[newIndex].src, thumbnails[newIndex]);
            }

            // Set up arrow navigation buttons
            const prevButton = document.querySelector('.btn.btn-light:first-child');
            const nextButton = document.querySelector('.btn.btn-light:last-child');

            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    changeImage('prev');
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    changeImage('next');
                });
            }

            // Variation handling
            /**
             * Update product details based on selected variation
             * @param {number} variationId - ID of the selected variation
             */
            function updateVariation(variationId) {
                const variations = JSON.parse(document.getElementById('variations-data').textContent);
                const variation = variations.find(v => v.id == variationId);

                if (variation) {
                    const priceDisplay = document.getElementById('priceDisplay');
                    const stock = document.getElementById('stock');

                    // Update price
                    if (priceDisplay) {
                        const priceElement = priceDisplay.querySelector('.text-danger');
                        if (priceElement) {
                            if (variation.price) {
                                priceElement.textContent = number_format(variation.price, 0) + 'đ';
                            } else {
                                priceElement.textContent = number_format(document.getElementById('base-price').value, 0) + 'đ';
                            }
                        }
                    }

                    // Update stock info
                    if (stock) {
                        const baseStock = document.getElementById('base-stock').value;
                        stock.textContent = 'Có ' + (variation.stock || baseStock) + ' cửa hàng còn sản phẩm này';
                    }

                    // Update image if variation has one
                    if (variation.image) {
                        const baseUrl = document.getElementById('storage-url').value;
                        changeMainImage(baseUrl + variation.image);
                    } else {
                        const defaultImage = document.getElementById('default-image').value;
                        if (defaultImage) {
                            changeMainImage(defaultImage);
                        } else {
                            changeMainImage('https://via.placeholder.com/600');
                        }
                    }
                } else {
                    console.error('Variation not found for ID:', variationId);
                }
            }

            // Set up quantity buttons
            const decreaseBtn = document.getElementById('decrease-btn');
            const increaseBtn = document.getElementById('increase-btn');
            const quantityInput = document.getElementById('quantity');

            if (decreaseBtn && increaseBtn && quantityInput) {
                decreaseBtn.addEventListener('click', function() {
                    const currentValue = parseInt(quantityInput.value);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });

                increaseBtn.addEventListener('click', function() {
                    const currentValue = parseInt(quantityInput.value);
                    quantityInput.value = currentValue + 1;
                });

                quantityInput.addEventListener('change', function() {
                    if (this.value < 1 || isNaN(this.value)) {
                        this.value = 1;
                    }
                });
            }

            /**
             * Format numbers with thousand separators
             * @param {number} number - Number to format
             * @param {number} decimals - Number of decimal places
             * @param {string} dec_point - Decimal point character
             * @param {string} thousands_sep - Thousands separator character
             * @returns {string} Formatted number
             */
            function number_format(number, decimals = 0, dec_point = '.', thousands_sep = ',') {
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                const n = !isFinite(+number) ? 0 : +number;
                const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
                const sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
                const dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
                let s = '';

                const toFixedFix = function (n, prec) {
                    const k = Math.pow(10, prec);
                    return Math.round(n * k) / k;
                };

                s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }

                return s.join(dec);
            }

            // Expose functions to global scope
            window.changeMainImage = changeMainImage;
            window.changeImage = changeImage;
            window.updateVariation = updateVariation;
            window.number_format = number_format;
        });
                </script>
    @endsection
