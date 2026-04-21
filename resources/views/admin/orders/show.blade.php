<x-admin-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Chi Tiết Giao Dịch
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('admin.dashboard') }}">
                        Dashboard /
                    </a>
                </li>
                <li>
                    <a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('admin.orders.index') }}">
                        Giao dịch /
                    </a>
                </li>
                <li class="font-medium text-black dark:text-white">{{ $order->order_number }}</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Order Information --}}
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="text-xl font-bold text-black dark:text-white">
                        Thông tin đơn hàng
                    </h3>
                </div>

                <div class="p-6">
                    {{-- Order Items --}}
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4 p-4 rounded-lg bg-gray-50 dark:bg-white/5">
                                @if ($item->game && $item->game->image)
                                    <img src="{{ $item->game->image }}" alt="{{ $item->game->name }}"
                                        class="h-16 w-16 rounded-lg object-cover border border-gray-200 dark:border-gray-700">
                                @else
                                    <div
                                        class="h-16 w-16 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <i class="fa-solid fa-gamepad text-gray-400 text-xl"></i>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h4 class="font-semibold text-black dark:text-white">
                                        {{ $item->game->name ?? 'Game không tồn tại' }}
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Số lượng: {{ $item->quantity }}
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="font-bold text-black dark:text-white">
                                        {{ number_format((float) (is_object($item->price) ? $item->price->__toString() : $item->price), 0, ',', '.') }}
                                        đ
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total --}}
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Tổng cộng:</span>
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                {{ number_format((float) (is_object($order->total_amount) ? $order->total_amount->__toString() : $order->total_amount), 0, ',', '.') }}
                                đ
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Details Sidebar --}}
        <div class="lg:col-span-1">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="text-xl font-bold text-black dark:text-white">
                        Chi tiết
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Order Number --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-medium mb-1">Mã đơn</p>
                        <p class="font-semibold text-indigo-600 dark:text-indigo-400">#{{ $order->order_number }}</p>
                    </div>

                    {{-- Customer --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-medium mb-1">Khách hàng</p>
                        <p class="font-semibold text-black dark:text-white">{{ $order->user->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->user->email ?? '' }}</p>
                    </div>

                    {{-- Status --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-medium mb-1">Trạng thái</p>
                        @if ($order->status === 'completed')
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                <i class="fa-solid fa-circle-check"></i>
                                Hoàn thành
                            </span>
                        @elseif ($order->status === 'pending')
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                <i class="fa-solid fa-clock"></i>
                                Đang xử lý
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-medium mb-1">Phương thức thanh
                            toán</p>
                        @if ($order->payment_method === 'wallet')
                            <p class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <i class="fa-solid fa-wallet"></i>
                                Ví điện tử
                            </p>
                        @elseif ($order->payment_method === 'paypal')
                            <p class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400">
                                <i class="fab fa-paypal"></i>
                                PayPal
                            </p>
                        @elseif ($order->payment_method === 'momo')
                            <p class="flex items-center gap-2 text-sm text-pink-600 dark:text-pink-400">
                                <i class="fa-solid fa-mobile"></i>
                                MoMo
                            </p>
                        @else
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                        @endif
                    </div>

                    {{-- Created Date --}}
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-medium mb-1">Ngày tạo</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $order->created_at->format('d/m/Y H:i:s') }}
                        </p>
                    </div>

                    {{-- Updated Date --}}
                    @if ($order->updated_at && $order->updated_at != $order->created_at)
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-medium mb-1">Cập nhật lần cuối
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $order->updated_at->format('d/m/Y H:i:s') }}
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Back Button --}}
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.orders.index') }}"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>