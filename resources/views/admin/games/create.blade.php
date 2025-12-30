<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<x-app-layout>
    {{-- Header & Breadcrumb: Tinh tế và thoáng đãng --}}
    <div class="mb-7 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Thêm Game Mới
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Cập nhật đầy đủ thông tin để thu hút người chơi</p>
        </div>

        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="text-gray-500 hover:text-black dark:hover:text-white transition-colors"
                        href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="text-gray-400">/</li>
                <li><a class="text-gray-500 hover:text-black dark:hover:text-white transition-colors"
                        href="{{ route('admin.games.index') }}">Games</a></li>
                <li class="text-gray-400">/</li>
                <li class="font-semibold text-gray-900 dark:text-white">Thêm mới</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Cột Trái: Thông tin chính --}}
            <div class="lg:col-span-2 space-y-8">
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="mb-6 border-b border-gray-100 pb-4 dark:border-gray-800">
                        <h3 class="font-bold text-gray-800 dark:text-white">Thông tin cơ bản</h3>
                    </div>

                    <div class="space-y-6">
                        {{-- Tên Game --}}
                        <div>
                            <label class="mb-2.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">Tên sản
                                phẩm <span class="text-red-500">*</span></label>
                            <input type="text" name="name" placeholder="Ví dụ: God of War Ragnarök" required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-5 text-black outline-none transition focus:border-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white" />
                        </div>

                        {{-- Thể loại (Multi-select) --}}
                        <div class="sm:col-span-2">
                            <label class="mb-2.5 block text-sm font-semibold text-gray-700 dark:text-white">
                                Thể loại <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="category_select" name="category_ids[]" multiple
                                    placeholder="Chọn một hoặc nhiều thể loại..." autocomplete="off" required
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-5 text-black outline-none transition focus:border-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Mô tả --}}
                        <div>
                            <label class="mb-2.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">Mô tả sản
                                phẩm</label>
                            <textarea name="description" rows="6" placeholder="Viết giới thiệu hấp dẫn về game..."
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-5 text-black outline-none transition focus:border-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cột Phải: Giá, Ảnh & Trạng thái --}}
            <div class="space-y-8">
                {{-- Box Giá & Link --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="space-y-6">
                        <div>
                            <label class="mb-2.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">Giá bán
                                (VNĐ) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" placeholder="500000" required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-5 font-bold text-gray-900 outline-none focus:border-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
                        </div>

                        <div>
                            <label class="mb-2.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">Đường dẫn
                                tải game</label>
                            <input type="text" name="download_link" placeholder="Google Drive, Mega..."
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-5 text-sm outline-none focus:border-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
                        </div>
                    </div>
                </div>

                {{-- Box Ảnh đại diện --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
                    <label class="mb-4 block text-sm font-semibold text-gray-700 dark:text-gray-300">Ảnh bìa (Thumbnail)
                        <span class="text-red-500">*</span></label>
                    <div
                        class="group relative flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 py-8 text-center transition hover:border-gray-900 dark:border-gray-700 dark:hover:border-white">
                        <svg class="mb-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <polyline points="21 15 16 10 5 21" />
                        </svg>
                        <input type="file" name="image" required
                            class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0" />
                        <p class="text-xs text-gray-500">Kéo thả hoặc nhấp để chọn ảnh</p>
                    </div>
                </div>

                {{-- Box Trạng thái --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="block text-sm font-semibold text-gray-700 dark:text-white">Mở bán ngay</span>
                            <span class="text-[11px] text-gray-500 italic text-success-500">Game sẽ hiển thị trên trang
                                chủ</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div
                                class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-success-500 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700">
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Thanh điều hướng & Nút bấm dưới cùng --}}
        <div class="mt-10 flex items-center justify-between border-t border-gray-100 pt-8 dark:border-gray-800">
            <a href="{{ route('admin.games.index') }}"
                class="text-sm font-semibold text-gray-500 hover:text-black dark:text-gray-400 dark:hover:text-white transition-all underline underline-offset-4">
                Quay lại danh sách
            </a>

            <div class="flex gap-8 items-center">
                <button type="reset" class="text-sm font-medium text-gray-400 hover:text-red-500 transition-colors">
                    Làm mới form
                </button>

                {{-- Nút Lưu chuẩn mẫu bạn muốn: Nhỏ, màu Đen/Trắng --}}
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-6 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 active:scale-95">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Lưu sản phẩm
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
