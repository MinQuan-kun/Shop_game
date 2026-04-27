<x-shop-layout>
    @php
    $wishlistGameIds = auth()->check()
    ? \App\Models\Wishlist::where('user_id', auth()->id())->pluck('game_id')->toArray()
    : [];
    @endphp
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

                                {{-- Thể loại & Nền tảng (Tags) --}}
                                <div class="mb-3 flex flex-wrap gap-1.5">
                                    {{-- Platform Tags --}}
                                    @if (!empty($game->platforms))
                                        @foreach ($game->platforms as $platform)
                                        <span class="text-[10px] font-bold bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-2 py-1 rounded-md">
                                            {{ $platform }}
                                        </span>
                                        @endforeach
                                    @endif
                                    
                                    {{-- Category Tags --}}
                                    @if (!empty($game->category_ids))
                                        @php
                                            $gameCats = \App\Models\Category::whereIn('_id', $game->category_ids)->get();
                                        @endphp
                                        @foreach ($gameCats as $cat)
                                        <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 px-2 py-1 rounded-md">
                                            {{ $cat->name }}
                                        </span>
                                        @endforeach
                                    @endif
                                </div>

                                {{-- Tên Game --}}
                                <h3
                                    class="text-base font-bold text-gray-900 dark:text-white leading-tight mb-2 line-clamp-2 group-hover:text-miku-500 transition-colors">
                                    <a href="{{ route('game.show', $game->id) }}">
                                        {{ $game->name }}
                                    </a>
                                </h3>

                                {{-- 3. CHÂN CARD (Giá & Nút mua) --}}
                                <div class="mt-auto pt-3 border-t border-gray-100 dark:border-gray-700 flex items-end justify-between">

                                    {{-- Giá tiền --}}
                                    <div class="flex flex-col">
                                        @if ($game->price == 0)
                                        <span class="text-lg font-black text-green-500">Free</span>
                                        @else
                                        {{-- Giá gốc --}}
                                        <span class="text-[11px] text-gray-400 line-through font-medium">
                                            {{ number_format($fakeOriginalPrice, 0, ',', '.') }}đ
                                        </span>
                                        {{-- Giá bán --}}
                                        <span class="text-lg font-black text-miku-600 dark:text-miku-400 leading-none">
                                            {{ number_format($game->price, 0, ',', '.') }}<span class="text-xs align-top">đ</span>
                                        </span>
                                        @endif
                                    </div>

                                    {{-- KHU VỰC CÁC NÚT (WISHLIST + CART) --}}
                                    <div class="flex items-center gap-2">
                                        {{-- [MỚI] Nút Wishlist (Trái tim) --}}
                                        @auth
                                        {{-- TRƯỜNG HỢP 1: ĐÃ ĐĂNG NHẬP (Dùng AJAX) --}}
                                        @php $inWishlist = in_array($game->id, $wishlistGameIds); @endphp
                                        <button type="button"
                                            data-game-id="{{ $game->id }}"
                                            class="wishlist-btn w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700 transition-all shadow-sm hover:shadow-lg hover:bg-red-50 dark:hover:bg-red-900/30 group/wishlist {{ $inWishlist ? 'text-red-500' : 'text-gray-400 dark:text-gray-500' }}"
                                            title="{{ $inWishlist ? 'Bỏ yêu thích' : 'Thêm yêu thích' }}">
                                            <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm group-hover/wishlist:text-red-500 transition-transform active:scale-90"></i>
                                        </button>
                                        @else
                                        {{-- TRƯỜNG HỢP 2: CHƯA ĐĂNG NHẬP (Chuyển trang Login) --}}
                                        <a href="{{ route('login') }}"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 hover:bg-red-50 hover:text-red-500 transition-all shadow-sm group/wishlist"
                                            title="Đăng nhập để yêu thích">
                                            <i class="fa-regular fa-heart text-sm group-hover/wishlist:text-red-500"></i>
                                        </a>
                                        @endauth

                                        {{-- Nút Thêm vào giỏ (Giữ nguyên) --}}
                                        @auth
                                        <form action="{{ route('cart.add') }}" method="POST" class="ajax-cart-form">
                                            @csrf
                                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                                            <button type="submit"
                                                class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-miku-500 hover:text-white dark:hover:bg-miku-500 dark:hover:text-white transition-all shadow-sm hover:shadow-lg group/btn"
                                                title="Thêm vào giỏ">
                                                <i class="fa-solid fa-cart-plus text-sm group-active/btn:scale-90 transition-transform"></i>
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

                {{-- CỘT PHẢI: SIDEBAR FILTER (STEAM STYLE) --}}
                <aside class="lg:col-span-1 order-1 lg:order-2">

                    <div class="space-y-0">
                        {{-- FILTER: Thể loại --}}
                        <div class="overflow-hidden first:rounded-t-xl last:rounded-b-xl">
                            <button type="button" class="filter-toggle w-full px-6 py-4 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white font-semibold flex items-center justify-between transition"
                                data-target="categories-list">
                                <span>
                                    Thể loại
                                </span>
                                <i class="fa-solid fa-chevron-down transition-transform duration-300 text-gray-500"></i>
                            </button>
                            <div id="categories-list" class="filter-content space-y-0 max-h-96 overflow-y-auto hidden">
                                @foreach ($categories as $cat)
                                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 px-6 py-3 border-b border-white/20 dark:border-white/10 last:border-0 transition group">
                                    <input type="checkbox" name="category" value="{{ $cat->id }}"
                                        {{ request('category') == $cat->id ? 'checked' : '' }}
                                        class="category-filter w-4 h-4 rounded border-gray-300 dark:border-gray-600 cursor-pointer accent-blue-500">
                                    <span class="flex-1 text-sm text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                        {{ $cat->name }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                        {{ $categoryCounts[$cat->id] ?? 0 }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- FILTER: Nền tảng (Platform) --}}
                        @if (isset($allPlatforms) && $allPlatforms->count() > 0)
                        <div class="overflow-hidden last:rounded-b-xl">
                            <button type="button" class="filter-toggle w-full px-6 py-4 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white font-semibold flex items-center justify-between transition"
                                data-target="platforms-list">
                                <span>
                                    Nền tảng
                                </span>
                                <i class="fa-solid fa-chevron-down transition-transform duration-300 text-gray-500"></i>
                            </button>
                            <div id="platforms-list" class="filter-content space-y-0 max-h-64 overflow-y-auto hidden">
                                @foreach ($allPlatforms as $platform)
                                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 px-6 py-3 border-b border-white/20 dark:border-white/10 last:border-0 transition group">
                                    <input type="checkbox" name="platform" value="{{ $platform }}"
                                        {{ request('platform') === $platform ? 'checked' : '' }}
                                        class="platform-filter w-4 h-4 rounded border-gray-300 dark:border-gray-600 cursor-pointer accent-cyan-500 flex-shrink-0">
                                    <span class="flex-1 text-sm text-gray-700 dark:text-gray-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition">
                                        {{ $platform }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                        {{ $platformCounts[$platform] ?? 0 }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- FILTER: Giá --}}
                        <div class="overflow-hidden last:rounded-b-xl">
                            <button type="button" class="filter-toggle w-full px-6 py-4 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white font-semibold flex items-center justify-between transition"
                                data-target="price-list">
                                <span>
                                    Giá
                                </span>
                                <i class="fa-solid fa-chevron-down transition-transform duration-300 text-gray-500"></i>
                            </button>
                            <div id="price-list" class="filter-content space-y-0 hidden border-t border-white/20 dark:border-white/10">
                                @php
                                    $priceRanges = [
                                        ['min' => 0, 'max' => 100000, 'label' => 'Dưới 100K'],
                                        ['min' => 100000, 'max' => 300000, 'label' => '100K - 300K'],
                                        ['min' => 300000, 'max' => 500000, 'label' => '300K - 500K'],
                                        ['min' => 500000, 'max' => 999999999, 'label' => 'Trên 500K'],
                                    ];
                                @endphp
                                @foreach ($priceRanges as $range)
                                <form action="{{ route('shop.index') }}" method="GET" class="inline w-full">
                                    {{-- Preserve other filters --}}
                                    @if (request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if (request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    @if (request('publisher'))
                                        <input type="hidden" name="publisher" value="{{ request('publisher') }}">
                                    @endif
                                    @if (request('platform'))
                                        <input type="hidden" name="platform" value="{{ request('platform') }}">
                                    @endif
                                    <input type="hidden" name="min_price" value="{{ $range['min'] }}">
                                    <input type="hidden" name="max_price" value="{{ $range['max'] }}">
                                    
                                    <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 px-6 py-3 border-b border-white/20 dark:border-white/10 last:border-0 transition group price-preset-label" data-min="{{ $range['min'] }}" data-max="{{ $range['max'] }}">
                                        <input type="checkbox" class="price-preset-checkbox appearance-none w-0 h-0 opacity-0 cursor-pointer"
                                            {{ (request('min_price') == $range['min'] && request('max_price') == $range['max']) ? 'checked' : '' }}
                                            onchange="this.closest('form').submit()">
                                        <span class="flex-1 text-sm text-gray-700 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition">
                                            {{ $range['label'] }}
                                        </span>
                                        <i class="fa-solid fa-check text-green-500 opacity-0 transition-opacity"
                                            style="opacity: {{ (request('min_price') == $range['min'] && request('max_price') == $range['max']) ? '1' : '0' }}"></i>
                                    </label>
                                </form>
                                @endforeach
                            </div>
                        </div>

                        {{-- FILTER: Nhà phát hành --}}
                        @if (isset($allPublishers) && $allPublishers->count() > 0)
                        <div class="overflow-hidden last:rounded-b-xl">
                            <button type="button" class="filter-toggle w-full px-6 py-4 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white font-semibold flex items-center justify-between transition"
                                data-target="publishers-list">
                                <span>
                                    Nhà phát hành
                                </span>
                                <i class="fa-solid fa-chevron-down transition-transform duration-300 text-gray-500"></i>
                            </button>
                            <div id="publishers-list" class="filter-content space-y-0 max-h-64 overflow-y-auto hidden">
                                @foreach ($allPublishers as $pub)
                                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 px-6 py-3 border-b border-white/20 dark:border-white/10 last:border-0 transition group">
                                    <input type="checkbox" name="publisher" value="{{ $pub }}"
                                        {{ request('publisher') === $pub ? 'checked' : '' }}
                                        class="publisher-filter w-4 h-4 rounded border-gray-300 dark:border-gray-600 cursor-pointer accent-purple-500 flex-shrink-0">
                                    <span class="flex-1 text-sm text-gray-700 dark:text-gray-300 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition truncate">
                                        {{ $pub }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                        {{ $publisherCounts[$pub] ?? 0 }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </aside>

            </div>
        </div>
    </div>
</x-shop-layout>
<script>
    // Format price with Vietnamese number format
    function formatPrice(input) {
        const value = input.value;
        const display = input.id === 'min_price' ? document.getElementById('min_display') : document.getElementById('max_display');
        
        if (value) {
            display.textContent = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value);
        } else {
            display.textContent = '';
        }
    }

    // Helper function to create filter form
    function createFilterForm(filterData) {
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route("shop.index") }}';
        
        Object.keys(filterData).forEach(key => {
            if (filterData[key]) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = filterData[key];
                form.appendChild(input);
            }
        });
        
        return form;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize price displays
        const minPrice = document.getElementById('min_price');
        const maxPrice = document.getElementById('max_price');
        if (minPrice && minPrice.value) formatPrice(minPrice);
        if (maxPrice && maxPrice.value) formatPrice(maxPrice);

        // Price preset buttons
        document.querySelectorAll('.price-preset').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('min_price').value = this.getAttribute('data-min');
                document.getElementById('max_price').value = this.getAttribute('data-max');
                
                formatPrice(document.getElementById('min_price'));
                formatPrice(document.getElementById('max_price'));
                
                // Auto submit
                document.getElementById('price-filter-form').submit();
            });
        });

        // Toggle filter sections
        document.querySelectorAll('.filter-toggle').forEach(btn => {
            const targetId = btn.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const icon = btn.querySelector('i:last-child');
            
            // Restore state from localStorage on page load
            if (localStorage.getItem(`filter-${targetId}`) === 'true') {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
            }
            
            // Add click event listener
            btn.addEventListener('click', function() {
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
                
                // Save state to localStorage
                localStorage.setItem(`filter-${targetId}`, !content.classList.contains('hidden'));
            });
        });

        // Handle category checkbox changes
        document.querySelectorAll('.category-filter').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Submit form regardless of check state
                const filterData = {
                    category: this.checked ? this.value : null,
                    search: '{{ request('search') }}' || null,
                    min_price: '{{ request('min_price') }}' || null,
                    max_price: '{{ request('max_price') }}' || null,
                    publisher: '{{ request('publisher') }}' || null,
                    platform: '{{ request('platform') }}' || null
                };
                
                const form = createFilterForm(filterData);
                document.body.appendChild(form);
                form.submit();
            });
        });

        // Handle platform checkbox changes
        document.querySelectorAll('.platform-filter').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Submit form regardless of check state
                const filterData = {
                    platform: this.checked ? this.value : null,
                    search: '{{ request('search') }}' || null,
                    category: '{{ request('category') }}' || null,
                    min_price: '{{ request('min_price') }}' || null,
                    max_price: '{{ request('max_price') }}' || null,
                    publisher: '{{ request('publisher') }}' || null
                };
                
                const form = createFilterForm(filterData);
                document.body.appendChild(form);
                form.submit();
            });
        });

        // Handle publisher checkbox changes
        document.querySelectorAll('.publisher-filter').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Submit form regardless of check state
                const filterData = {
                    publisher: this.checked ? this.value : null,
                    search: '{{ request('search') }}' || null,
                    category: '{{ request('category') }}' || null,
                    min_price: '{{ request('min_price') }}' || null,
                    max_price: '{{ request('max_price') }}' || null
                };
                
                const form = createFilterForm(filterData);
                document.body.appendChild(form);
                form.submit();
            });
        });

        // AJAX cart form handling
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
                            detail: {
                                message: data.message,
                                type: data.status
                            }
                        }));

                        // Success effect
                        if (data.status === 'success') {
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
                            if (btn.innerHTML.includes('fa-check')) {
                                btn.innerHTML = oldHtml;
                                btn.classList.remove('bg-green-500', 'text-white');
                            }
                        }, 2000);
                    });
            });
        });
        const wishlistBtns = document.querySelectorAll('.wishlist-btn');

        wishlistBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const gameId = this.dataset.gameId;
                const icon = this.querySelector('i');

                // Hiệu ứng loading (xoay nhẹ icon)
                icon.classList.add('fa-spin');
                this.disabled = true;

                fetch('{{ route("wishlist.toggle") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            game_id: gameId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Cập nhật giao diện dựa trên hành động trả về (added/removed)
                            if (data.action === 'added') {
                                // Chuyển sang tim đặc (Solid) & Màu đỏ
                                icon.classList.remove('fa-regular');
                                icon.classList.add('fa-solid');
                                this.classList.remove('text-gray-400', 'dark:text-gray-500');
                                this.classList.add('text-red-500');
                            } else {
                                // Chuyển sang tim rỗng (Regular) & Màu xám
                                icon.classList.remove('fa-solid');
                                icon.classList.add('fa-regular');
                                this.classList.remove('text-red-500');
                                this.classList.add('text-gray-400', 'dark:text-gray-500');
                            }

                            // Gọi thông báo (Notification Toast)
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    message: data.message,
                                    type: 'success'
                                }
                            }));
                        } else {
                            // Nếu server trả về lỗi
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    message: data.message || 'Có lỗi xảy ra',
                                    type: 'error'
                                }
                            }));
                        }
                    })
                    .catch(err => {
                        console.error('Lỗi Wishlist:', err);
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: 'Lỗi kết nối, vui lòng thử lại.',
                                type: 'error'
                            }
                        }));
                    })
                    .finally(() => {
                        // Tắt loading và mở lại nút
                        icon.classList.remove('fa-spin');
                        this.disabled = false;
                    });
            });
        });
    });
</script>