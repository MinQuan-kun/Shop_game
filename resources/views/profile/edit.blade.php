<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-black py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden mb-6">
                <div class="h-32 bg-gradient-to-r from-miku-400 to-blue-500"></div>
                
                <div class="px-6 pb-6">
                    <div class="flex flex-col sm:flex-row items-end -mt-12 mb-4 gap-4">
                        <div class="relative">
                            <img class="h-24 w-24 rounded-full ring-4 ring-white dark:ring-gray-900 object-cover bg-white" 
                                 src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                                 alt="{{ Auth::user()->name }}">
                            <div class="absolute bottom-0 right-0 h-5 w-5 bg-green-500 border-4 border-white dark:border-gray-900 rounded-full" title="Online"></div>
                        </div>
                        
                        <div class="flex-1 text-center sm:text-left">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        </div>

                        <button class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Đổi Avatar
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <div class="lg:col-span-1 space-y-6">
                    <nav class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-2">
                        <a href="#profile-info" class="flex items-center gap-3 px-4 py-3 bg-miku-50 dark:bg-miku-900/20 text-miku-600 dark:text-miku-400 font-medium rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Thông tin chung
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 19.464a2.5 2.5 0 01-1.768.732 3 3 0 01-2.121-.879l-.879-.879a3 3 0 01-.879-2.121 2.5 2.5 0 01.732-1.768L12.257 11.257a6 6 0 115.743-7.743z"></path></svg>
                            Bảo mật
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Lịch sử mua hàng
                        </a>
                    </nav>

                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase mb-4">Thống kê</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Ngày tham gia</span>
                                <span class="text-gray-900 dark:text-white font-medium text-sm">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Game sở hữu</span>
                                <span class="text-gray-900 dark:text-white font-medium text-sm">0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Hạng thành viên</span>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded">Đồng</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 space-y-6">
                    
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8">
                        <div class="max-w-xl">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Thông tin tài khoản') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Cập nhật thông tin hồ sơ và địa chỉ email của tài khoản.") }}
                                </p>
                            </header>
                            
                            <div class="mt-6">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8">
                        <div class="max-w-xl">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Đổi mật khẩu') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Đảm bảo tài khoản của bạn đang sử dụng một mật khẩu dài và ngẫu nhiên để giữ an toàn.") }}
                                </p>
                            </header>

                            <div class="mt-6">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8">
                        <div class="max-w-xl">
                            <header>
                                <h2 class="text-lg font-medium text-red-600 dark:text-red-400">
                                    {{ __('Xóa tài khoản') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Khi tài khoản bị xóa, tất cả tài nguyên và dữ liệu sẽ bị xóa vĩnh viễn.") }}
                                </p>
                            </header>

                            <div class="mt-6">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>