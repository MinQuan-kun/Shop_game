<x-shop-layout>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb (Đường dẫn) --}}
            <nav class="flex mb-6 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-miku-500 hover:underline">Trang chủ</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 dark:text-white font-medium truncate">{{ $game->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- CỘT TRÁI: Ảnh & Thông tin chính --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Ảnh Bìa Game --}}
                    <div
                        class="rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                        <div class="relative aspect-video">
                            <img src="{{ Str::startsWith($game->image, 'http') ? $game->image : asset('storage/' . $game->image) }}"
                                alt="{{ $game->name }}" class="w-full h-full object-cover">

                            {{-- Nhãn Giá --}}
                            <div class="absolute bottom-4 right-4">
                                @if($game->price == 0)
                                    <span class="bg-green-500 text-white text-lg font-bold px-4 py-2 rounded-lg shadow-lg">
                                        Miễn phí
                                    </span>
                                @else
                                    <span class="bg-brand-500 text-white text-lg font-bold px-4 py-2 rounded-lg shadow-lg">
                                        {{ number_format($game->price, 0, ',', '.') }} VNĐ
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Thông tin chi tiết & Nút bấm --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">{{ $game->name }}</h1>

                        <div class="flex flex-wrap gap-4 mb-6 text-sm">
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <i class="fa-solid fa-user-tie mr-2 text-miku-500"></i>
                                Nhà phát hành: <span
                                    class="font-semibold ml-1 text-gray-900 dark:text-white">{{ $game->publisher }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <i class="fa-solid fa-calendar-days mr-2 text-miku-500"></i>
                                Ngày đăng: <span
                                    class="font-semibold ml-1 text-gray-900 dark:text-white">{{ $game->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        {{-- Danh sách nền tảng --}}
                        @if(!empty($game->platforms))
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase">Nền tảng
                                    hỗ trợ</h3>
                                <div class="flex gap-2">
                                    @foreach($game->platforms as $platform)
                                        <span
                                            class="px-3 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm font-medium border border-gray-200 dark:border-gray-600">
                                            {{ $platform }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Nút hành động --}}
                        <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            @auth
                                @if(Auth::user()->ownsGame($game->id))
                                    {{-- User owns the game - show download --}}
                                    <a href="{{ $game->download_link }}" target="_blank"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-download"></i>
                                        Tải Game
                                    </a>
                                @else
                                    {{-- User doesn't own - show add to cart or buy --}}
                                    @if($game->price > 0)
                                        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                                            <button type="submit"
                                                class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg shadow-brand-500/30 flex items-center justify-center gap-2">
                                                <i class="fa-solid fa-cart-plus"></i>
                                                Thêm vào giỏ hàng - {{ number_format($game->price, 0, ',', '.') }} VNĐ
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ $game->download_link }}" target="_blank"
                                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-download"></i>
                                            Tải Game Miễn Phí
                                        </a>
                                    @endif
                                @endif
                            @else
                                {{-- Not logged in --}}
                                @if($game->price > 0)
                                    <a href="{{ route('login') }}"
                                        class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg shadow-brand-500/30 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        Đăng nhập để mua - {{ number_format($game->price, 0, ',', '.') }} VNĐ
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-download"></i>
                                        Đăng nhập để tải miễn phí
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    {{-- Mô tả Game --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-align-left text-miku-500"></i> Giới thiệu game
                        </h2>
                        <div
                            class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                            {{ $game->description }}
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: Sidebar & Game liên quan --}}
                <div class="w-full space-y-8">

                    {{-- Box thông tin Discord (Giữ lại từ trang chủ) --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 relative h-64 flex items-center justify-center group cursor-pointer shadow-sm">
                        <img src="https://res.cloudinary.com/davfujasj/image/upload/v1765274236/Gemini_Generated_Image_l4qelbl4qelbl4qe_v2akas.png"
                            class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-70 transition duration-500">
                        <div class="relative z-10 text-center p-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Cộng đồng Discord</h3>
                            <p class="text-sm font-bold text-gray-600 dark:text-gray-300 mb-4">Hỗ trợ cài đặt & tìm bạn
                                chơi cùng</p>
                            <span
                                class="inline-block bg-[#5865F2] text-white px-4 py-2 rounded font-bold hover:bg-[#4752c4] transition shadow-md">
                                <i class="fa-brands fa-discord mr-1"></i> Tham gia ngay
                            </span>
                        </div>
                    </div>

                    {{-- Game Liên Quan --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3
                            class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-600 pb-2">
                            Có thể bạn thích
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedGames as $related)
                                <a href="{{ route('game.show', $related->id) }}" class="flex gap-4 group">
                                    <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden relative">
                                        <img src="{{ Str::startsWith($related->image, 'http') ? $related->image : asset('storage/' . $related->image) }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-miku-500 transition line-clamp-2">
                                            {{ $related->name }}
                                        </h4>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            @if($related->price == 0)
                                                <span class="text-green-500 font-bold">Miễn phí</span>
                                            @else
                                                <span
                                                    class="text-brand-500 font-bold">{{ number_format($related->price, 0, ',', '.') }}đ</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-shop-layout>