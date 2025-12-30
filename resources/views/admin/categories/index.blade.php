<x-app-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Quản lý Thể Loại
        </h2>
        <a href="{{ route('admin.categories.create') }}" 
           class="inline-flex items-center justify-center rounded-full bg-primary py-3 px-10 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
           + Thêm Thể Loại
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 text-red-800 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-50 text-left dark:bg-gray-800">
                        <th class="px-4 py-3 font-medium text-black dark:text-white">Tên Thể Loại</th>
                        <th class="px-4 py-3 font-medium text-black dark:text-white">Slug</th>
                        <th class="px-4 py-3 font-medium text-black dark:text-white">Số Game</th>
                        <th class="px-4 py-3 font-medium text-black dark:text-white">Trạng thái</th>
                        <th class="px-4 py-3 font-medium text-black dark:text-white">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-4 py-4 dark:text-white font-medium ">{{ $category->name }}</td>
                            <td class="px-4 py-4 text-gray-500 text-sm">{{ $category->slug }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $category->games->count() }} games
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                @if($category->is_active)
                                    <span class="text-success-600 dark:text-success-400 text-sm font-medium">Hiển thị</span>
                                @else
                                    <span class="text-gray-400 text-sm">Đang ẩn</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-primary hover:underline">Sửa</a>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Xóa danh mục này?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:underline">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>