<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Kai - Admin Register</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.imgur.com/jsGW21W.png">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/log-acc-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<x-navbar />

<div class="container">
    <div class="forms-container">
        <div class="signin-signup">
            <form action="{{ route('register.submit') }}" method="POST" class="sign-in-form">
                @csrf
                <h2 class="title">Đăng ký</h2>

                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Tên tài khoản" value="{{ old('name') }}" required>
                </div>

                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                </div>

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>

                <div class="input-field">
                    <i class="fa-solid fa-shield"></i>
                    <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                </div>

                @if ($errors->any())
                    <div class="text-red-500 mb-2">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <button type="submit" class="btn">Đăng ký</button>

                <p class="social-text">Hoặc đăng nhập bằng</p>
                <div class="social-media">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content" id="left">
                <h3>Đã có tài khoản rồi ?</h3>
                <a href="{{ route('login') }}">
                    <button class="btn transparent" id="sign-up-btn">Đăng nhập</button>
                </a>
            </div>
            <img src="{{ asset('img/signup.svg') }}" class="image" alt="signup">
        </div>
    </div>
</div>

<x-footer />

<script src="{{ asset('js/Script.js') }}"></script>
</body>
</html>
