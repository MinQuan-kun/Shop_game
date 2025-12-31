<x-app-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Thêm Thể Loại Mới
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-gray-500 hover:text-black dark:text-white" href="{{ route('dashboard') }}">
                        Dashboard /
                    </a>
                </li>
                <li>
                    <a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('admin.categories.index') }}">
                        Categories /
                    </a>
                </li>
                <li class="font-medium text-black dark:text-white">Create</li>
            </ol>
        </nav>
    </div>

    {{-- Form Container --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-default dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-7 py-4 dark:border-gray-800">
            <h3 class="font-medium text-black dark:text-white">
                Thông tin thể loại
            </h3>
        </div>

        <div class="p-7">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <div class="w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" for="name">
                            Tên thể loại <span class="text-red-500">*</span>
                        </label>
                        <input
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            type="text" name="name" id="name" placeholder="Ví dụ: Indie, Hành động..."
                            required />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5.5">
                    <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="description">
                        Mô tả
                    </label>
                    <textarea
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        name="description" id="description" rows="5" placeholder="Mô tả ngắn gọn về thể loại..."></textarea>
                </div>

                <div
                    class="mt-8 flex items-center justify-end gap-x-6 border-t border-gray-100 pt-6 dark:border-gray-800">
                    <a href="{{ route('admin.categories.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                        Hủy bỏ
                    </a>

                    {{-- Nút Lưu: Nhỏ gọn, màu đen/trắng đảo chiều --}}
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Lưu thể loại
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
