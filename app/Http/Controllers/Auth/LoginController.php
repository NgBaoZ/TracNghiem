<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function create()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Thử đăng nhập
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Tạo lại session để bảo mật

            return redirect()->intended('index'); // Chuyển hướng đến trang dashboard hoặc trang trước đó
        }

        // 3. Nếu đăng nhập thất bại
        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('username');
    }

    // Xử lý đăng xuất
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}