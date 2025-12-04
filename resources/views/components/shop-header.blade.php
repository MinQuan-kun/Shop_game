<header class="sticky top-0 z-50 w-full bg-white/90 backdrop-blur border-b border-miku-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-miku-500 rounded-full flex items-center justify-center text-white font-bold">
                        M
                    </div>
                    <span class="font-bold text-xl text-gray-800 tracking-wide">MIRAI<span
                            class="text-miku-500">STORE</span></span>
                </a>
            </div>

            <nav class="hidden md:flex space-x-8">
                <a href="/"
                    class="text-gray-600 hover:text-miku-500 font-medium transition duration-150 ease-in-out">Trang
                    chủ</a>
                <a href="#"
                    class="text-gray-600 hover:text-miku-500 font-medium transition duration-150 ease-in-out">Cửa
                    hàng</a>
                <a href="#"
                    class="text-gray-600 hover:text-miku-500 font-medium transition duration-150 ease-in-out">Cộng
                    đồng</a>
                <a href="#"
                    class="text-gray-600 hover:text-miku-500 font-medium transition duration-150 ease-in-out">Hỗ trợ</a>
            </nav>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-miku-500 font-medium">Đăng nhập</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-miku-500 text-white rounded-full hover:bg-miku-600 transition shadow-md shadow-miku-200">
                        Đăng ký
                    </a>
                @endauth
            </div>
            <div class="flex items-center space-x-4">

                <button onclick="toggleTheme()"
                    class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 focus:outline-none transition-colors duration-200">
                    <svg class="w-6 h-6 hidden dark:block text-yellow-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>

                    <svg class="w-6 h-6 block dark:hidden text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                </button>
                @auth
                @else
                @endauth
            </div>
        </div>
    </div>
</header>
