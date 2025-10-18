<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
</head>
<body>
    <div class="login-container">
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <h2>Đăng nhập</h2>
            <div class="input-group">
                <input type="text" id="username" name="username" placeholder=" " value="{{ old('username') }}" required>
                <label for="username">Tài khoản</label>
                @error('username')
                    <span style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" placeholder=" " required>
                <label for="password">Mật khẩu</label>
                
            </div>

            <button type="submit">Đăng nhập</button>
            <div class="forgot-password">
                <a href="#">Quên mật khẩu?</a>
            </div>
            <div class="register">
                <a href="{{ route('register') }}">Đăng ký</a>
            </div>
        </form>
    </div>
    
    </body>


   
</html>