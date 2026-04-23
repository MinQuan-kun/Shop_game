<x-admin-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Quản lý Giao Dịch
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('admin.dashboard') }}">
                        Dashboard /
                    </a>
                </li>
                <li class="font-medium text-black dark:text-white">Giao dịch</li>
            </ol>
        </nav>
    </div>

    {{-- Order List Card --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-6 flex justify-between items-center border-b border-gray-200 dark:border-gray-800">
            <div>
                <h3 class="text-xl font-bold text-black dark:text-white">
                    Tất cả giao dịch
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Danh sách tất cả giao dịch trong hệ thống
                </p>
            </div>
            <span
                class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                Tổng: {{ $orders->total() }} giao dịch
            </span>
        </div>

        <div class="p-6">
            <div class="max-w-full overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-white/5">
                            <th class="px-5 py-3 sm:px-6">
                                <p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Mã Đơn
                                </p>
                            </th>
                            <th class="px-5 py-3 sm:px-6">
                                <p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Khách Hàng
                                </p>
                            </th>
                            <th class="px-5 py-3 sm:px-6 text-right">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Tổng Tiền
                                </p>
                            </th>
                            <th class="px-5 py-3 sm:px-6 text-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Trạng Thái
                                </p>
                            </th>
                            <th class="px-5 py-3 sm:px-6 text-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Phương Thức
                                </p>
                            </th>
                            <th class="px-5 py-3 sm:px-6 text-right">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Ngày Tạo
                                </p>
                            </th>
                            <th class="px-5 py-3 sm:px-6 text-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Chi Tiết
                                </p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                        #{{ $order->order_number }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-black dark:text-white">
                                            {{ $order->user->name ?? 'N/A' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $order->user->email ?? '' }}
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <p class="font-bold text-black dark:text-white">
                                        {{ number_format((float) (is_object($order->total_amount) ? $order->total_amount->__toString() : $order->total_amount), 0, ',', '.') }}
                                        đ
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if ($order->status === 'completed')
                                        <span
                                            class="inline-flex items-center justify-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <i class="fa-solid fa-circle-check"></i>
                                            Hoàn thành
                                        </span>
                                    @elseif ($order->status === 'pending')
                                        <span
                                            class="inline-flex items-center justify-center gap-1 rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            <i class="fa-solid fa-clock"></i>
                                            Đang xử lý
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center justify-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if ($order->payment_method === 'wallet')
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-600 dark:text-gray-400">
                                            <i class="fa-solid fa-wallet"></i>
                                            Ví
                                        </span>
                                    @elseif ($order->payment_method === 'paypal')
                                        <span class="inline-flex items-center gap-1 text-xs text-blue-600 dark:text-blue-400">
                                            <i class="fab fa-paypal"></i>
                                            PayPal
                                        </span>
                                    @elseif ($order->payment_method === 'momo')
                                        <span class="inline-flex items-center gap-1 text-xs text-pink-600 dark:text-pink-400">
                                            <i class="fa-solid fa-mobile"></i>
                                            MoMo
                                        </span>
                                    @else
                                        <span
                                            class="text-xs text-gray-500">{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ $order->created_at->format('H:i') }}
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order->_id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:hover:bg-indigo-900/50 text-xs font-medium transition">
                                        <i class="fa-solid fa-eye"></i>
                                        Xem
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-inbox text-4xl text-gray-300 dark:text-gray-600"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Chưa có giao dịch nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>