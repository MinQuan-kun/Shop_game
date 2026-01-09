<x-shop-layout>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header với Back Button --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <button onclick="window.history.back()"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:text-miku-600 dark:hover:text-miku-400 hover:border-miku-500 transition shadow-sm">
                        <i class="fa-solid fa-arrow-left text-lg"></i>
                    </button>
                    <nav class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <a href="{{ route('home') }}" class="hover:text-miku-500 transition">Trang chủ</a>
                        <span class="mx-3">/</span>
                        <span
                            class="text-gray-800 dark:text-white font-semibold max-w-xs truncate">{{ $game->name }}</span>
                    </nav>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- CỘT TRÁI: Ảnh & Thông tin chính --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Ảnh Bìa Game --}}
                    <div
                        class="rounded-2xl overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 group">
                        <div class="relative aspect-video bg-gray-900 overflow-hidden">
                            <img src="{{ Str::startsWith($game->image, 'http') ? $game->image : asset('storage/' . $game->image) }}"
                                alt="{{ $game->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                            {{-- Nhãn Giá --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                            </div>
                            <div class="absolute bottom-4 right-4 flex flex-col items-end gap-2">
                                @if($game->price == 0)
                                    <span
                                        class="bg-gradient-to-r from-green-500 to-emerald-600 text-white text-lg font-bold px-6 py-3 rounded-xl shadow-2xl">
                                        <i class="fa-solid fa-gift mr-2"></i>Miễn phí
                                    </span>
                                @else
                                    <span
                                        class="bg-gradient-to-r from-miku-500 to-miku-600 text-white text-lg font-bold px-6 py-3 rounded-xl shadow-2xl">
                                        {{ number_format($game->price, 0, ',', '.') }} VNĐ
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Thông tin chi tiết & Nút bấm --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-200 dark:border-gray-700">
                        <h1
                            class="text-4xl font-black text-gray-900 dark:text-white mb-2 bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                            {{ $game->name }}</h1>

                        <div
                            class="flex flex-wrap gap-6 mb-8 text-sm pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-miku-50 dark:bg-miku-900/30 flex items-center justify-center text-miku-600">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Nhà phát
                                        hành</p>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $game->publisher }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Ngày
                                        đăng</p>
                                    <p class="font-bold text-gray-900 dark:text-white">
                                        {{ $game->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            @if(!empty($game->sold_count))
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center text-orange-600">
                                        <i class="fa-solid fa-fire"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Đã bán
                                        </p>
                                        <p class="font-bold text-gray-900 dark:text-white">
                                            {{ number_format($game->sold_count) }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Danh sách nền tảng --}}
                        @if(!empty($game->platforms))
                            <div class="mb-8">
                                <h3
                                    class="text-sm font-black text-gray-800 dark:text-gray-200 mb-3 uppercase tracking-wide">
                                    Nền tảng hỗ trợ</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($game->platforms as $platform)
                                        <span
                                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-600 text-gray-800 dark:text-gray-100 text-sm font-semibold border border-gray-200 dark:border-gray-600 shadow-sm">
                                            <i class="fa-solid fa-gamepad mr-2"></i>{{ $platform }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Thể loại Game --}}
                        @if(!empty($game->category_ids))
                            <div class="mb-8">
                                <h3
                                    class="text-sm font-black text-gray-800 dark:text-gray-200 mb-3 uppercase tracking-wide">
                                    Thể loại</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($game->category_ids as $catId)
                                        @php
                                            $categories = \App\Models\Category::all();
                                            $cat = $categories->find($catId);
                                        @endphp
                                        @if($cat)
                                            <a href="{{ route('shop.index', ['category' => $catId]) }}"
                                                class="px-3 py-1 rounded-lg bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 text-xs font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/60 transition border border-blue-300 dark:border-blue-700">
                                                {{ $cat->name }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Ngôn ngữ hỗ trợ --}}
                        @if(!empty($game->languages))
                            <div class="mb-8">
                                <h3
                                    class="text-sm font-black text-gray-800 dark:text-gray-200 mb-3 uppercase tracking-wide">
                                    Ngôn ngữ hỗ trợ</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(is_array($game->languages) ? $game->languages : [$game->languages] as $lang)
                                        <span
                                            class="px-3 py-1 rounded-lg bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 text-xs font-semibold border border-green-300 dark:border-green-700">
                                            <i class="fa-solid fa-globe mr-1"></i>{{ $lang }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Nút hành động --}}
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                            @auth
                                @php
                                    $inWishlist = \App\Models\Wishlist::where('user_id', Auth::id())
                                        ->where('game_id', $game->id)
                                        ->exists();
                                @endphp

                                @if(Auth::user()->ownsGame($game->id))
                                    {{-- User owns the game - show download --}}
                                    <a href="{{ $game->download_link }}" target="_blank"
                                        class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg shadow-green-500/30 flex items-center justify-center gap-2 group">
                                        <i class="fa-solid fa-download group-hover:scale-110 transition"></i>
                                        Tải Game
                                    </a>
                                @else
                                    {{-- User doesn't own - show add to cart or buy --}}
                                    @if($game->price > 0)
                                        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                                            <button type="submit"
                                                class="w-full bg-gradient-to-r from-miku-500 to-miku-600 hover:from-miku-600 hover:to-miku-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg shadow-miku-500/30 flex items-center justify-center gap-2 group">
                                                <i class="fa-solid fa-cart-plus group-hover:scale-110 transition"></i>
                                                Thêm vào giỏ hàng
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ $game->direct_download_link}}" target="_blank"
                                            class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg shadow-green-500/30 flex items-center justify-center gap-2 group">
                                            <i class="fa-solid fa-download group-hover:scale-110 transition"></i>
                                            Tải Game Miễn Phí
                                        </a>
                                    @endif
                                @endif

                                {{-- Wishlist Toggle Button --}}
                                <form action="{{ route('wishlist.toggle') }}" method="POST" id="wishlist-form">
                                    @csrf
                                    <input type="hidden" name="game_id" value="{{ $game->id }}">
                                    <button type="submit" id="wishlist-btn"
                                        class="px-6 py-3 rounded-xl font-bold transition shadow-lg flex items-center justify-center gap-2 group
                                            {{ $inWishlist ? 'bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white shadow-pink-500/30' : 'bg-white dark:bg-gray-700 text-pink-500 dark:text-pink-400 border-2 border-pink-500 dark:border-pink-400 hover:bg-pink-50 dark:hover:bg-gray-600' }}">
                                        <i
                                            class="fa-{{ $inWishlist ? 'solid' : 'regular' }} fa-heart group-hover:scale-110 transition"></i>
                                        <span
                                            class="hidden sm:inline">{{ $inWishlist ? 'Đã yêu thích' : 'Yêu thích' }}</span>
                                    </button>
                                </form>
                            @else
                                {{-- Not logged in --}}
                                @if($game->price > 0)
                                    <a href="{{ route('login') }}"
                                        class="flex-1 bg-gradient-to-r from-miku-500 to-miku-600 hover:from-miku-600 hover:to-miku-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg shadow-miku-500/30 flex items-center justify-center gap-2 group">
                                        <i class="fa-solid fa-cart-plus group-hover:scale-110 transition"></i>
                                        Đăng nhập để mua
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl text-center transition shadow-lg shadow-green-500/30 flex items-center justify-center gap-2 group">
                                        <i class="fa-solid fa-download group-hover:scale-110 transition"></i>
                                        Đăng nhập tải miễn phí
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    {{-- Mô tả Game --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-miku-500 to-miku-600 flex items-center justify-center text-white">
                                <i class="fa-solid fa-align-left text-sm"></i>
                            </div>
                            Giới thiệu game
                        </h2>
                        <div
                            class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line text-base">
                            {{ $game->description }}
                        </div>
                    </div>

                    {{-- Thông tin kỹ thuật --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Thông tin chung --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-black text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle text-blue-500"></i>
                                Thông tin
                            </h3>
                            <div class="space-y-3">
                                @if($game->publisher)
                                    <div class="flex justify-between items-start border-b border-gray-100 dark:border-gray-700 pb-3">
                                        <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Nhà phát hành:</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white text-right">{{ $game->publisher }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between items-start border-b border-gray-100 dark:border-gray-700 pb-3">
                                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Ngày phát hành:</span>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $game->created_at->format('d/m/Y') }}</span>
                                </div>
                                @if(!empty($game->platforms))
                                    <div class="flex justify-between items-start border-b border-gray-100 dark:border-gray-700 pb-3">
                                        <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Nền tảng:</span>
                                        <div class="text-right">
                                            @foreach($game->platforms as $platform)
                                                <span class="inline-block text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded ml-1">{{ $platform }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if($game->sold_count)
                                    <div class="flex justify-between items-start">
                                        <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Đã bán:</span>
                                        <span class="text-sm font-bold text-orange-500">{{ number_format($game->sold_count) }} bản</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Danh mục & Ngôn ngữ --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-black text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-tag text-purple-500"></i>
                                Danh mục & Ngôn ngữ
                            </h3>
                            <div class="space-y-3">
                                @if(!empty($game->category_ids))
                                    <div>
                                        <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-2">Thể loại:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($game->category_ids as $catId)
                                                @php
                                                    $categories = \App\Models\Category::all();
                                                    $cat = $categories->find($catId);
                                                @endphp
                                                @if($cat)
                                                    <a href="{{ route('shop.index', ['category' => $catId]) }}"
                                                        class="text-xs bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 px-2 py-1 rounded hover:bg-blue-200 dark:hover:bg-blue-900/60 transition">
                                                        {{ $cat->name }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($game->languages))
                                    <div class="border-t border-gray-100 dark:border-gray-700 pt-3">
                                        <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-2">Ngôn ngữ:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach(is_array($game->languages) ? $game->languages : [$game->languages] as $lang)
                                                <span class="text-xs bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 px-2 py-1 rounded">
                                                    {{ $lang }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: Sidebar & Game liên quan --}}
                <div class="w-full space-y-6">

                    {{-- Box thông tin Discord --}}
                    <div
                        class="bg-gradient-to-br from-[#5865F2] to-[#4752c4] rounded-2xl overflow-hidden relative h-72 flex items-center justify-center group cursor-pointer shadow-2xl border border-[#6c77ff]/50 hover:shadow-[#5865F2]/50 transition-all duration-300">
                        <img src="https://res.cloudinary.com/davfujasj/image/upload/v1765274236/Gemini_Generated_Image_l4qelbl4qelbl4qe_v2akas.png"
                            class="absolute inset-0 w-full h-full object-cover opacity-20 group-hover:opacity-40 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#5865F2]/80 via-transparent to-transparent">
                        </div>
                        <div class="relative z-10 text-center p-6">
                            <div
                                class="w-12 h-12 mx-auto mb-3 rounded-full bg-white/20 flex items-center justify-center text-2xl">
                                <i class="fa-brands fa-discord text-white"></i>
                            </div>
                            <h3 class="text-2xl font-black text-white mb-2">Cộng đồng Discord</h3>
                            <p class="text-sm font-semibold text-blue-100 mb-5 leading-relaxed">
                                Hỗ trợ cài đặt & tìm bạn chơi cùng
                            </p>
                            <a href="#"
                                class="inline-block bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg font-bold hover:bg-yellow-300 transition shadow-lg transform group-hover:scale-105 duration-300">
                                <i class="fa-brands fa-discord mr-2"></i>Tham gia ngay
                            </a>
                        </div>
                    </div>

                    {{-- Game Liên Quan --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3
                            class="text-lg font-black text-gray-900 dark:text-white mb-5 border-b border-gray-100 dark:border-gray-600 pb-3 flex items-center gap-2">
                            <i class="fa-solid fa-fire text-orange-500"></i>
                            Có thể bạn thích
                        </h3>
                        <div class="space-y-3">
                            @foreach($relatedGames as $related)
                                <a href="{{ route('game.show', $related->id) }}"
                                    class="flex gap-4 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition group">
                                    <div class="w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden relative shadow-md">
                                        <img src="{{ Str::startsWith($related->image, 'http') ? $related->image : asset('storage/' . $related->image) }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                        <div
                                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                            <i class="fa-solid fa-play text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4
                                            class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-miku-500 dark:group-hover:text-miku-400 transition line-clamp-2 mb-2">
                                            {{ $related->name }}
                                        </h4>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                @if($related->price == 0)
                                                    <span
                                                        class="text-xs font-black text-green-600 dark:text-green-400 uppercase tracking-wide">Miễn
                                                        phí</span>
                                                @else
                                                    <span
                                                        class="text-sm font-black text-miku-600 dark:text-miku-400">{{ number_format($related->price, 0, ',', '.') }}đ</span>
                                                @endif
                                            </div>
                                            <i
                                                class="fa-solid fa-arrow-right text-gray-400 group-hover:text-miku-500 transition opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 duration-300"></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            {{-- SECTION: COMMENTS/REVIEWS --}}
            <div class="mt-20 pt-12 border-t-2 border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-8 flex items-center gap-3 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center text-white">
                        <i class="fa-solid fa-comments text-sm"></i>
                    </div>
                    Bình luận & Đánh giá
                </h2>

                <div class="space-y-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @auth
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Viết bình luận</h3>
                            <form action="#" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="game_id" value="{{ $game->id }}">
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Đánh giá:</label>
                                    <div class="flex gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition" data-rating="{{ $i }}">
                                                <i class="fa-{{ $i <= 3 ? 'regular' : 'solid' }} fa-star"></i>
                                            </button>
                                        @endfor
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tiêu đề bình luận:</label>
                                    <input type="text" name="title" placeholder="VD: Game tuyệt vời..." 
                                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-miku-500 focus:border-transparent outline-none transition"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nội dung:</label>
                                    <textarea name="content" rows="4" placeholder="Chia sẻ suy nghĩ của bạn về game..." 
                                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-miku-500 focus:border-transparent outline-none transition resize-none"
                                        required></textarea>
                                </div>

                                <div class="flex gap-3 pt-4">
                                    <button type="submit" class="flex-1 bg-gradient-to-r from-miku-500 to-miku-600 hover:from-miku-600 hover:to-miku-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-lg shadow-miku-500/30 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Gửi bình luận
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="p-6 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800 text-center">
                            <p class="text-gray-700 dark:text-gray-300 mb-3">
                                <i class="fa-solid fa-info-circle text-blue-500 mr-2"></i>
                                Vui lòng đăng nhập để bình luận
                            </p>
                            <a href="{{ route('login') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition">
                                Đăng nhập
                            </a>
                        </div>
                    @endauth

                    {{-- Comments List --}}
                    <div class="space-y-4">
                        {{-- Sample Comments (Replace with dynamic data) --}}
                        <div class="p-4 border-l-4 border-yellow-400 bg-white dark:bg-gray-800 rounded-r-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                        <span>Người dùng tuyệt vời</span>
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star text-sm"></i>
                                            @endfor
                                        </div>
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">2 ngày trước</p>
                                </div>
                            </div>
                            <h5 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Game tuyệt vời!</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Đây là game rất hay, đồ họa đẹp, gameplay mượt mà. Mình chơi rất thích! Nên mua ngay nếu bạn yêu thích thể loại này.
                            </p>
                            <div class="mt-3 flex gap-3 text-xs">
                                <button class="text-gray-500 hover:text-miku-500 transition flex items-center gap-1">
                                    <i class="fa-solid fa-thumbs-up"></i> Hữu ích (5)
                                </button>
                                <button class="text-gray-500 hover:text-red-500 transition flex items-center gap-1">
                                    <i class="fa-solid fa-thumbs-down"></i> Không hữu ích (0)
                                </button>
                            </div>
                        </div>

                        <div class="p-4 border-l-4 border-yellow-400 bg-white dark:bg-gray-800 rounded-r-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                        <span>Game Gamer</span>
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 4; $i++)
                                                <i class="fa-solid fa-star text-sm"></i>
                                            @endfor
                                            <i class="fa-regular fa-star text-sm"></i>
                                        </div>
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">5 ngày trước</p>
                                </div>
                            </div>
                            <h5 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Hay, nhưng đôi khi lỗi</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Game chơi rất mượt, nhưng đôi khi bị lag trong những trận đông người. Hy vọng nhà phát hành sẽ fix sớm.
                            </p>
                            <div class="mt-3 flex gap-3 text-xs">
                                <button class="text-gray-500 hover:text-miku-500 transition flex items-center gap-1">
                                    <i class="fa-solid fa-thumbs-up"></i> Hữu ích (12)
                                </button>
                                <button class="text-gray-500 hover:text-red-500 transition flex items-center gap-1">
                                    <i class="fa-solid fa-thumbs-down"></i> Không hữu ích (2)
                                </button>
                            </div>
                        </div>

                        <div class="p-4 border-l-4 border-yellow-400 bg-white dark:bg-gray-800 rounded-r-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                        <span>Pro Player</span>
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 3; $i++)
                                                <i class="fa-solid fa-star text-sm"></i>
                                            @endfor
                                            @for($i = 4; $i <= 5; $i++)
                                                <i class="fa-regular fa-star text-sm"></i>
                                            @endfor
                                        </div>
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">1 tuần trước</p>
                                </div>
                            </div>
                            <h5 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Chưa thực sự thuyết phục</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Gameplay chưa đủ sâu, story tạm được. Sẽ chờ bản update tiếp theo để xem họ cải thiện gì.
                            </p>
                            <div class="mt-3 flex gap-3 text-xs">
                                <button class="text-gray-500 hover:text-miku-500 transition flex items-center gap-1">
                                    <i class="fa-solid fa-thumbs-up"></i> Hữu ích (8)
                                </button>
                                <button class="text-gray-500 hover:text-red-500 transition flex items-center gap-1">
                                    <i class="fa-solid fa-thumbs-down"></i> Không hữu ích (3)
                                </button>
                            </div>
                        </div>

                        {{-- Load More --}}
                        <div class="text-center pt-6 border-t border-gray-200 dark:border-gray-700 p-4 bg-white dark:bg-gray-800 rounded-lg">
                            <button class="inline-flex items-center gap-2 px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 font-semibold rounded-lg transition">
                                <i class="fa-solid fa-chevron-down"></i>
                                Xem thêm bình luận
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>