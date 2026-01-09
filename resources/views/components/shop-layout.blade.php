<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mirai Store</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Logic Dark Mode giữ nguyên
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
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

{{-- SỬA: Thêm activeModal: null vào x-data --}}

<body
    class="font-sans text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100 antialiased flex flex-col min-h-screen transition-colors duration-300"
    x-data="{
        activeModal: null,
        notifications: [],
        add(message, type = 'success') {
            const id = Date.now();
            this.notifications.push({ id, message, type });
            setTimeout(() => {
                this.notifications = this.notifications.filter(n => n.id !== id);
            }, 3000); // Tự tắt sau 3 giây
        }
    }" @notify.window="add($event.detail.message, $event.detail.type)">

    <x-shop-header />

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-footer />

    {{-- === KHU VỰC POPUP MODALS === --}}

    {{-- 1. MODAL TRUNG TÂM TRỢ GIÚP --}}
    <div x-show="activeModal === 'help'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        style="display: none;">

        <div @click.outside="activeModal = null"
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] overflow-y-auto relative">

            {{-- Header --}}
            <div
                class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center sticky top-0 bg-white dark:bg-gray-800 z-10">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-headset text-miku-500"></i> Trung Tâm Trợ Giúp
                </h3>
                <button @click="activeModal = null" class="text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- Content --}}
            <div class="p-6 space-y-6">
                <div class="relative">
                    <input type="text" placeholder="Bạn cần giúp gì? (VD: Quên mật khẩu...)"
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border-none rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-miku-500">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button
                        class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition text-left flex flex-col gap-2">
                        <i class="fa-solid fa-key text-2xl"></i>
                        <span class="font-bold text-sm">Lấy lại mật khẩu</span>
                    </button>
                    <button
                        class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/40 transition text-left flex flex-col gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-2xl"></i>
                        <span class="font-bold text-sm">Báo lỗi nạp tiền</span>
                    </button>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-3">Gửi yêu cầu hỗ trợ</h4>
                    <textarea
                        class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-miku-500 dark:text-white"
                        rows="3" placeholder="Mô tả vấn đề của bạn..."></textarea>
                    <button
                        class="mt-3 w-full py-2 bg-miku-500 hover:bg-miku-600 text-white font-bold rounded-lg transition">
                        Gửi yêu cầu
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. MODAL CHÍNH SÁCH BẢO MẬT --}}
    <div x-show="activeModal === 'privacy'" x-transition.opacity
        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        style="display: none;">
        <div @click.outside="activeModal = null"
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[80vh] overflow-y-auto relative">
            <div
                class="p-6 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">🔒 Chính Sách Bảo Mật</h3>
                <button @click="activeModal = null" class="text-gray-400 hover:text-red-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-8 prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                <p><strong>1. Thu thập thông tin:</strong> Chúng tôi chỉ thu thập thông tin cần thiết (Email, Tên) để xử
                    lý đơn hàng.</p>
                <p><strong>2. Bảo mật dữ liệu:</strong> Mọi thông tin thanh toán đều được mã hóa và xử lý qua cổng thanh
                    toán đối tác (VNPAY/Momo), chúng tôi không lưu trữ thông tin thẻ.</p>
                <p><strong>3. Chia sẻ thông tin:</strong> Cam kết không bán hoặc chia sẻ thông tin cá nhân cho bên thứ 3
                    dưới mọi hình thức.</p>
                <p><strong>4. Cookie:</strong> Website sử dụng cookie để lưu trạng thái đăng nhập và giỏ hàng của bạn.
                </p>
            </div>
            <div class="p-6 border-t border-gray-100 dark:border-gray-700 text-right">
                <button @click="activeModal = null"
                    class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white rounded-lg font-bold hover:bg-gray-300 transition">
                    Đã hiểu
                </button>
            </div>
        </div>
    </div>

    {{-- 3. MODAL ĐIỀU KHOẢN DỊCH VỤ --}}
    <div x-show="activeModal === 'terms'" x-transition.opacity
        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        style="display: none;">
        <div @click.outside="activeModal = null"
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[80vh] overflow-y-auto relative">
            <div
                class="p-6 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">📜 Điều Khoản Dịch Vụ</h3>
                <button @click="activeModal = null" class="text-gray-400 hover:text-red-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-8 prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                <p><strong>1. Quy định chung:</strong> Khi mua hàng tại Mirai Store, bạn đồng ý với các quy định về
                    thanh toán và nhận game.</p>
                <p><strong>2. Hoàn tiền:</strong> Chỉ chấp nhận hoàn tiền trong vòng 24h nếu nhận game bị lỗi do hệ
                    thống. Không hoàn tiền nếu bạn đổi ý hoặc máy không đủ cấu hình.</p>
                <p><strong>3. Hành vi cấm:</strong> Nghiêm cấm sử dụng tài khoản hack/cheat hoặc gian lận thanh toán.
                </p>
            </div>
            <div class="p-6 border-t border-gray-100 dark:border-gray-700 text-right">
                <button @click="activeModal = null"
                    class="px-6 py-2 bg-miku-500 text-white rounded-lg font-bold hover:bg-miku-600 transition">
                    Đồng ý
                </button>
            </div>
        </div>
    </div>

    {{-- KHU VỰC HIỂN THỊ THÔNG BÁO (TOAST NOTIFICATION) --}}
    <div class="fixed top-24 right-5 z-[99] space-y-3 pointer-events-none">

        {{-- 1. Hiển thị thông báo từ PHP Session --}}
        @if (session('success'))
            <div x-init="add('{{ session('success') }}', 'success')"></div>
        @endif
        @if (session('error'))
            <div x-init="add('{{ session('error') }}', 'error')"></div>
        @endif

        {{-- 2. Render danh sách thông báo --}}
        <template x-for="notif in notifications" :key="notif.id">
            <div x-show="true" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-10"
                class="pointer-events-auto relative w-80 max-w-full rounded-xl p-4 shadow-lg border-l-4 flex items-start gap-3 backdrop-blur-md"
                :class="{
                    'bg-white/90 dark:bg-gray-800/90 border-green-500 text-green-600 dark:text-green-400': notif
                        .type === 'success',
                    'bg-white/90 dark:bg-gray-800/90 border-red-500 text-red-600 dark:text-red-400': notif
                        .type === 'error',
                    'bg-white/90 dark:bg-gray-800/90 border-blue-500 text-blue-600 dark:text-blue-400': notif
                        .type === 'info'
                }">

                {{-- Icon --}}
                <div class="flex-shrink-0 pt-0.5">
                    <i class="fa-solid"
                        :class="{
                            'fa-circle-check': notif.type === 'success',
                            'fa-circle-xmark': notif.type === 'error',
                            'fa-circle-info': notif.type === 'info'
                        }"></i>
                </div>

                {{-- Nội dung --}}
                <div class="flex-1">
                    <h4 class="font-bold text-sm"
                        x-text="notif.type === 'success' ? 'Thành công' : (notif.type === 'error' ? 'Lỗi' : 'Thông báo')">
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1" x-text="notif.message"></p>
                </div>

                {{-- Nút tắt --}}
                <button @click="notifications = notifications.filter(n => n.id !== notif.id)"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </template>
    </div>
    <x-chatbot />
</body>

</html>
