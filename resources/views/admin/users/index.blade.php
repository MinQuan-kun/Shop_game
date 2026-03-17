<x-app-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Quản lý người dùng
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li><a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li class="font-medium text-black dark:text-white">Users</li>
            </ol>
        </nav>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-6 flex justify-between items-center border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-xl font-bold text-black dark:text-white">
                Danh sách tài khoản
            </h3>
            <span
                class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-md dark:bg-gray-700 text-black dark:text-white">
                Tổng: {{ $users->total() }} users
            </span>
        </div>

        <div class="p-6">
            <div class="max-w-full overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        User
                                    </p>
                                </div>
                            </th>

                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        Vai trò
                                    </p>
                                </div>
                            </th>

                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        Trạng thái
                                    </p>
                                </div>
                            </th>
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        Ngày tham gia
                                    </p>
                                </div>
                            </th>

                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                        Thao tác
                                    </p>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    @foreach ($users as $user)
                        <tr>
                            {{-- User Info --}}
                            <td class="px-6 py-4 pl-9 xl:pl-11">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="relative h-12 w-12 rounded-full overflow-hidden border-2 border-white shadow-sm dark:border-gray-700">
                                        @if ($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                                class="h-full w-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF"
                                                alt="User" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-black dark:text-white">{{ $user->name }}
                                        </h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Vai trò --}}
                            <td class="px-6 py-4">
                                @if (isset($user->role) && $user->role === 'admin')
                                    <span
                                        class="inline-flex items-center justify-center gap-1 rounded-full bg-error-500 px-2.5 py-0.5 text-sm font-medium text-white">
                                        Admin
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center justify-center gap-1 rounded-full bg-blue-light-500 px-2.5 py-0.5 text-sm font-medium text-white">
                                        Member
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if (isset($user->is_active) && !$user->is_active)
                                    <span
                                        class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-400">
                                        Locked
                                    </span>
                                @else
                                    <span
                                        class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                        Active
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </p>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-start space-x-3">

                                    {{-- Nút Toggle Status (Khóa/Mở khóa) --}}
                                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        @if (isset($user->is_active) && !$user->is_active)
                                            <button type="submit" title="Mở khóa tài khoản"
                                                class="group flex items-center justify-center p-2 rounded-full transition-all duration-200 ease-in-out text-success-700 hover:bg-success-50 dark:text-success-500 dark:hover:bg-success-500/10">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="submit" title="Khóa tài khoản"
                                                class="group flex items-center justify-center p-2 rounded-full transition-all duration-200 ease-in-out text-warning-700 hover:bg-warning-50 dark:text-warning-400 dark:hover:bg-warning-500/15">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </form>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Hành động này không thể hoàn tác. Bạn chắc chắn muốn xóa user này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Xóa tài khoản"
                                            class="group flex items-center justify-center p-2 rounded-full transition-all duration-200 ease-in-out text-error-700 hover:bg-error-50 dark:text-error-500 dark:hover:bg-error-500/10">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
