@extends('layouts.master')
@section('title', 'Đăng Nhập')
@section('content')
<style>
    /* Login form CSS - giữ cấu trúc HTML không thay đổi */
    .login-container {
        max-width: 550px;
        margin: 30px auto;
        padding: 30px;
        border: 1px solid #e0e0e0;
        font-family: 'Poppins', sans-serif;
        box-shadow: none;
    }

    .login-container h2 {
        text-align: center;
        font-size: 24px;
        font-weight: 600;
        color: #212121;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .login-container form {
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

    /* Description text below heading */
    .login-container h2::after {
        content: "Vui lòng nhập thông tin để đăng nhập";
        display: block;
        text-align: center;
        color: #757575;
        font-size: 14px;
        font-weight: normal;
        margin: 10px 0 20px;
    }

    /* Login button */
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

    /* Forgot password and register link */
    .text-center {
        text-align: center;
        margin-top: 20px;
    }

    .text-center a {
        color: #212121;
        text-decoration: none;
        font-size: 14px;
    }

    .text-center a:hover {
        text-decoration: underline;
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

    /* Mobile responsive */
    @media (max-width: 768px) {
        .login-container {
            padding: 20px 15px;
        }

        .login-container h2 {
            font-size: 22px;
        }

        .login-container h2::after {
            font-size: 13px;
        }
    }
</style>

<div class="login-container shadow">
    <h2>Đăng Nhập</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <input type="email" class="form-control" name="email" placeholder="Nhập email" required>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
    </form>

    <div class="text-center mt-3">
        <p>Quên mật khẩu? <a href="#">Khôi phục ngay</a></p>
        <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
    </div>
</div>
@endsection
