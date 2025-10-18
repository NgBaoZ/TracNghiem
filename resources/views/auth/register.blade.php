<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="register-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h2>Đăng ký</h2>

            <div class="input-group">
                <input type="text" id="name" name="name" placeholder=" " value="{{ old('name') }}" required>
                <label for="name">Họ và tên</label>
                @error('name')
                    <span style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <input type="text" id="username" name="username" placeholder=" " value="{{ old('username') }}" required>
                <label for="username">Tên tài khoản</label>
                @error('username')
                    <span style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <input type="email" id="email" name="email" placeholder=" " value="{{ old('email') }}" required>
                <label for="email">Email</label>
                @error('email')
                    <span style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" placeholder=" " required>
                <label for="password">Mật khẩu</label>
                @error('password')
                    <span style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder=" " required>
                <label for="password_confirmation">Xác nhận lại mật khẩu</label>
            </div>

            <button type="submit">Đăng ký</button>

            <div class="login-link">
                <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập</a>
            </div>
        </form>
    </div>
</body>
</html>