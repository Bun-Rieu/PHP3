<div class="card shadow p-4">
    <div class="card-body">
        @csrf
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-tag"></i> Tên Danh Mục</label>
            <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục" value="{{ old('name', $category->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-align-left"></i> Mô Tả</label>
            <textarea name="description" class="form-control" placeholder="Nhập mô tả">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-image"></i> Hình Ảnh</label>
            <input type="file" name="image" class="form-control">
            @if(isset($category) && $category->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$category->image) }}" class="img-thumbnail" width="120">
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer text-end">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Lưu</button>
        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Thoát</a>
    </div>
</div>

