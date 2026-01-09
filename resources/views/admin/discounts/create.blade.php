<x-admin-layout>
    <div class="p-6">
        <div class="mb-6">
            <a href="{{ route('admin.discounts.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                <i class="fa-solid fa-arrow-left mr-2"></i>Quay lại danh sách
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                <i class="fa-solid fa-tag mr-2 text-blue-500"></i>
                Tạo mã giảm giá mới
            </h1>

            <form action="{{ route('admin.discounts.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Code --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mã giảm giá <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="code" value="{{ old('code') }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white uppercase focus:ring-2 focus:ring-blue-500"
                            placeholder="VD: GAME10">
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Loại giảm giá <span class="text-red-500">*</span>
                        </label>
                        <select name="type" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Phần trăm (%)
                            </option>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Cố định (VNĐ)</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Value --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Giá trị <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="value" value="{{ old('value') }}" min="0" step="0.01"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                            placeholder="VD: 10 hoặc 50000">
                        @error('value')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Nhập % nếu chọn phần trăm, nhập số tiền nếu chọn cố định
                        </p>
                    </div>

                    {{-- Expires At --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ngày hết hạn <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="expires_at" value="{{ old('expires_at') }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @error('expires_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Usage Limit --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Giới hạn sử dụng (tùy chọn)
                        </label>
                        <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                            placeholder="Để trống nếu không giới hạn">
                        @error('usage_limit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Số lần tối đa mã có thể được sử dụng
                        </p>
                    </div>

                    {{-- Is Active --}}
                    <div x-data="{ switcherToggle: {{ old('is_active') ? 'true' : 'false' }} }">
                        <label
                            class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 dark:text-gray-400">
                            <span>Trạng thái kích hoạt</span>
                            <div class="relative">
                                <input type="checkbox" name="is_active" value="1" class="sr-only"
                                    x-model="switcherToggle" />
                                <div class="block h-6 w-11 rounded-full duration-300"
                                    :class="switcherToggle ? 'bg-blue-600' : 'bg-gray-200 dark:bg-white/10'"></div>
                                <div :class="switcherToggle ? 'translate-x-full' : 'translate-x-0'"
                                    class="absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300">
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                        <i class="fa-solid fa-save mr-2"></i>Tạo mã giảm giá
                    </button>
                    <a href="{{ route('admin.discounts.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
