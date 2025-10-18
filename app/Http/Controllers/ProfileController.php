<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa thông tin cá nhân.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Cập nhật thông tin người dùng.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = Auth::user();

        // === PHẦN NÀY ĐÃ ĐƯỢC THAY ĐỔI HOÀN TOÀN ===
        if ($request->hasFile('avatar')) {
            // 1. Tạo tên file duy nhất
            $filename = $user->username . '-' . time() . '.' . $request->avatar->extension();

            // 2. Di chuyển file trực tiếp vào thư mục public/avatar
            $request->avatar->move(public_path('avatar'), $filename);

            // 3. Cập nhật đường dẫn trong database
            $user->avatar = 'avatar/' . $filename;
        }
        // ===========================================

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Cập nhật thông tin thành công!');
    }
}