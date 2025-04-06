@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Sửa sản phẩm</h2>
        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Important for PUT requests to indicate we're updating the resource -->
            <div class="row g-3">
                <div class="form-group">
                    <label for="name">Tên Sản Phẩm</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}"
                        required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">Danh Mục</label>
                    <select id="category" name="categories_id" class="form-control" required>
                        <option value="">Chọn Danh Mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('categories_id', $product->categories_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categories_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="brand">Thuong Hieu</label>
                    <select id="brand" name="brand_id" class="form-control" required>
                        <option value="">Chọn Thuong Hieu</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 ">
                    <label for="price">Giá Sản Phẩm</label>
                    <input type="number" id="price" name="price" class="form-control"
                        value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="col-md-6 ">
                    <label for="stock">Số Lượng Sản Phẩm</label>
                    <input type="number" id="stock" name="stock" class="form-control"
                        value="{{ old('stock', $product->stock) }}" required>
                </div>

                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                </div>

                <div class="col-md-6">
                    <label for="image">Ảnh Chính (Chọn 1 ảnh)</label>
                    <input type="file" class="form-control" id="image" name="image"
                        value="{{ old('image', $product->image) }}">
                    @if($product->image)
                        <div>
                            <img src="{{ Storage::url($product->image) }}" alt="Product Image"
                                style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif

                </div>

                <div class="col-md-6">
                    <label for="images">Ảnh Phụ (Chọn nhiều ảnh)</label>
                    <input type="file" id="images" name="images[]" class="form-control" multiple>
                    @if($product->images)
                        <div>
                            @foreach(json_decode($product->images) as $image)
                                <img src="{{ Storage::url($image) }}" alt="Additional Image"
                                    style="max-width: 100px; max-height: 100px; margin-right: 10px;">
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea id="description" name="description" class="form-control"
                        rows="4">{{ old('description', $product->description) }}</textarea>
                </div>



            </div>
            <div class="form-group">
                <h3>Biến thể Sản Phẩm</h3>
                @foreach($variations as $index => $variation)
                    <div class="variation-group">
                        <div class="row">
                            <h5>Biến thể {{ $index + 1 }}</h5>
                            <div class="col-md-2">
                                <label for="variations[{{ $index }}][size]">Kích Cỡ</label>
                                <input type="text" name="variations[{{ $index }}][size]" class="form-control"
                                    value="{{ old("variations.$index.size", $variation->size) }}">
                            </div>

                            <div class="col-md-2">
                                <label for="variations[{{ $index }}][color]">Màu Sắc</label>
                                <input type="text" name="variations[{{ $index }}][color]" class="form-control"
                                    value="{{ old("variations.$index.color", $variation->color) }}">
                            </div>

                            <div class="col-md-2">
                                <label for="variations[{{ $index }}][price]">Giá</label>
                                <input type="number" name="variations[{{ $index }}][price]" class="form-control"
                                    value="{{ old("variations.$index.price", $variation->price) }}">
                            </div>

                            <div class="col-md-2">
                                <label for="variations[{{ $index }}][stock]">Số Lượng</label>
                                <input type="number" name="variations[{{ $index }}][stock]" class="form-control"
                                    value="{{ old("variations.$index.stock", $variation->stock) }}">
                            </div>

                            <div class="col-md-2">
                                <label for="variations[{{ $index }}][image]">Ảnh Biến Thể</label>
                                @if($variation->image)
                                    <div>
                                        <img src="{{ Storage::url($variation->image) }}" alt="Variation Image"
                                            style="max-width: 100px; max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="variations[{{ $index }}][image]" class="form-control">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form-check form-switch mt-4">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Kích Hoạt Sản Phẩm</label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary mt-3">Thoát</a>
            </div>
        </form>
    </div>
@endsection
