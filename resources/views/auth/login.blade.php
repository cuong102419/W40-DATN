<title>Login/Signin</title>
@include('auth.css')
</head>
<button class="btn">
    <div class=""><a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Home</a>
</button>

<body>
    <div class="wrapper" id="form-wrapper">
        <div class="form-container1" id="login-container">
            <form action="{{ route('login.login') }}" method="post">
                @csrf
                <h2>Đăng nhập</h2>
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Mật khẩu">
                <div class="remember-container">
                    <a href="#" class="toggle-link">Quên mật khẩu?</a>
                </div>
                <button type="submit">Đăng nhập</button>
                <p class="toggle-link" onclick="showSignup()">Bạn chưa có tài khoản? Đăng ký</p>
            </form>
        </div>

        <div class="form-container" id="signup-container">
            <form action="{{ route('signup') }}" method="post">
              @csrf
                <h2>Đăng ký</h2>
                <input type="email" name="email" id="signup-email" placeholder="Email">
                <input type="text" name="name" id="signup-username" placeholder="Họ tên">
                <input type="password" name="password" id="signup-password" placeholder="Mật khẩu">
                <input type="password" name="confirm_password" id="signup-confirm-password" placeholder="Nhập lại mật khẩu">
                <button type="submit">Đăng ký</button>
            </form>
            <p class="toggle-link" onclick="showLogin()">Bạn đã có tài khoản. Đăng nhập</p>
        </div>

        <div class="overlay overlay-default"></div>
    </div>
    @include('auth.js')
</body>
