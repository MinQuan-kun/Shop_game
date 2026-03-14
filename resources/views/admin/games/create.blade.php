<x-app-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Thêm Game Mới
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
                        href="{{ route('admin.games.index') }}">
                        Games /
                    </a>
                </li>
                <li class="font-medium text-primary">Thêm mới</li>
            </ol>
        </nav>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                {{-- Cột Trái --}}
                <div>
                    {{-- Tên Game --}}
                    <div class="mb-4">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Tên Game <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-lg border border-gray-300 bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary dark:border-gray-700 dark:text-white" />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Danh mục --}}
                    <div class="mb-4">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Danh mục <span
                                class="text-red-500">*</span></label>
                        <select name="category_id" required
                            class="w-full rounded-lg border border-gray-300 bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary dark:border-gray-700 dark:text-white dark:bg-gray-800">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Giá tiền --}}
                    <div class="mb-4">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Giá bán (VNĐ) <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price', 0) }}" min="0" required
                            class="w-full rounded-lg border border-gray-300 bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary dark:border-gray-700 dark:text-white" />
                        <p class="text-xs text-gray-500 mt-1">Nhập 0 nếu là game miễn phí.</p>
                    </div>
                </div>

                {{-- Cột Phải --}}
                <div>
                    {{-- Ảnh bìa --}}
                    <div class="mb-4">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Ảnh bìa Game <span
                                class="text-red-500">*</span></label>
                        <input type="file" name="image" accept="image/*" required
                            class="w-full cursor-pointer rounded-lg border border-gray-300 bg-transparent font-medium text-gray-500 file:mr-4 file:cursor-pointer file:border-0 file:bg-primary file:py-3 file:px-5 file:text-white hover:file:bg-opacity-90 dark:border-gray-700 dark:text-gray-400" />
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link tải --}}
                    <div class="mb-4">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Link tải Game (Google
                            Drive/Fshare) <span class="text-red-500">*</span></label>
                        <input type="url" name="download_link" value="{{ old('download_link') }}"
                            placeholder="https://..."
                            class="w-full rounded-lg border border-gray-300 bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary dark:border-gray-700 dark:text-white" />
                        <p class="text-xs text-gray-500 mt-1">Link này chỉ hiện cho người đã mua.</p>
                    </div>

                    {{-- Trạng thái --}}
                    <div class="mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-success-500">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Đang bán (Hiển
                                thị)</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Mô tả (Full width) --}}
            <div class="mb-6">
                <label class="mb-2.5 block font-medium text-black dark:text-white">Mô tả chi tiết</label>
                <textarea name="description" rows="5"
                    class="w-full rounded-lg border border-gray-300 bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary dark:border-gray-700 dark:text-white">{{ old('description') }}</textarea>
            </div>

            <button type="submit"
                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90">
                Lưu Game Mới
            </button>
        </form>
    </div>
</x-app-layout>
