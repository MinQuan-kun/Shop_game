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
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($games as $game)
                                <x-game-card :title="$game->name" :price="$game->price_format" :image="str_starts_with($game->image, 'http')
                                    ? $game->image
                                    : asset('storage/' . $game->image)" :category="optional($game->category)->name ?? 'Game'" />
                            @endforeach
                        </div>

                        {{-- Phân trang --}}
                        <div class="mt-10">
                            {{ $games->links() }}
                        </div>
                    @else
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
