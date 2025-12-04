<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Kai - Đăng ký</title>
    
    <link rel="shortcut icon" type="x-icon" href="https://i.imgur.com/jsGW21W.png">

    <link rel="stylesheet" href="{{ asset('css/log-acc-styles.css') }}">

    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body> 

    @includeIf('inc.navbar') 

    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                
                <form action="{{ route('register') }}" class="sign-in-form" method="POST">
                    @csrf <h2 class="title">Đăng ký</h2>
          
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" placeholder="Tên tài khoản" value="{{ old('name') }}" required autofocus />
                    </div>
                    @error('name')
                        <span style="color: red; font-size: 12px; margin-bottom: 10px; display:block;">{{ $message }}</span>
                    @enderror

                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                    </div>
                    @error('email')
                        <span style="color: red; font-size: 12px; margin-bottom: 10px; display:block;">{{ $message }}</span>
                    @enderror

                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Mật khẩu" required autocomplete="new-password" />
                    </div>
                    @error('password')
                        <span style="color: red; font-size: 12px; margin-bottom: 10px; display:block;">{{ $message }}</span>
                    @enderror

                    <div class="input-field">
                        <i class="fa-solid fa-shield"></i>
                        <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required />
                    </div>
          
                    <button type="submit" class="btn">Đăng ký</button>
                    
                    <p class="social-text">Hoặc đăng nhập bằng</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                    </div>
                </form>

                @if (session('status'))
                    <script>alert("{{ session('status') }}");</script>
                @endif
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                @auth
                    {{-- Nếu đã đăng nhập thì hiển thị gì đó hoặc để trống --}}
                    @if(Auth::user()->type == 'admin')
                        @endif
                @endauth

                @guest
                    <div class="content" id="left">
                        <h3>Đã có tài khoản rồi ?</h3>
                        <a href="{{ route('login') }}">
                            <button class="btn transparent" id="sign-up-btn">Đăng nhập</button> 
                        </a> 
                    </div>
                @endguest
                
                <img src="{{ asset('img/signup.svg') }}" class="image" alt="" />
            </div>
        </div>
    </div>
    
    <footer id="footer" class="footer">
        <div class="footer-container">
            <div class="footer-link-1">
                <img class="logo" src="https://i.imgur.com/IIfskYh.png" >
                <ul class="flex">
                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-facebook-messenger"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-discord"></i></a></li>
                </ul>
            </div>

            <div class="footer-link-2">
                <ul class="flex">
                    <li><a href="#">Cái mục</a></li>
                    <li><a href="#">Nhìn</a></li>
                    <li><a href="#">Cho</a></li>
                    <li><a href="#">Chuyên Nghiệp</a></li>
                </ul>
                <p class="text">&copy; GAMING KAI | COPYRIGHT</p>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/Script.js') }}"></script>
</body>
</html>