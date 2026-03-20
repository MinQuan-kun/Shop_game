<x-shop-layout>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300 py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8">
                <i class="fa-solid fa-cash-register text-miku-500 mr-2"></i>
                Thanh toán
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Order Items --}}
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Các sản phẩm</h2>

                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div
                                    class="flex gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                                    <img src="{{ Str::startsWith($item->game->image, 'http') ? $item->game->image : asset('storage/' . $item->game->image) }}"
                                        alt="{{ $item->game->name }}" class="w-20 h-20 rounded-lg object-cover">

                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $item->game->name }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->game->publisher }}</p>
                                        <p class="text-brand-600 dark:text-brand-400 font-bold mt-1">
                                            {{ number_format($item->price_at_time, 0, ',', '.') }} VNĐ
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Wallet Balance --}}
                    <div class="bg-gradient-to-br from-miku-500 to-brand-600 rounded-xl p-6 shadow-lg text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white/80 text-sm font-medium uppercase">Số dư ví hiện tại</p>
                                <p class="text-3xl font-bold mt-1">
                                    {{ number_format($user->balance, 0, ',', '.') }} VNĐ
                                </p>
                            </div>
                            <i class="fa-solid fa-wallet text-white/30 text-5xl"></i>
                        </div>

                        @if($user->balance < $total)
                            <div class="mt-4 bg-red-500/20 border border-red-400 rounded-lg p-3">
                                <p class="text-sm font-medium">
                                    <i class="fa-solid fa-exclamation-triangle mr-1"></i>
                                    Số dư không đủ! Thiếu: {{ number_format($total - $user->balance, 0, ',', '.') }} VNĐ
                                </p>
                                <a href="{{ route('wallet.deposit') }}"
                                    class="text-sm underline hover:no-underline mt-1 inline-block">
                                    Nạp thêm tiền →
                                </a>
                            </div>
                        @else
                            <div class="mt-4 bg-green-500/20 border border-green-400 rounded-lg p-3">
                                <p class="text-sm font-medium">
                                    <i class="fa-solid fa-check-circle mr-1"></i>
                                    Số dư đủ để thanh toán
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Payment Summary --}}
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 sticky top-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Thanh toán</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Tổng tiền:</span>
                                <span class="font-bold">{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                            </div>
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Phương thức:</span>
                                <span class="font-semibold text-miku-500">Ví điện tử</span>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Tổng thanh toán:</span>
                                <span class="text-2xl font-bold text-brand-600">
                                    {{ number_format($total, 0, ',', '.') }} VNĐ
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <button type="submit" @if($user->balance < $total) disabled @endif
                                class="w-full bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed mb-3">
                                <i class="fa-solid fa-check-circle mr-2"></i>
                                Xác nhận thanh toán
                            </button>
                        </form>

                        <a href="{{ route('cart.index') }}"
                            class="block text-center text-gray-600 dark:text-gray-400 hover:text-miku-500 dark:hover:text-miku-400 font-medium">
                            <i class="fa-solid fa-arrow-left mr-1"></i>Quay lại giỏ hàng
                        </a>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                                <i class="fa-solid fa-shield-alt mr-1"></i>
                                Giao dịch được bảo mật và mã hóa
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-shop-layout>