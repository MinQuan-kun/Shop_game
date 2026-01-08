<x-shop-layout>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">

        <x-banner />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Thanh tìm kiếm riêng biệt ở đầu --}}
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg p-6" x-data="searchAutocomplete()">
                <div class="flex flex-col gap-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="🔍 Tìm kiếm game..."
                            value="{{ request('search') }}"
                            @input="search($el.value)"
                            @focus="open = true"
                            @keydown.escape="open = false"
                            class="w-full px-5 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-0 focus:border-miku-500 outline-none transition text-lg">
                        
                        {{-- Suggestions dropdown --}}
                        <div x-show="open && suggestions.length > 0" @click.outside="closeSuggestions()" class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-gray-800 border-2 border-miku-300 dark:border-miku-600 rounded-lg shadow-2xl z-50 max-h-96 overflow-y-auto">
                            <template x-for="(game, idx) in suggestions" :key="idx">
                                <a :href="`{{ url('/game') }}/${game.id}`" @click="closeSuggestions()" class="flex items-center gap-3 p-4 hover:bg-miku-50 dark:hover:bg-miku-900/20 transition border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <img :src="game.image" :alt="game.name" class="w-12 h-16 object-cover rounded-lg shadow-sm">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate" x-text="game.name"></p>
                                        <p class="text-xs text-miku-600 dark:text-miku-400 font-bold" x-text="game.price_formatted"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bộ lọc ngang ở đầu - Collapsible --}}
            <form action="{{ route('home') }}" method="GET" id="filterForm">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden" x-data="{ open: {{ request()->hasAny(['search', 'min_price', 'max_price', 'platform', 'publisher']) ? 'true' : 'false' }} }">
                    
                    {{-- Header toggle --}}
                    <button type="button" @click="open = !open" class="w-full px-6 py-4 bg-gradient-to-r from-miku-500 to-miku-600 hover:from-miku-600 hover:to-miku-700 text-white font-black text-lg flex items-center justify-between transition shadow-md">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-sliders"></i>Bộ lọc nâng cao
                        </span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="open && 'rotate-180'"></i>
                    </button>

                    {{-- Filter content --}}
                    <div x-show="open" x-transition class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            
                            {{-- Giá --}}
                            <div>
                                <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide block mb-2">💰 Từ giá</label>
                                <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-0 focus:border-orange-500 outline-none transition text-sm">
                            </div>

                            {{-- Đến giá --}}
                            <div>
                                <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide block mb-2">💰 Đến giá</label>
                                <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-0 focus:border-orange-500 outline-none transition text-sm">
                            </div>

                            {{-- Nền tảng --}}
                            <div>
                                <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide block mb-2">🎮 Nền tảng</label>
                                <select name="platform[]" multiple class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-0 focus:border-blue-500 outline-none transition text-sm">
                                    <option value="">Chọn...</option>
                                    @foreach(['PC', 'PS5', 'Xbox Series X/S', 'Nintendo Switch'] as $platform)
                                        <option value="{{ $platform }}" {{ in_array($platform, (array)request('platform', [])) ? 'selected' : '' }}>{{ $platform }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Nhà phát hành --}}
                            @if($publishers->count() > 0)
                            <div>
                                <label class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide block mb-2">🏢 NPH</label>
                                <select name="publisher" class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-0 focus:border-purple-500 outline-none transition text-sm">
                                    <option value="">Tất cả</option>
                                    @foreach($publishers as $pub)
                                        <option value="{{ $pub }}" {{ request('publisher') === $pub ? 'selected' : '' }}>{{ substr($pub, 0, 15) }}{{ strlen($pub) > 15 ? '...' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                        </div>

                        {{-- Nút submit & reset --}}
                        <div class="flex gap-3 mt-6">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-miku-500 to-miku-600 hover:from-miku-600 hover:to-miku-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md transform hover:scale-105 duration-300">
                                <i class="fa-solid fa-check mr-2"></i>Áp dụng
                            </button>
                            @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'platform', 'publisher']))
                            <a href="{{ route('home') }}" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition shadow-md transform hover:scale-105 duration-300 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-redo"></i>Reset
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            {{-- Phần category filter ngang --}}
            <form action="{{ route('home') }}" method="GET" class="mb-6">
                <div class="flex gap-2 flex-wrap">
                    <button type="submit" name="category" value="" class="px-4 py-2 rounded-lg font-semibold text-sm transition {{ !request('category') ? 'bg-miku-500 text-white shadow-md' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-miku-500' }}">
                        ⭐ Tất cả
                    </button>
                    @foreach ($categories as $category)
                        <button type="submit" name="category" value="{{ $category->slug }}" class="px-4 py-2 rounded-lg font-semibold text-sm transition {{ request('category') === $category->slug ? 'bg-miku-500 text-white shadow-md' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-miku-500' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
                {{-- Preserve other filters --}}
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('min_price'))
                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                @endif
                @if(request('max_price'))
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                @endif
                @if(request('publisher'))
                    <input type="hidden" name="publisher" value="{{ request('publisher') }}">
                @endif
            </form>

            {{-- Danh sách Game --}}
            <div>
                <div class="flex items-center justify-between mb-6 border-l-4 border-miku-500 pl-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                        @if(request('category'))
                            {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Games' }} Mới
                        @else
                            Game Mới
                        @endif
                    </h2>
                    <a href="#" class="text-sm text-miku-600 dark:text-miku-400 hover:underline">
                        Xem tất cả <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Grid hiển thị Game --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($games as $game)
                            <div class="group bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md dark:shadow-lg border border-gray-200 dark:border-gray-700 hover:border-miku-500 transition duration-300">
                                
                                {{-- Phần Ảnh Game --}}
                                <div class="relative h-48 overflow-hidden bg-gray-200 dark:bg-gray-700">
                                    <img src="{{ Str::startsWith($game->image, 'http') ? $game->image : asset('storage/' . $game->image) }}"
                                         alt="{{ $game->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        
                                    {{-- Nhãn giá / Miễn phí --}}
                                    <div class="absolute top-2 right-2">
                                        @if($game->price == 0)
                                            <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow">
                                                Miễn phí
                                            </span>
                                        @else
                                            <span class="bg-brand-500 text-white text-xs font-bold px-2 py-1 rounded shadow">
                                                {{ number_format($game->price, 0, ',', '.') }}đ
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Phần Thông tin --}}
                                <div class="p-4">
                                    {{-- Tên Game --}}
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-snug mb-2 group-hover:text-miku-600 dark:group-hover:text-miku-400 transition line-clamp-2 min-h-[3.5rem]">
                                        <a href="{{ route('game.show', $game->id) }}">{{ $game->name }}
                                        </a>
                                    {{-- Ngày đăng --}}
                                    <div class="text-sm text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-3 flex justify-between items-center">
                                        <span>
                                            <i class="fa-solid fa-calendar-days mr-1"></i> 
                                            {{ $game->created_at->diffForHumans() }}
                                        </span>
                                        
                                        {{-- Nền tảng  --}}
                                        @if(!empty($game->platforms))
                                            <span class="text-xs bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-gray-600 dark:text-gray-300">
                                                {{ $game->platforms[0] ?? 'Game' }}
                                            </span>
                                        @endif
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