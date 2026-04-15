<x-shop-layout>
    @php
    $wishlistGameIds = auth()->check()
    ? \App\Models\Wishlist::where('user_id', auth()->id())->pluck('game_id')->toArray()
    : [];
    @endphp
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">

        <x-banner />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Thanh tìm kiếm riêng biệt ở đầu --}}
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg p-6"
                x-data="searchAutocomplete()">
                <div class="flex flex-col gap-4">
                    <div class="relative">
                        <input type="text" name="search" placeholder="🔍 Tìm kiếm game..."
                            value="{{ request('search') }}" @input="search($el.value)" @focus="open = true"
                            @keydown.escape="open = false"
                            class="w-full px-5 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-0 focus:border-miku-500 outline-none transition text-lg">

                        {{-- Suggestions dropdown --}}
                        <div x-show="open && suggestions.length > 0" @click.outside="closeSuggestions()"
                            class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-gray-800 border-2 border-miku-300 dark:border-miku-600 rounded-lg shadow-2xl z-50 max-h-96 overflow-y-auto">
                            <template x-for="(game, idx) in suggestions" :key="idx">
                                <a :href="`{{ url('/game') }}/${game.id}`" @click="closeSuggestions()"
                                    class="flex items-center gap-3 p-4 hover:bg-miku-50 dark:hover:bg-miku-900/20 transition border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <img :src="game.image" :alt="game.name"
                                        class="w-12 h-16 object-cover rounded-lg shadow-sm">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate"
                                            x-text="game.name"></p>
                                        <p class="text-xs text-miku-600 dark:text-miku-400 font-bold"
                                            x-text="game.price_formatted"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>



            {{-- Danh sách Game --}}
            <div>
                {{-- Section Gợi ý AI --}}
                @if (isset($recommendedGames) && $recommendedGames->count() > 0)
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="p-2 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg text-white shadow-lg">
                            <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-wide">
                                @auth
                                Gợi ý dành riêng cho bạn
                                @else
                                Game Nổi Bật & Bán Chạy
                                @endauth
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @auth
                                Dựa trên sở thích và lịch sử mua hàng của bạn
                                @else
                                Những tựa game được cộng đồng yêu thích nhất
                                @endauth
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($recommendedGames as $recGame)
                        <div
                            class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:-translate-y-1">
                            {{-- Ảnh --}}
                            <div class="relative h-40 overflow-hidden">
                                <img src="{{ Str::startsWith($recGame->image, 'http') ? $recGame->image : asset('storage/' . $recGame->image) }}"
                                    alt="{{ $recGame->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @if ($recGame->price == 0)
                                <span
                                    class="absolute top-2 right-2 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded">FREE</span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 dark:text-white truncate mb-1"
                                    title="{{ $recGame->name }}">
                                    <a href="{{ route('game.show', $recGame->id) }}">{{ $recGame->name }}</a>
                                </h3>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-sm font-bold text-miku-600 dark:text-miku-400">
                                        {{ number_format($recGame->price, 0, ',', '.') }}đ
                                    </span>
                                    <span class="text-xs text-gray-500 flex items-center gap-1">
                                        <i class="fa-solid fa-star text-yellow-400"></i> Gợi ý
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="flex items-center justify-between mb-6 border-l-4 border-miku-500 pl-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                        @if (request('category'))
                        {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Games' }} Mới
                        @else
                        Game Mới
                        @endif
                    </h2>
                    <a href="/shop" class="text-sm text-miku-600 dark:text-miku-400 hover:underline">
                        Xem tất cả <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Grid hiển thị Game --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($games as $game)
                    <div
                        class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 dark:border-gray-700 transition-all duration-300 flex flex-col h-full">

                        {{-- [LOGIC] Tính toán giá ảo --}}
                        @php
                        $hasDiscount = $game->price > 0;
                        $discountPercent = $hasDiscount ? rand(10, 30) : 0;
                        $fakeOriginalPrice = $game->price * (1 + $discountPercent / 100);
                        @endphp

                        {{-- 1. ẢNH GAME --}}
                        <div class="relative h-48 overflow-hidden bg-gray-200 dark:bg-gray-700">
                            <a href="{{ route('game.show', $game->id) }}" class="block w-full h-full">
                                <img src="{{ str_starts_with($game->image, 'http') ? $game->image : asset('storage/' . $game->image) }}"
                                    alt="{{ $game->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                            </a>

                            {{-- Badge (Góc phải trên + Nhấp nháy) --}}
                            <div class="absolute top-2 right-2 flex flex-col items-end gap-1">
                                @if ($game->price == 0)
                                <span
                                    class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow animate-pulse">
                                    Miễn phí
                                </span>
                                @else
                                <span
                                    class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm animate-pulse">
                                    -{{ $discountPercent }}%
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- 2. NỘI DUNG --}}
                        <div class="p-4 flex flex-col flex-grow">
                            {{-- Tên Game --}}
                            <h3
                                class="text-base font-bold text-gray-900 dark:text-white leading-tight mb-2 line-clamp-2 hover:text-miku-600 dark:hover:text-miku-400 transition-colors">
                                <a href="{{ route('game.show', $game->id) }}">
                                    {{ $game->name }}
                                </a>
                            </h3>

                            {{-- Thông tin phụ --}}
                            <div class="mb-4 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                @if (!empty($game->platforms))
                                <span
                                    class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">{{ $game->platforms[0] ?? 'PC' }}</span>
                                @endif
                                {{-- Dùng optional để tránh lỗi nếu chưa có category --}}
                                <span>{{ optional($game->primary_category)->name ?? 'Game' }}</span>
                            </div>

                            {{-- 3. CHÂN CARD (GIÁ & CÁC NÚT) --}}
                            <div class="mt-auto pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">

                                {{-- Giá tiền --}}
                                <div class="flex flex-col">
                                    @if ($game->price == 0)
                                    <span class="text-lg font-bold text-green-500">Miễn phí</span>
                                    @else
                                    <span class="text-[10px] text-gray-400 line-through">{{ number_format($fakeOriginalPrice, 0, ',', '.') }}đ</span>
                                    <span class="text-lg font-black text-miku-600 dark:text-miku-400">{{ number_format($game->price, 0, ',', '.') }}đ</span>
                                    @endif
                                </div>

                                {{-- KHU VỰC CÁC NÚT (WISHLIST + CART) --}}
                                <div class="flex items-center gap-2">

                                    {{-- [MỚI] Nút Wishlist (Trái tim) --}}
                                    @auth
                                    @php $inWishlist = in_array($game->id, $wishlistGameIds); @endphp
                                    <button type="button"
                                        data-game-id="{{ $game->id }}"
                                        class="wishlist-btn w-10 h-10 flex items-center justify-center rounded-full bg-miku-50 dark:bg-miku-900/30 text-gray-400 dark:text-gray-500 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-900/30 transition-all shadow-sm hover:shadow-md transform active:scale-95 group/wishlist {{ $inWishlist ? '!text-red-500' : '' }}"
                                        title="{{ $inWishlist ? 'Bỏ yêu thích' : 'Thêm yêu thích' }}">
                                        <i class="{{ $inWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm group-hover/wishlist:text-red-500 transition-transform"></i>
                                    </button>
                                    @else
                                    <a href="{{ route('login') }}"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-miku-50 dark:bg-miku-900/30 text-gray-400 dark:text-gray-500 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-900/30 transition-all shadow-sm hover:shadow-md transform active:scale-95 group/wishlist"
                                        title="Đăng nhập để yêu thích">
                                        <i class="fa-regular fa-heart text-sm group-hover/wishlist:text-red-500"></i>
                                    </a>
                                    @endauth

                                    {{-- Nút Giỏ hàng (Giữ nguyên) --}}
                                    @auth
                                    <form action="{{ route('cart.add') }}" method="POST" class="ajax-cart-form">
                                        @csrf
                                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                                        <button type="submit"
                                            class="flex items-center justify-center w-10 h-10 rounded-full bg-miku-50 dark:bg-miku-900/30 text-miku-600 dark:text-miku-400 hover:bg-miku-500 hover:text-white transition-all shadow-sm hover:shadow-md transform active:scale-95"
                                            title="Thêm vào giỏ hàng">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </form>
                                    @else
                                    <a href="{{ route('login') }}"
                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 hover:bg-miku-500 hover:text-white transition-all shadow-sm"
                                        title="Đăng nhập để mua">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Phân trang (Pagination) --}}
                <div class="mt-8">
                    {{ $games->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
</x-shop-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.ajax-cart-form');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const button = form.querySelector('button');
                const originalContent = button.innerHTML;

                // Hiệu ứng loading
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                button.disabled = true;

                fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    message: data.message,
                                    type: 'success'
                                }
                            }));

                            button.innerHTML =
                                '<i class="fa-solid fa-check text-green-500"></i>';
                        } else {
                            // [THAY ĐỔI] GỌI POPUP LỖI
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    message: data.message,
                                    type: 'error'
                                }
                            }));
                            button.innerHTML = originalContent;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: 'Đã có lỗi xảy ra, vui lòng thử lại!',
                                type: 'error'
                            }
                        }));
                        button.innerHTML = originalContent;
                    })
                    .finally(() => {
                        setTimeout(() => {
                            button.disabled = false;
                            if (button.innerHTML.includes('fa-check')) {
                                button.innerHTML = originalContent;
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

                // Loading
                icon.classList.add('fa-spin');
                this.disabled = true;

                fetch("{{ route('wishlist.toggle') }}", {
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
                            if (data.action === 'added') {
                                // Tim đỏ
                                icon.classList.remove('fa-regular');
                                icon.classList.add('fa-solid');
                                this.classList.add('!text-red-500');
                            } else {
                                // Tim rỗng
                                icon.classList.remove('fa-solid');
                                icon.classList.add('fa-regular');
                                this.classList.remove('!text-red-500');
                            }
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    message: data.message,
                                    type: 'success'
                                }
                            }));
                        } else {
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    message: data.message || 'Lỗi',
                                    type: 'error'
                                }
                            }));
                        }
                    })
                    .catch(err => {
                        console.error('Wishlist Error:', err);
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                message: 'Lỗi kết nối',
                                type: 'error'
                            }
                        }));
                    })
                    .finally(() => {
                        icon.classList.remove('fa-spin');
                        this.disabled = false;
                    });
            });
        });
    });
</script>