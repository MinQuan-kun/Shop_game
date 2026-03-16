<x-app-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Chỉnh sửa thể loại: {{ $category->name }}
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('dashboard') }}">
                        Dashboard /
                    </a>
                </li>
                <li>
                    <a class="font-medium text-gray-500 hover:text-black dark:text-white"
                        href="{{ route('admin.categories.index') }}">
                        Categories /
                    </a>
                </li>
                <li class="font-medium text-black dark:text-white">Edit</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="space-y-4">
                {{-- Tên thể loại --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tên thể loại</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-black dark:text-white focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900" />
                </div>

                {{-- Mô tả --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Mô tả</label>
                    <textarea name="description" rows="4" 
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-black dark:text-white dark:border-gray-700 dark:bg-gray-900">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-4 border-t border-gray-100 pt-6 dark:border-gray-800">
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-gray-300 px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                    Hủy bỏ
                </a>
                <button type="submit" class="rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition">
                    Lưu thay đổi
                </button>
            </div>
        </div>
    </form>
</x-app-layout>