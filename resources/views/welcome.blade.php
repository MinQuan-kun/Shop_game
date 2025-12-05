<x-shop-layout>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">

        <x-banner />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col lg:flex-row gap-8">

                <div class="w-full lg:w-9/12">
                    <div class="flex items-center justify-between mb-6 border-l-4 border-miku-500 pl-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wider">Game Mới
                        </h2>
                        <a href="#" class="text-sm text-miku-600 dark:text-miku-400 hover:underline">Xem tất cả <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach (range(1, 9) as $i)
                            <div
                                class="group bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md dark:shadow-lg border border-gray-200 dark:border-gray-700 hover:border-miku-500 transition duration-300">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="https://picsum.photos/seed/{{ $i * 123 }}/400/300"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </div>
                                <div class="p-4">
                                    <h3
                                        class="text-lg font-bold text-gray-900 dark:text-white leading-snug mb-2 group-hover:text-miku-600 dark:group-hover:text-miku-400 transition">
                                        <a href="#">ELDEN RING NIGHTREIGN</a>
                                    </h3>
                                    <div
                                        class="text-sm text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-3">
                                        <span><i class="fa-solid fa-calendar-days mr-1"></i> 2 giờ trước</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full lg:w-3/12 space-y-8">
                    <div
                        class="bg-white dark:bg-gray-800 p-5 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3
                            class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-600 pb-2">
                            Tìm Kiếm</h3>
                        <form class="relative">
                            <input type="text" placeholder="Nhập tên game..."
                                class="w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-4 focus:ring-miku-500">
                        </form>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 p-5 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3
                            class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-600 pb-2">
                            Thể Loại</h3>
                        <ul class="space-y-2">
                            @foreach (['Hành động', 'Nhập vai', 'Chiến thuật', 'Thể thao'] as $cate)
                                <li>
                                    <a href="#"
                                        class="block text-gray-600 dark:text-gray-300 hover:text-miku-600 dark:hover:text-miku-400 hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded transition">
                                        <i class="fa-solid fa-caret-right text-miku-500 mr-2"></i> {{ $cate }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 relative h-64 flex items-center justify-center group cursor-pointer shadow-sm transition-colors duration-300">

                        <img src="https://i.pinimg.com/736x/b2/24/49/b224497559194d2f0eb3528b6d396489.jpg"
                            class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-70 transition duration-500">

                        <div class="relative z-10 text-center p-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Tham gia Discord</h3>

                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Nhận link tải tốc độ cao & hỗ trợ
                                cài đặt</p>

                            <span
                                class="inline-block bg-[#5865F2] text-white px-4 py-2 rounded font-bold hover:bg-[#4752c4] transition shadow-md">
                                <i class="fa-brands fa-discord mr-1"></i> Join Now
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>
