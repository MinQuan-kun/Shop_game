<x-admin-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Thêm Quản Trị Viên (Admin)
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li><a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('admin.users.index') }}">Users /</a></li>
                <li class="font-medium text-black dark:text-white">Create Admin</li>
            </ol>
        </nav>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="font-semibold text-black dark:text-white">
                Thông tin quản trị viên
            </h3>
        </div>
        
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6">
            @csrf

            {{-- Tên --}}
            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-black dark:text-white">
                    Tên hiển thị <span class="text-error-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-lg border border-gray-300 bg-transparent px-5 py-3 text-black outline-none transition focus:border-primary-500 active:border-primary-500 dark:border-gray-700 dark:text-white"
                    placeholder="Nhập tên quản trị viên" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-black dark:text-white">
                    Email đăng nhập <span class="text-error-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-lg border border-gray-300 bg-transparent px-5 py-3 text-black outline-none transition focus:border-primary-500 active:border-primary-500 dark:border-gray-700 dark:text-white"
                    placeholder="Nhập email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-black dark:text-white">
                    Mật khẩu <span class="text-error-500">*</span>
                </label>
                <input type="password" name="password" required
                    class="w-full rounded-lg border border-gray-300 bg-transparent px-5 py-3 text-black outline-none transition focus:border-primary-500 active:border-primary-500 dark:border-gray-700 dark:text-white"
                    placeholder="Nhập mật khẩu" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label class="mb-2.5 block font-medium text-black dark:text-white">
                    Xác nhận mật khẩu <span class="text-error-500">*</span>
                </label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-lg border border-gray-300 bg-transparent px-5 py-3 text-black outline-none transition focus:border-primary-500 active:border-primary-500 dark:border-gray-700 dark:text-white"
                    placeholder="Nhập lại mật khẩu" />
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4">
                <button type="submit"
                    class="flex w-full justify-center rounded-lg border border-success-300 bg-white p-3 font-medium text-success-700 hover:bg-success-50 dark:border-success-700 dark:bg-gray-800 dark:text-white dark:hover:bg-white/10">
                    Tạo tài khoản Admin
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="flex w-full justify-center rounded-lg border border-gray-300 bg-white p-3 font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-white/10">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>