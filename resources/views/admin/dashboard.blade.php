
<x-admin-layout>
    <div class="mb-6">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Dashboard
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tổng quan hệ thống</p>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5 mb-6">
        {{-- Total Users --}}
        <div
            class="rounded-2xl border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        {{ \App\Models\User::count() }}
                    </h4>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Người dùng</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Games --}}
        <div
            class="rounded-2xl border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        {{ \App\Models\Game::count() }}
                    </h4>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Tổng games</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div
            class="rounded-2xl border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        {{ \App\Models\Order::count() }}
                    </h4>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Đơn hàng</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div
            class="rounded-2xl border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        {{ number_format((float) (string) \App\Models\Order::sum('total_amount'), 0, ',', '.') }}đ </h4>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Doanh thu</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="rounded-2xl border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="px-6 py-6 border-b border-stroke dark:border-strokedark">
            <h3 class="text-xl font-bold text-black dark:text-white">
                Đơn hàng gần đây
            </h3>
        </div>

        <div class="p-6">
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <th class="px-4 py-4 font-medium text-black dark:text-white">Mã đơn</th>
                            <th class="px-4 py-4 font-medium text-black dark:text-white">Khách hàng</th>
                            <th class="px-4 py-4 font-medium text-black dark:text-white">Tổng tiền</th>
                            <th class="px-4 py-4 font-medium text-black dark:text-white">Trạng thái</th>
                            <th class="px-4 py-4 font-medium text-black dark:text-white">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Order::with('user')->latest()->take(10)->get() as $order)
                            <tr class="border-b border-stroke dark:border-strokedark">
                                <td class="px-4 py-4">
                                    <p class="text-black dark:text-white font-medium">{{ $order->order_number }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-black dark:text-white">{{ $order->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->email ?? '' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-black dark:text-white font-medium">
                                        {{ number_format($order->total_amount, 0, ',', '.') }}đ
                                    </p>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($order->status === 'completed')
                                        <span
                                            class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-success-800 dark:bg-success-900 dark:text-success-200">
                                            Hoàn thành
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-warning bg-opacity-10 px-3 py-1 text-sm font-medium text-warning">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-black dark:text-white">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    Chưa có đơn hàng nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3 md:gap-6">
        <a href="{{ route('admin.games.create') }}"
            class="rounded-2xl border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-primary bg-opacity-10">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-black dark:text-white">Thêm Game Mới</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Thêm game vào cửa hàng</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="rounded-2xl border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-primary bg-opacity-10">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-black dark:text-white">Quản lý Users</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Xem danh sách người dùng</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.games.index') }}"
            class="rounded-2xl border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-primary bg-opacity-10">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-black dark:text-white">Quản lý Games</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Xem tất cả games</p>
                </div>
            </div>
        </a>
    </div>
</x-admin-layout>
