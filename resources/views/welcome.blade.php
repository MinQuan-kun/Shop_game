<x-shop-layout>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">

        <div class="relative w-full h-[500px] lg:h-[600px] overflow-hidden group bg-gray-900">

            <div class="absolute inset-0 w-full h-full bg-cover bg-center transform group-hover:scale-105 transition-transform duration-[2000ms] ease-in-out"
                style="background-image: url('https://images.hdqwalls.com/wallpapers/hatsune-miku-fantasy-art-4k-y6.jpg');">
            </div>

            <div
                class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-miku-900/30 mix-blend-multiply">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 to-transparent"></div>


            <div class="relative z-10 h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
                <div class="max-w-2xl animate-fade-in-up">
                    <div
                        class="inline-flex items-center gap-2 bg-miku-500/20 border border-miku-500/50 rounded-full px-3 py-1 mb-4 backdrop-blur-sm">
                        <span class="flex h-2 w-2 relative justify-center items-center">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-miku-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-miku-500"></span>
                        </span>
                        <span class="text-miku-300 text-xs font-bold uppercase tracking-widest">Chào mừng đến với tương
                            lai</span>
                    </div>

                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 leading-tight drop-shadow-lg">
                        Thế Giới Game <br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-miku-400 to-blue-400 filter drop-shadow-[0_0_10px_rgba(57,197,187,0.5)]">
                            Không Giới Hạn
                        </span>
                    </h1>

                    <p class="text-lg text-gray-300 mb-8 leading-relaxed font-medium drop-shadow-md">
                        Tải xuống hàng ngàn tựa game bom tấn bản quyền với tốc độ ánh sáng. Tham gia cộng đồng Gaming
                        Kai và chinh phục mọi thử thách ngay hôm nay.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="#"
                            class="group relative inline-flex items-center justify-center px-8 py-3 font-bold text-white bg-miku-500 rounded-full overflow-hidden shadow-lg shadow-miku-500/30 transition-all duration-300 hover:bg-miku-600 hover:scale-105 hover:shadow-miku-500/50">
                            <span
                                class="absolute inset-0 w-full h-full bg-gradient-to-br from-miku-400 to-miku-600 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            <span class="relative flex items-center gap-2">
                                Khám Phá Ngay <i class="fa-solid fa-rocket group-hover:animate-bounce"></i>
                            </span>
                        </a>

                        <a href="#"
                            class="inline-flex items-center justify-center px-8 py-3 font-bold text-white border-2 border-gray-400/50 bg-gray-900/30 backdrop-blur-sm rounded-full transition-all duration-300 hover:bg-white hover:text-gray-900 hover:border-white">
                            Xem Cộng Đồng <i class="fa-brands fa-discord ml-2"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>

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
                                        <a href="#">Elden Ring: Shadow of Miku</a>
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
