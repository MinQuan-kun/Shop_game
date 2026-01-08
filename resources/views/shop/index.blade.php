<x-shop-layout>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Tiêu đề trang --}}
            <div class="text-center mb-10">
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2 tracking-tight">
                    Cửa Hàng Trò Chơi
                </h1>
                <p class="text-gray-500 dark:text-gray-400">Khám phá hàng ngàn tựa game hấp dẫn</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- CỘT TRÁI: DANH SÁCH GAME (Chiếm 3 phần) --}}
                <div class="lg:col-span-3 order-2 lg:order-1">

                    {{-- Thanh công cụ (Search + Sort Mobile) --}}
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-300 font-medium">
                            Hiển thị {{ $games->firstItem() ?? 0 }} - {{ $games->lastItem() ?? 0 }} của
                            {{ $games->total() }} kết quả
                        </span>

                        {{-- Form Tìm kiếm (Cho Mobile & Desktop) --}}
                        <form action="{{ route('shop.index') }}" method="GET" class="w-full sm:w-auto relative">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Tìm game..."
                                class="w-full sm:w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-miku-500 focus:border-transparent transition">
                            <i
                                class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </form>
                    </div>

                    {{-- Grid Game --}}
                    @if ($games->count() > 0)
                        {{-- Grid hiển thị Game --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach ($games as $game)
                                <div
                                    class="group relative bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 border border-gray-100 dark:border-gray-700 transition-all duration-300 flex flex-col h-full">

                                    {{-- [LOGIC] Tính toán giá ảo ngẫu nhiên --}}
                                    @php
                                        $hasDiscount = $game->price > 0;
                                        // Random giảm từ 10-30%
                                        $discountPercent = $hasDiscount ? rand(10, 30) : 0;
                                        // Giá gốc giả định
                                        $fakeOriginalPrice = $game->price * (1 + $discountPercent / 100);
                                    @endphp

                                    {{-- 1. PHẦN ẢNH GAME --}}
                                    <div class="relative h-48 overflow-hidden bg-gray-200 dark:bg-gray-700">
                                        <a href="{{ route('game.show', $game->id) }}" class="block w-full h-full">
                                            <img src="{{ str_starts_with($game->image, 'http') ? $game->image : asset('storage/' . $game->image) }}"
                                                alt="{{ $game->name }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out"
                                                loading="lazy">
                                        </a>

                                        {{-- Badge Giảm giá / Miễn phí (Góc phải trên) --}}
                                        <div
                                            class="absolute top-3 right-3 flex flex-col items-end gap-1 pointer-events-none">
                                            @if ($game->price == 0)
                                                <span
                                                    class="bg-green-500/90 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm animate-pulse">
                                                    Miễn phí
                                                </span>
                                            @else
                                                <span
                                                    class="bg-red-500/90 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-lg shadow-sm animate-pulse">
                                                    -{{ $discountPercent }}%
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- 2. PHẦN NỘI DUNG --}}
                                    <div class="p-4 flex flex-col flex-grow">

                                        {{-- Thể loại --}}
                                        <div
                                            class="mb-2 text-[11px] font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                                            @if (!empty($game->platforms))
                                                <span
                                                    class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-gray-500 dark:text-gray-300">
                                                    {{ $game->platforms[0] ?? 'PC' }}
                                                </span>
                                            @endif
                                            <span>{{ optional($game->category)->name ?? 'Game' }}</span>
                                        </div>

                                        {{-- Tên Game --}}
                                        <h3
                                            class="text-base font-bold text-gray-900 dark:text-white leading-tight mb-2 line-clamp-2 group-hover:text-miku-500 transition-colors">
                                            <a href="{{ route('game.show', $game->id) }}">
                                                {{ $game->name }}
                                            </a>
                                        </h3>

                                        {{-- 3. CHÂN CARD (Giá & Nút mua) --}}
                                        <div
                                            class="mt-auto pt-3 border-t border-gray-100 dark:border-gray-700 flex items-end justify-between">

                                            {{-- Giá tiền --}}
                                            <div class="flex flex-col">
                                                @if ($game->price == 0)
                                                    <span class="text-lg font-black text-green-500">Free</span>
                                                @else
                                                    {{-- Giá gốc (gạch ngang) --}}
                                                    <span class="text-[11px] text-gray-400 line-through font-medium">
                                                        {{ number_format($fakeOriginalPrice, 0, ',', '.') }}đ
                                                    </span>
                                                    {{-- Giá bán --}}
                                                    <span
                                                        class="text-lg font-black text-miku-600 dark:text-miku-400 leading-none">
                                                        {{ number_format($game->price, 0, ',', '.') }}<span
                                                            class="text-xs align-top">đ</span>
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Nút Thêm vào giỏ (AJAX Form) --}}
                                            @auth
                                                <form action="{{ route('cart.add') }}" method="POST"
                                                    class="ajax-cart-form">
                                                    @csrf
                                                    <input type="hidden" name="game_id" value="{{ $game->id }}">

                                                    <button type="submit"
                                                        class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-miku-500 hover:text-white dark:hover:bg-miku-500 dark:hover:text-white transition-all shadow-sm hover:shadow-lg group/btn"
                                                        title="Thêm vào giỏ">
                                                        <i
                                                            class="fa-solid fa-cart-plus text-sm group-active/btn:scale-90 transition-transform"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-500 hover:bg-miku-500 hover:text-white transition-all shadow-sm"
                                                    title="Đăng nhập để mua">
                                                    <i class="fa-solid fa-right-to-bracket"></i>
                                                </a>
                                            @endauth

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Phân trang --}}
                        <div class="mt-10">
                            {{ $games->links() }}
                        </div>
                    @else
                        {{-- Hiển thị khi không có game --}}
                        <div
                            class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                            <i class="fa-solid fa-ghost text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <p class="text-xl font-bold text-gray-500 dark:text-gray-400">Không tìm thấy game nào phù
                                hợp</p>
                            <a href="{{ route('shop.index') }}"
                                class="inline-block mt-4 text-miku-500 hover:underline font-semibold">Xóa bộ lọc</a>
                        </div>
                    @endif
                </div>

                {{-- CỘT PHẢI: SIDEBAR (Chiếm 1 phần) --}}
                <aside class="lg:col-span-1 order-1 lg:order-2 space-y-6">

                    {{-- Bộ lọc Danh mục --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 sticky top-24">
                        <div class="flex items-center gap-2 mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                            <i class="fa-solid fa-filter text-miku-500"></i>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Thể loại</h3>
                        </div>

                        <div class="space-y-2">
                            {{-- Nút "Tất cả" --}}
                            <a href="{{ route('shop.index') }}"
                                class="flex items-center justify-between p-3 rounded-xl transition group {{ !request('category') ? 'bg-miku-50 dark:bg-miku-900/20 text-miku-600 dark:text-miku-400 font-bold' : 'hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300' }}">
                                <span>Tất cả</span>
                                <i
                                    class="fa-solid fa-chevron-right text-xs {{ !request('category') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></i>
                            </a>

                            {{-- Danh sách Categories --}}
                            @foreach ($categories as $cat)
                                <a href="{{ route('shop.index', array_merge(request()->query(), ['category' => $cat->id, 'page' => 1])) }}"
                                    class="flex items-center justify-between p-3 rounded-xl transition group {{ request('category') == $cat->id ? 'bg-miku-50 dark:bg-miku-900/20 text-miku-600 dark:text-miku-400 font-bold' : 'hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300' }}">
                                    <span>{{ $cat->name }}</span>
                                    @if (request('category') == $cat->id)
                                        <i class="fa-solid fa-check text-xs"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </div>
</x-shop-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.ajax-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = form.querySelector('button');
                const oldHtml = btn.innerHTML;
                
                // Loading effect
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                btn.disabled = true;

                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // Gọi Popup thông báo
                    window.dispatchEvent(new CustomEvent('notify', { 
                        detail: { message: data.message, type: data.status } 
                    }));
                    
                    // Success effect
                    if(data.status === 'success') {
                        btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                        btn.classList.add('bg-green-500', 'text-white');
                    } else {
                        btn.innerHTML = oldHtml;
                    }
                })
                .catch(err => {
                    console.error(err);
                    btn.innerHTML = oldHtml;
                })
                .finally(() => {
                    setTimeout(() => {
                        btn.disabled = false;
                        if(btn.innerHTML.includes('fa-check')) {
                            btn.innerHTML = oldHtml;
                            btn.classList.remove('bg-green-500', 'text-white');
                        }
                    }, 2000);
                });
            });
        });
    });
</script>