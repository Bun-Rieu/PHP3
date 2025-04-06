<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\CartController;





//Admin
Route::middleware('check.role:admin')->group(function () {
    Route::get('/admin', function () {
        $title = 'Trang quản trị';
        return view('admin.index', compact('title'));
    });
    //Danh mục
    Route::prefix('admin/category')->name('admin.category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    });
    //Thương hiệu
    Route::prefix('admin/brand')->name('admin.brand.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [BrandController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [BrandController::class, 'delete'])->name('delete');
    });
    //Sản Phẩm
    Route::prefix('admin/product')->name('admin.product.')->group(function () {
        Route::get('/', [ProductController::class, 'indexadmin'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
    });
    //Logo
    Route::prefix('admin/logo')->name('admin.logo.')->group(function () {
        Route::get('/', [LogoController::class, 'index'])->name('index');
        Route::get('/create', [LogoController::class, 'create'])->name('create');
        Route::post('/store', [LogoController::class, 'store'])->name('store');
        Route::get('/set-active/{id}', [LogoController::class, 'setActive'])->name('set-active');
        Route::get('/toggle-active/{id}', [LogoController::class, 'toggleActive'])->name('toggle-active');
        Route::get('/delete/{id}', [LogoController::class, 'delete'])->name('delete');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart/update/{id}/{change}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
    Route::get('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/cart/delete-selected', [CartController::class, 'deleteSelected'])->name('cart.delete.selected');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});


//User
Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/user/product/{slug}', [ProductController::class, 'show'])->name('user.product.show');

Route::get('/user/product', [UserProductController::class, 'index'])->name('user.product.index');


// Route đăng ký
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'LoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
// Route đăng xuất
Route::post('/logout', [UserController::class, 'logout'])->name('logout');



//404 Notfound
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});



// About lab1
Route::get('/about', function () {
    // Render dữ liệu cho view
    $data = [
        'name' => 'Lương Phạm Huy',
        'age' => 20,
        'address' => 'Nam Nung, Krông Nô, Đắk Nông, Việt Nam',
        'phone' => '0848351310',
        'email' => 'huylppk03563@gmail.com',
        'skills' => ['HTML', 'CSS', 'JS', 'PHP'],
        'profile' => 'frontend developer',
        'about' => 'Curabitur không phải là thời điểm tốt nhất cho những người chơi đã đọc sách. Đó là một kho lưu trữ, một lớp tài chính, đồng thời là một hãng hàng không. Đó là một khối khôn ngoan, thung lũng thậm chí không dành cho trẻ em, nó chỉ cần thiết. Không có nhà phát triển hãng hàng không.
Mauris tâng bốc giới thượng lưu, cần sự tin cậy nibh pulvinar a. Vivamus suscepti tortor eget felis porttitor volutpat. Công trình, cái sân quan trọng hơn yếu tố phương tiện nhưng lại quan trọng đối với gia chủ. phà trên biển
Không có nhà phát triển hãng hàng không. Mọi người đều muốn ngoại trừ giá ở mức lacinia cho yếu tố đó. Không có nhà phát triển hãng hàng không. Mauris tâng bốc giới thượng lưu, cần sự tin cậy nibh pulvinar a.'
    ];

    return view('about', $data);
})->name('about');
