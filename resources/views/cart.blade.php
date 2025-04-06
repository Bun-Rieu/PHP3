@extends('layouts.master')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4 fw-bold">Giỏ Hàng</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($carts->isEmpty())
        <div class="card shadow-sm rounded">
                <div class="card-header bg-light py-3">
                    <div class="row align-items-center fw-bold">
                        <div class="col-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="select-all" onclick="toggleSelectAll()">
                                <label class="form-check-label" for="select-all"></label>
                            </div>
                        </div>
                        <div class="col-4">Sản Phẩm</div>
                        <div class="col-2 text-center">Đơn Giá</div>
                        <div class="col-2 text-center">Số Lượng</div>
                        <div class="col-2 text-center">Thành Tiền</div>
                        <div class="col-1 text-center">Thao Tác</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @foreach ($carts as $cart)
                        <div class="row align-items-center p-3 border-bottom m-0 cart-item">
                            <div class="col-1">
                                <div class="form-check">
                                    <input type="checkbox" name="selected_items[]" value="{{ $cart->id }}" class="form-check-input cart-item-checkbox" onclick="updateTotal()" form="cart-form">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <img src="{{ $cart->product->image ? Storage::url($cart->product->image) : 'https://via.placeholder.com/80' }}"
                                             alt="{{ $cart->product->name }}"
                                             class="rounded"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-semibold">{{ $cart->product->name }}</p>
                                        @if ($cart->variation)
                                            <span class="badge bg-light text-dark">
                                                @if ($cart->variation->size)
                                                    {{ $cart->variation->size->name }}
                                                @endif
                                                @if ($cart->variation->color)
                                                    <span class="mx-1">|</span>
                                                    <span style="display: inline-block; width: 12px; height: 12px; background-color: {{ $cart->variation->color->code }}; border-radius: 50%; margin-right: 3px;"></span>
                                                    {{ $cart->variation->color->name }}
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <span class="text-danger fw-semibold">đ{{ number_format($cart->price, 0) }}</span>
                            </div>
                            <div class="col-2 text-center">
                                <div class="input-group quantity-control" style="width: 120px; margin: 0 auto;">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="updateQuantity(this, -1, {{ $cart->id }})">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" name="quantity" class="form-control text-center quantity-input" value="{{ $cart->quantity }}"
                                           min="1" max="{{ $cart->variation ? $cart->variation->stock : $cart->product->stock }}"
                                           data-id="{{ $cart->id }}" onchange="submitQuantityForm(this)">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="updateQuantity(this, 1, {{ $cart->id }})">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <form id="quantity-form-{{ $cart->id }}" action="{{ route('cart.update.quantity', $cart->id) }}" method="POST" class="d-none">
                                    @csrf
                                    <input type="hidden" name="quantity" value="{{ $cart->quantity }}">
                                </form>
                            </div>
                            <div class="col-2 text-center">
                                <span class="text-danger fw-bold" data-unit-price="{{ $cart->price }}" data-quantity="{{ $cart->quantity }}">
                                    đ{{ number_format($cart->price * $cart->quantity, 0) }}
                                </span>
                            </div>
                            <div class="col-1 text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $cart->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <form action="{{ route('cart.checkout') }}" method="POST" id="cart-form">
                @csrf
                <div class="card mt-4 shadow-sm sticky-bottom">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <div class="form-check d-inline-block">
                                <input type="checkbox" class="form-check-input" id="select-all-footer" onclick="toggleSelectAll()">
                                <label class="form-check-label" for="select-all-footer">Chọn Tất Cả ({{ $carts->count() }})</label>
                            </div>
                            <button type="button" class="btn btn-link text-danger p-0 ms-3" onclick="deleteSelectedItems()">
                                <i class="bi bi-trash me-1"></i>Xóa đã chọn
                            </button>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-4 text-end">
                                <span class="d-block mb-1">Tổng thanh toán (<span id="selected-count" class="fw-bold">0</span> sản phẩm):</span>
                                <span class="text-danger fs-4 fw-bold">đ<span id="total-price">0</span></span>
                            </div>
                            <button type="submit" class="btn btn-danger btn-lg px-4">
                                <i class="bi bi-bag-check me-2"></i>Mua Hàng
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Xác nhận xóa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Xóa</a>
                        </div>
                    </div>
                </div>
            </div>

        @else
        <div class="alert alert-info p-4 text-center">
                <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                <p class="mb-3">Giỏ hàng của bạn đang trống.</p>
                <a href="{{ route('product.index') }}" class="btn btn-primary">Mua sắm ngay!</a>
            </div>

        @endif
    </div>

    <script>
        function toggleSelectAll() {
            const selectAll = document.getElementById('select-all');
            const selectAllFooter = document.getElementById('select-all-footer');
            const checkboxes = document.querySelectorAll('.cart-item-checkbox');

            // Sync both checkboxes
            if (this.id === 'select-all') {
                selectAllFooter.checked = selectAll.checked;
            } else {
                selectAll.checked = selectAllFooter.checked;
            }

            // Apply to all item checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });

            updateTotal();
        }

        function updateTotal() {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox:checked');
            let total = 0;
            let selectedCount = checkboxes.length;

            checkboxes.forEach(checkbox => {
                const cartItem = checkbox.closest('.cart-item');
                const priceElement = cartItem.querySelector('[data-unit-price]');
                const price = parseFloat(priceElement.getAttribute('data-unit-price'));
                const quantity = parseInt(priceElement.getAttribute('data-quantity'));
                total += price * quantity;
            });

            document.getElementById('selected-count').textContent = selectedCount;
            document.getElementById('total-price').textContent = number_format(total, 0);

            // Update select all checkboxes status
            const allCheckboxes = document.querySelectorAll('.cart-item-checkbox');
            const selectAll = document.getElementById('select-all');
            const selectAllFooter = document.getElementById('select-all-footer');

            if (allCheckboxes.length === checkboxes.length && allCheckboxes.length > 0) {
                selectAll.checked = true;
                selectAllFooter.checked = true;
            } else {
                selectAll.checked = false;
                selectAllFooter.checked = false;
            }
        }

        function updateQuantity(button, change, cartId) {
            const inputElement = button.parentElement.querySelector('.quantity-input');
            let currentValue = parseInt(inputElement.value);
            let newValue = currentValue + change;

            // Check min/max constraints
            const min = parseInt(inputElement.getAttribute('min'));
            const max = parseInt(inputElement.getAttribute('max'));

            if (newValue < min) newValue = min;
            if (newValue > max) newValue = max;

            if (currentValue !== newValue) {
                inputElement.value = newValue;
                submitQuantityForm(inputElement);
            }
        }

        function submitQuantityForm(input) {
            const cartId = input.getAttribute('data-id');
            const form = document.getElementById('quantity-form-' + cartId);
            form.querySelector('input[name="quantity"]').value = input.value;
            form.submit();
        }

        function confirmDelete(cartId) {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            document.getElementById('confirmDeleteBtn').href = "{{ route('cart.delete', '') }}/" + cartId;
            modal.show();
        }

        function deleteSelectedItems() {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm để xóa!');
                return;
            }

            if (confirm('Bạn có chắc chắn muốn xóa ' + checkboxes.length + ' sản phẩm đã chọn?')) {
                const form = document.getElementById('cart-form');
                form.action = '{{ route('cart.delete.selected') }}';
                form.submit();
            }
        }

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

        // Initialize total calculation on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });
    </script>
@endsection
