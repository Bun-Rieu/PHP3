@extends('layouts.master')
@section('title', 'Đăng Ký')
@section('content')
<style>
  /* Registration form CSS - keep the HTML structure unchanged */
.register-container {
    max-width: 550px;
    margin: 30px auto;
    padding: 30px;
    border: 1px solid #e0e0e0;
    font-family: 'Poppins', sans-serif;
    box-shadow: none;
}

.register-container h2 {
    text-align: center;
    font-size: 24px;
    font-weight: 600;
    color: #212121;
    margin-bottom: 5px;
    text-transform: uppercase;
}

.register-container form {
    margin-top: 20px;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 14px;
    box-shadow: none;
    height: auto;
}

.form-control:focus {
    outline: none;
    border-color: #bdbdbd;
    box-shadow: none;
}

/* Add this class to your radio buttons container */
.gender-container {
    display: flex;
    margin-bottom: 15px;
}

/* Style for radio buttons */
input[type="radio"] {
    width: 18px;
    height: 18px;
    margin-right: 8px;
    accent-color: #757575;
}

label {
    font-size: 14px;
    color: #212121;
    margin-right: 30px;
}

/* Style for date input */
input[type="date"] {
    position: relative;
    padding-right: 40px;
}

/* Create a description paragraph after h2 */
.register-container h2::after {
    content: "Quý khách vui lòng nhập thông tin để đăng ký";
    display: block;
    text-align: center;
    color: #757575;
    font-size: 14px;
    font-weight: normal;
    margin: 10px 0 20px;
}

/* Terms text */
.terms-text {
    font-size: 13px;
    color: #757575;
    margin: 10px 0 20px;
}

.terms-text a {
    color: #1976d2;
    text-decoration: none;
}

/* Register button */
.btn-primary {
    width: 100%;
    padding: 12px;
    background-color: #c4122f;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    text-transform: uppercase;
    transition: background-color 0.2s ease;
}

.btn-primary:hover {
    background-color: #a50f27;
}

/* Social buttons - not in the image */
.social-btn {
    display: none;
}

/* Login link - change to back link */
.login-ok {
    text-align: center;
    margin-top: 20px;
}

.login-ok a {
    color: #212121;
    text-decoration: none;
    font-size: 14px;
}

.login-ok a:hover {
    text-decoration: underline;
}

.login-ok a::before {
    content: "←";
    margin-right: 5px;
}

/* Error messages */
.alert-danger {
    font-size: 12px;
    color: #c4122f;
    background-color: #ffe6e6;
    padding: 5px 10px;
    border-radius: 4px;
    margin-top: -10px;
    margin-bottom: 15px;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .register-container {
        padding: 20px 15px;
    }

    .register-container h2 {
        font-size: 22px;
    }

    .register-container h2::after {
        font-size: 13px;
    }
}
</style>

<div class="register-container shadow">
    <h2>Đăng Ký</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên" required>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
            @error('phone')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
            @error('password_confirmation')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
    </form>

    <div class="text-center mt-3">
        <p>Hoặc đăng ký với</p>
        <div class="social-btn">
            <a href="#" class="google-btn">
                <i class="fab fa-google"></i> Google
            </a>
            <a href="#" class="facebook-btn">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
        </div>
    </div>

    <div class="login-ok">
        <p>Đã có tài khoản? <a href="/login">Đăng Nhập</a></p>
    </div>
</div>
@endsection



