<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Danh sách tài khoản` }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName">Basic Tables</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                href="/dashboard">
                                Home
                                <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke=""
                                        stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName">Basic Tables</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Breadcrumb End -->


        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName"></h2>

            <div class="flex items-center gap-3">
                <!-- Nút Thêm -->
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>

                    <span>𝓣𝓱𝓮̂𝓶</span>
                </a>

                <!-- Nút Lọc -->
                <button
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20"
                        viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path
                            d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z"
                            fill="" stroke="" stroke-width="1.5"></path>
                        <path
                            d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z"
                            fill="" stroke="" stroke-width="1.5"></path>
                    </svg>
                    𝓛𝓸̣𝓬
                </button>

            </div>
        </div>

        <!-- Bảng danh sách người dùng -->
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-sm font-medium text-gray-500">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Modify</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- User -->
                            <td class="flex items-center gap-3 px-6 py-4">
                                <img src="{{ $user->avatar ?? asset('tailadmin/src/images/user/default_user.jpg') }}"
                                    alt="avatar" class="h-10 w-10 rounded-full object-cover">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4">
                                @php
                                    // Đảm bảo vai trò luôn là chữ thường để so sánh
                                    $role = strtolower($user->role ?? 'user');

                                    // Định nghĩa các lớp CSS dựa trên vai trò sử dụng các mẫu màu bạn cung cấp
                                    $roleClasses = match ($role) {
                                        'admin'
                                            => 'rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500',
                                        'user'
                                            => 'rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500',
                                    };
                                @endphp

                                <span class="{{ $roleClasses }}">
                                    {{ ucfirst($role) }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @php
                                    $status = strtolower($user->status ?? 'active');
                                    $classes = match ($status) {
                                        'active'
                                            => 'rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500',
                                        'pending'
                                            => 'rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-600 dark:bg-warning-500/15 dark:text-orange-400',
                                        'cancel'
                                            => 'rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500',
                                    };
                                @endphp
                                <span class="{{ $classes }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <!-- Modify -->

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('admin.users.create', $user->id) }}"
                                        class="flex flex-row items-center gap-2 border border-[1px]">
                                        <i class="far fa-edit text-warning-500"></i>
                                    </a>

                                    <form action="{{ route('admin.users.create', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('admin.users.create', $user->id) }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="flex flex-row items-center gap-2 border border-[1px]">
                                            <i class="fas fa-trash-alt text-error-500"></i>
                                        </a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="flex justify-between items-center mt-4 text-sm text-gray-600">
            <div>
                Hiển thị
                <span class="font-medium">{{ $users->firstItem() }}</span> -
                <span class="font-medium">{{ $users->lastItem() }}</span>
                trong tổng số
                <span class="font-medium">{{ $users->total() }}</span>
                người dùng
            </div>

            <div class="flex gap-2">
                @if ($users->onFirstPage())
                    <button disabled
                        class="px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">Previous</button>
                @else
                    <a href="{{ $users->previousPageUrl() }}"
                        class="px-3 py-1 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-700">Previous</a>
                @endif

                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}"
                        class="px-3 py-1 rounded-md bg-blue-500 text-white hover:bg-blue-600">Next</a>
                @else
                    <button disabled
                        class="px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">Next</button>
                @endif
            </div>
        </div>

</x-app-layout>
