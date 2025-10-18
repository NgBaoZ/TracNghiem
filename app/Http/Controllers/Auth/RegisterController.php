<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Hiển thị form đăng ký
    public function create()
    {
        return view('auth.register'); // Trả về view bạn đã tạo
    }

    // Xử lý dữ liệu từ form
    public function register(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'], // 'confirmed' yêu cầu phải có input password_confirmation
        ]);

        // 2. Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Băm mật khẩu
        ]);

        // 3. Tự động đăng nhập cho người dùng vừa đăng ký
        Auth::login($user);

        return redirect()->route('index');
    }
}