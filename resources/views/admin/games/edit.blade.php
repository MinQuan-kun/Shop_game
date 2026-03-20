@if ($errors->any())
    <div class="mb-6 rounded-lg bg-red-50 p-4 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
        <div class="flex items-center gap-3 mb-2">
            <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-sm font-semibold text-red-800 dark:text-red-400">
                Có lỗi xảy ra, vui lòng kiểm tra lại:
            </h3>
        </div>
        <ul class="list-inside list-disc text-xs text-red-700 dark:text-red-400 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-admin-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Chỉnh sửa Game: {{ $game->name }}
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
                        href="{{ route('admin.games.index') }}">
                        Games /
                    </a>
                </li>
                <li class="font-medium text-black dark:text-white">Edit</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('admin.games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                {{-- Thông tin cơ bản --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="mb-5 text-base font-medium text-gray-800 dark:text-white/90">Thông tin cơ bản</h3>

                    <div class="space-y-4">
                        {{-- Tên Game --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tên
                                Game</label>
                            <input type="text" name="name" value="{{ old('name', $game->name) }}" required
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-black dark:text-white focus:border-brand-500 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Giá bán --}}
                        <div x-data="{ isFree: {{ $game->price == 0 ? 'true' : 'false' }}, price: '{{ old('price', $game->price) }}' }">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Giá Game
                                    (VNĐ)</label>
                                <label
                                    class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                    <span>Miễn phí</span>
                                    <div class="relative">
                                        <input type="checkbox" class="sr-only" x-model="isFree"
                                            @change="if(isFree) price = 0" />
                                        <div class="block h-6 w-11 rounded-full duration-300"
                                            :class="isFree ? 'bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
                                        <div :class="isFree ? 'translate-x-full' : 'translate-x-0'"
                                            class="absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 shadow-sm">
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <input type="number" name="price" x-model="price" :readonly="isFree"
                                class="w-full rounded-lg border px-4 py-2.5 text-sm transition-all"
                                :class="isFree ? 'bg-gray-100 dark:bg-gray-800 opacity-60' :
                                    'bg-transparent text-black dark:text-white border-gray-300 dark:border-gray-700'" />
                        </div>

                        {{-- Nhà sản xuất --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nhà sản
                                xuất</label>
                            <input type="text" name="publisher"
                                value="{{ old('publisher', $game->publisher ?? '') }}" required
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-black dark:text-white dark:border-gray-700 dark:bg-gray-900" />
                        </div>

                        {{-- Thể loại --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Thể loại
                            </label>
                            <div
                                class="flex flex-wrap items-center gap-x-6 gap-y-4 rounded-lg border border-gray-300 dark:border-gray-700 p-4 bg-transparent">
                                @foreach ($categories as $category)
                                    @php
                                        // Lấy danh sách ID đã chọn từ session (nếu có lỗi validate) hoặc từ database
                                        $selectedCategories = old('category_ids', $game->category_ids ?? []);
                                    @endphp
                                    <div x-data="{ catToggle: {{ in_array($category->_id, $selectedCategories) ? 'true' : 'false' }} }">
                                        <label
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                            <div class="relative">
                                                <input type="checkbox" name="category_ids[]"
                                                    value="{{ $category->_id }}" class="sr-only"
                                                    @change="catToggle = !catToggle"
                                                    {{ in_array($category->_id, $selectedCategories) ? 'checked' : '' }} />

                                                <div :class="catToggle ? 'border-brand-500 bg-brand-500' :
                                                    'border-gray-300 dark:border-gray-700'"
                                                    class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px] duration-200">
                                                    <span :class="catToggle ? '' : 'opacity-0'">
                                                        <svg width="10" height="10" viewBox="0 0 14 14"
                                                            fill="none">
                                                            <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('category_ids')" class="mt-2" />
                        </div>

                        {{-- Nền tảng --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nền
                                tảng</label>
                            <div
                                class="flex flex-wrap items-center gap-x-6 gap-y-4 rounded-lg border border-gray-300 dark:border-gray-700 p-4">
                                @php $platforms = ['PC', 'Android', 'iOS', 'PlayStation', 'Xbox', 'Switch']; @endphp
                                @foreach ($platforms as $platform)
                                    <div x-data="{ platToggle: {{ is_array(old('platforms', $game->platforms)) && in_array($platform, old('platforms', $game->platforms ?? [])) ? 'true' : 'false' }} }">
                                        <label
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                            <div class="relative">
                                                <input type="checkbox" name="platforms[]" value="{{ $platform }}"
                                                    class="sr-only" @change="platToggle = !platToggle"
                                                    {{ is_array(old('platforms', $game->platforms)) && in_array($platform, old('platforms', $game->platforms ?? [])) ? 'checked' : '' }} />
                                                <div :class="platToggle ? 'border-brand-500 bg-brand-500' :
                                                    'border-gray-300 dark:border-gray-700'"
                                                    class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px] duration-200">
                                                    <span :class="platToggle ? '' : 'opacity-0'"><svg width="10"
                                                            height="10" viewBox="0 0 14 14" fill="none">
                                                            <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg></span>
                                                </div>
                                            </div>
                                            {{ $platform }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Ngôn ngữ --}}
                        <div x-data="{
                            selectedLanguages: [],
                            showOtherInput: false,
                            toggleOther() {
                                this.showOtherInput = this.selectedLanguages.includes('Khác');
                            }
                        }">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ngôn
                                ngữ</label>

                            <div
                                class="flex flex-wrap items-center gap-x-6 gap-y-4 rounded-lg border border-gray-300 dark:border-gray-700 p-4 bg-transparent">
                                @foreach (['Tiếng Anh', 'Tiếng Việt', 'Khác'] as $lang)
                                    <label
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <div class="relative">
                                            <input type="checkbox" name="languages[]" value="{{ $lang }}"
                                                class="sr-only" x-model="selectedLanguages" @change="toggleOther()">
                                            <div :class="selectedLanguages.includes('{{ $lang }}') ?
                                                'border-brand-500 bg-brand-500' :
                                                'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px] duration-200">
                                                <span
                                                    :class="selectedLanguages.includes('{{ $lang }}') ? '' :
                                                        'opacity-0'">
                                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        {{ $lang }}
                                    </label>
                                @endforeach
                            </div>

                            <div x-show="showOtherInput" x-transition class="mt-3">
                                <input type="text" name="other_language" placeholder="Nhập ngôn ngữ khác..."
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm dark:border-gray-700 dark:bg-gray-900" />
                            </div>
                        </div>

                        {{-- Mô tả --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Mô
                                tả</label>
                            <textarea name="description" rows="5"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-black dark:text-white dark:border-gray-700 dark:bg-gray-900">{{ old('description', $game->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Link tải --}}
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="mb-5 text-base font-medium text-gray-800 dark:text-white/90">Liên kết tải game</h3>
                    <div class="relative">
                        <span
                            class="absolute top-1/2 left-0 -translate-y-1/2 border-r border-gray-200 px-3 text-gray-500 dark:border-gray-800">http://</span>
                        <input type="url" name="download_link"
                            value="{{ old('download_link', $game->download_link) }}" placeholder="www.example.com"
                            class="w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[90px] pr-4 text-sm text-black dark:text-white dark:border-gray-700 dark:bg-gray-900" />
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Ảnh đại diện --}}
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="p-5 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Ảnh đại diện</h3>
                    </div>
                    <div class="p-5">
                        <div x-data="{ photoPreview: '{{ $game->image }}' }" class="text-center">
                            {{-- Input file ẩn đi --}}
                            <input type="file" name="image" class="hidden" x-ref="photoInput"
                                @change="const file = $el.files[0]; if(file){ const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); } " />

                            {{-- Khung hiển thị ảnh --}}
                            <div
                                class="relative group mx-auto mb-4 h-64 w-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700 flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-gray-900">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="h-full w-full object-contain" />
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-gray-400 text-sm">Chưa có ảnh</div>
                                </template>

                                {{-- Overlay khi di chuột vào ảnh --}}
                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <button type="button" @click="$refs.photoInput.click()"
                                        class="text-white bg-brand-500 hover:bg-brand-600 px-4 py-2 rounded-lg text-sm font-medium transition">
                                        Chọn ảnh mới
                                    </button>
                                </div>
                            </div>

                            {{-- NÚT BẤM THAY ĐỔI ẢNH BÊN DƯỚI --}}
                            <button type="button" @click="$refs.photoInput.click()"
                                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] transition-all w-full justify-center">
                                <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20">
                                    <path
                                        d="M10 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm0-10c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z" />
                                    <path d="M10 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                                    <path
                                        d="M17 4h-3.17l-1.83-2H8L6.17 4H3c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 12H3V6h3.41l1.83-2h3.52l1.83 2H17v10z" />
                                </svg>
                                Thay đổi ảnh
                            </button>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- Trạng thái --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div x-data="{ switcherToggle: {{ $game->is_active ? 'true' : 'false' }} }">
                        <label
                            class="flex cursor-pointer items-center justify-between text-sm font-medium text-gray-700 dark:text-gray-400">
                            <span>Trạng thái kích hoạt</span>
                            <div class="relative">
                                <input type="checkbox" name="is_active" class="sr-only" x-model="switcherToggle"
                                    {{ $game->is_active ? 'checked' : '' }} />
                                <div class="block h-6 w-11 rounded-full duration-300"
                                    :class="switcherToggle ? 'bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
                                <div :class="switcherToggle ? 'translate-x-full' : 'translate-x-0'"
                                    class="absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300"></div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Nút hành động --}}
                <div class="flex flex-col gap-3">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition shadow-sm">
                        Cập nhật Game
                    </button>
                    <a href="{{ route('admin.games.index') }}"
                        class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700 hover:bg-gray-50 transition">
                        Hủy bỏ
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>
