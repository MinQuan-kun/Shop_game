<x-app-layout>
    {{-- Phần Header & Breadcrumb --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        {{-- SỬA TẠI ĐÂY: Thêm 'text-black' --}}
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
    Thêm Thể Loại
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
                        Thể loại /
                    </a>
                </li>
                <li class="font-medium text-primary">Thêm mới</li>
            </ol>
        </nav>
    </div>

    {{-- Phần Form --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            {{-- Tên danh mục --}}
            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-black dark:text-white">
                    Tên thể loại <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" placeholder="VD: Hành động, Nhập vai, Kinh dị..." required
                    class="w-full rounded-lg border border-gray-300 bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary dark:border-gray-700 dark:text-white" />
            </div>

            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-black dark:text-white">
                    Mô tả
                </label>
                <textarea name="description" rows="3" placeholder="Mô tả ngắn..."
                    class="w-full rounded-lg border border-gray-300 bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary dark:border-gray-700 dark:text-white"></textarea>
            </div>

            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Kích hoạt ngay</span>
                </label>
            </div>

            <button type="submit"
                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90">
                Lưu Thể Loại
            </button>
        </form>
    </div>
</x-app-layout>
