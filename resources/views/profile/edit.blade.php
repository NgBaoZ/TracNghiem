<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Thông Tin</title>
    <script src="https://cdn.tailwindcss.com"></script>
   <style>
        .custom-gradient {
            background: linear-gradient(135deg, #072f68 0%, #4f9cab 100%);
        }
    </style>
</head>
<body class="custom-gradient">
    <main class="py-10">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Thông Tin Cá Nhân</h1>

            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH') 
                <div class="space-y-6">
                    <div class="text-center">
                        <img class="mx-auto h-24 w-24 rounded-full object-cover border-2 border-gray-300" 
                             src="{{ $user->avatar ? asset($user->avatar) : asset('img/test.jpg') }}" 
                             alt="Avatar hiện tại">
                        <label for="avatar" class="mt-2 text-sm font-medium text-gray-700 block">Thay đổi Avatar</label>
                        <input id="avatar" name="avatar" type="file" class="mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('avatar') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Tên tài khoản</label>
                        <input id="username" type="text" value="{{ $user->username }}" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" type="email" value="{{ $user->email }}" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Họ và Tên</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <hr>

                    <p class="font-bold">Thay đổi mật khẩu</p>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                        <input id="password" name="password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-x-4">
                    <a href="{{ route('index') }}" class="text-sm font-semibold leading-6 text-gray-900">
                        Quay lại trang chủ
                    </a>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 transition">
                        Lưu Thay Đổi
                    </button>
                </div>
                </form>
        </div>
    </main>
</body>
</html>