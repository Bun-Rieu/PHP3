@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>{{ $title ?? 'Thêm Sản Phẩm Mới' }}</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
            <div class="form-group">
                <label for="name">Tên Sản Phẩm</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 form">
                <label for="categories_id">Danh Mục</label>
                <select id="categories_id" name="categories_id" class="form-control @error('categories_id') is-invalid @enderror">
                    <option value="">Chọn Danh Mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categories_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('categories_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 form">
                <label for="brand_id">Thương Hiệu</label>
                <select id="brand_id" name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                    <option value="">Chọn Thương Hiệu</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 form">
                <label for="price">Giá Sản Phẩm</label>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" step="0.01" >
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 form">
                <label for="stock">Số Lượng Sản Phẩm</label>
                <input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock') }}" >
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku" class="form-control @error('sku') is-invalid @enderror"
                       value="{{ old('sku') }}" readonly>
                @error('sku')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="image">Ảnh Chính (Chọn 1 ảnh)</label>
                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"
                       accept="image/*" onchange="previewImage(event)">
                <div class="mt-2">
                    <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 150px; height: auto;">
                </div>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="images">Ảnh Phụ (Chọn nhiều ảnh)</label>
                <input type="file" id="images" name="images[]" class="form-control @error('images.*') is-invalid @enderror"
                       accept="image/*" multiple onchange="previewMultipleImages(event)">
                <div id="imagePreviewContainer" class="mt-2 d-flex flex-wrap"></div>
                @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <label for="description">Mô Tả</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                          rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
<br>
            <!-- Phần thêm biến thể -->
            <div class="form-group">
            <h5>Biến Thể Sản Phẩm</h5>
                <div id="variations-container">
                    <div class="variation-row mb-3 p-3 border rounded" id="variation-template" style="display: none;">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Kích Thước</label>
                                <input type="text" name="variations[0][size]" class="form-control" placeholder="S, M, L">
                            </div>
                            <div class="col-md-2">
                                <label>Màu Sắc</label>
                                <input type="text" name="variations[0][color]" class="form-control" placeholder="Đen, Trắng, Đỏ">
                            </div>
                            <div class="col-md-2">
                                <label>Giá</label>
                                <input type="number" name="variations[0][price]" class="form-control" step="0.01" placeholder="Giá ">
                            </div>
                            <div class="col-md-2">
                                <label>Số Lượng</label>
                                <input type="number" name="variations[0][stock]" class="form-control" placeholder="Số lượng">
                            </div>
                            <div class="col-md-2">
                    <label class="form-label">Ảnh</label>
                    <input type="file" name="variations[${variationCount}][image]" class="form-control variation-image" accept="image/*">
                    <img class="variation-preview mt-2 d-none" src="#" alt="Preview" style="max-width: 100px; height: auto;">
                </div>
                            <br>
                             <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-variation w-80">
                               <i class="fas fa-trash-alt"></i> Xóa
                               </button>
                           </div>

                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary mt-2" id="add-variation">➕ Thêm Biến Thể</button>
            </div>

            <div class="form-check form-switch mt-4">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                       value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Kích Hoạt sản phẩm</label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-3">Thêm Sản Phẩm</button>
                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary mt-3">Hủy</a>
            </div>
        </form>
    </div>

    <script>

        let variationCount = 0;

        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    imagePreview.style.display = 'block';
                    imagePreview.src = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        }

        function previewMultipleImages(event) {
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreviewContainer.innerHTML = '';
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.style.maxWidth = '100px';
                    imgElement.style.height = 'auto';
                    imgElement.style.margin = '5px';
                    imagePreviewContainer.appendChild(imgElement);
                };
                reader.readAsDataURL(files[i]);
            }
        }

        function previewVariationImage(event, index) {
            const file = event.target.files[0];
            const preview = event.target.nextElementSibling;

            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    preview.style.display = 'block';
                    preview.src = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }

        function generateSku() {
            const randSku = 'SKU-' + Math.floor(Math.random() * 1000000);
            document.getElementById('sku').value = randSku;
        }

        document.addEventListener('DOMContentLoaded', function() {
            generateSku();

            const addVariationBtn = document.getElementById('add-variation');
            const variationsContainer = document.getElementById('variations-container');

            addVariationBtn.addEventListener('click', function() {
                const template = document.getElementById('variation-template').cloneNode(true);
                template.style.display = 'block';
                template.id = '';

                template.querySelectorAll('input').forEach(input => {
                    const name = input.name.replace('variations[0]', `variations[${variationCount}]`);
                    input.name = name;
                    if (input.type === 'file') {
                        input.setAttribute('onchange', `previewVariationImage(event, ${variationCount})`);
                    }
                });

                variationsContainer.appendChild(template);
                variationCount++;
            });

            variationsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-variation')) {
                    event.target.closest('.variation-row').remove();
                }
            });
        });
    </script>
@endsection
