<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Mirai Store</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Logic Dark Mode giữ nguyên
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
            }
        </script>
    </head>
    
    <body class="font-sans text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100 antialiased flex flex-col min-h-screen transition-colors duration-300"
          x-data="{ 
              notifications: [],
              add(message, type = 'success') {
                  const id = Date.now();
                  this.notifications.push({ id, message, type });
                  setTimeout(() => {
                      this.notifications = this.notifications.filter(n => n.id !== id);
                  }, 3000); // Tự tắt sau 3 giây
              }
          }"
          @notify.window="add($event.detail.message, $event.detail.type)"
    >
        
        <x-shop-header />

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <x-footer />

        {{-- KHU VỰC HIỂN THỊ THÔNG BÁO (TOAST NOTIFICATION) --}}
        <div class="fixed top-24 right-5 z-[99] space-y-3 pointer-events-none">
            {{-- 1. Hiển thị thông báo từ PHP Session (Redirect) --}}
            @if (session('success'))
                <div x-init="add('{{ session('success') }}', 'success')"></div>
            @endif
            @if (session('error'))
                <div x-init="add('{{ session('error') }}', 'error')"></div>
            @endif

            {{-- 2. Render danh sách thông báo (Dùng cho cả PHP và AJAX) --}}
            <template x-for="notif in notifications" :key="notif.id">
                <div x-show="true"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-10"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-x-10"
                     class="pointer-events-auto relative w-80 max-w-full rounded-xl p-4 shadow-lg border-l-4 flex items-start gap-3 backdrop-blur-md"
                     :class="{
                        'bg-white/90 dark:bg-gray-800/90 border-green-500 text-green-600 dark:text-green-400': notif.type === 'success',
                        'bg-white/90 dark:bg-gray-800/90 border-red-500 text-red-600 dark:text-red-400': notif.type === 'error',
                        'bg-white/90 dark:bg-gray-800/90 border-blue-500 text-blue-600 dark:text-blue-400': notif.type === 'info'
                     }"
                >
                    {{-- Icon --}}
                    <div class="flex-shrink-0 pt-0.5">
                        <i class="fa-solid" :class="{
                            'fa-circle-check': notif.type === 'success',
                            'fa-circle-xmark': notif.type === 'error',
                            'fa-circle-info': notif.type === 'info'
                        }"></i>
                    </div>

                    {{-- Nội dung --}}
                    <div class="flex-1">
                        <h4 class="font-bold text-sm" x-text="notif.type === 'success' ? 'Thành công' : (notif.type === 'error' ? 'Lỗi' : 'Thông báo')"></h4>
                        <p class="text-sm text-gray-600 dark:text-white-300 mt-1" x-text="notif.message"></p>
                    </div>

                    {{-- Nút tắt --}}
                    <button @click="notifications = notifications.filter(n => n.id !== notif.id)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </template>
        </div>

    </body>
</html>