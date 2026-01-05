<x-admin-layout>
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
                <li class="font-medium text-black dark:text-white">Create</li>
            </ol>
        </nav>
    </div>

    @if ($errors->any())
        <div
            class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-error-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-error-500">Phát hiện lỗi nhập liệu:</h3>
                    <div class="mt-2 text-sm text-error-500/80">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if (session('success'))
        <div
            class="flex w-full rounded-lg border-l-[6px] border-green-500 bg-green-500/5 px-7 py-8 shadow-md dark:bg-[#1b1b24] md:p-9 mb-6">
            <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-green-500">
                <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401837 14.3238 0.400754 13.9657 0.794406L5.91888 9.53011L2.05606 5.28116C1.69149 4.88028 1.071 4.87423 0.69834 5.26763C0.325329 5.66139 0.330881 6.28723 0.710041 6.67443L5.24736 11.3053C5.42152 11.4831 5.66103 11.584 5.91231 11.584C6.16359 11.584 6.40309 11.4831 6.57726 11.3053L15.2917 1.83988C15.6565 1.44431 15.6601 0.821361 15.2984 0.826822Z"
                        fill="white" stroke="white" />
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-3 text-lg font-bold text-[#004434] dark:text-[#beffec]">
                    Thành công!
                </h5>
                <p class="leading-relaxed text-[#637381] dark:text-[#beffec]/80">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="mb-5 text-base font-medium text-gray-800 dark:text-white/90">Thông tin cơ bản</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Tên Game
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-black dark:text-white border-gray-300 focus:border-brand-500 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Giá bán với nút gạt Miễn phí --}}
                        <div x-data="{ isFree: false, price: '{{ old('price') }}' }">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Giá Game (VNĐ)
                                </label>

                                <label
                                    class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                    <span>Miễn phí</span>

                                    <div class="relative">
                                        {{-- Cập nhật x-model thành isFree để đồng bộ với ô nhập giá --}}
                                        <input type="checkbox" name="is_free" id="price_toggle" class="sr-only"
                                            x-model="isFree" @change="if(isFree) price = 0" />

                                        {{-- Thanh trượt --}}
                                        <div class="block h-6 w-11 rounded-full duration-300"
                                            :class="isFree ? 'bg-brand-500' : 'bg-gray-200 dark:bg-white/10'">
                                        </div>

                                        {{-- Nút tròn --}}
                                        <div :class="isFree ? 'translate-x-full' : 'translate-x-0'"
                                            class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear">
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <input type="number" name="price" x-model="price" :readonly="isFree"
                                class="w-full rounded-lg border px-4 py-2.5 text-sm transition-all duration-200"
                                :class="isFree
                                    ?
                                    'bg-gray-100 dark:bg-gray-800 cursor-not-allowed opacity-60 border-gray-200 dark:border-gray-700 text-gray-500' :
                                    'bg-transparent border-gray-300 dark:border-gray-700 text-black dark:text-white focus:border-brand-500 focus:ring-brand-500/10'" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Thể loại
                            </label>
                            <div
                                class="flex flex-wrap items-center gap-x-6 gap-y-4 rounded-lg border border-gray-300 dark:border-gray-700 p-4 bg-transparent">
                                @foreach ($categories as $category)
                                    <div x-data="{ catToggle: {{ is_array(old('category_ids')) && in_array($category->_id, old('category_ids')) ? 'true' : 'false' }} }">
                                        <label for="cat_{{ $category->_id }}"
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                            <div class="relative">
                                                <input type="checkbox" name="category_ids[]"
                                                    id="cat_{{ $category->_id }}" value="{{ $category->_id }}"
                                                    class="sr-only" @change="catToggle = !catToggle"
                                                    {{ is_array(old('category_ids')) && in_array($category->_id, old('category_ids')) ? 'checked' : '' }} />

                                                <div :class="catToggle ? 'border-brand-500 bg-brand-500' :
                                                    'bg-transparent border-gray-300 dark:border-gray-700'"
                                                    class="hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px] duration-200">
                                                    <span :class="catToggle ? '' : 'opacity-0'">
                                                        <svg width="14" height="14" viewBox="0 0 14 14"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                                stroke="currentColor" stroke-width="1.94437"
                                                                stroke-linecap="round" stroke-linejoin="round" />
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

                        {{-- Nhà sản xuất --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-white/90">
                                Nhà sản xuất
                            </label>

                            <input type="text" name="publisher" value="{{ old('publisher') }}" required
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm transition-all duration-200 text-black border-gray-300 focus:border-brand-500 focus:ring-brand-500/10 dark:text-white dark:border-gray-700 dark:bg-gray-900 dark:focus:border-brand-500" />

                            <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                        </div>

                        {{-- Nền tảng --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nền tảng
                            </label>
                            <div
                                class="flex flex-wrap items-center gap-x-6 gap-y-4 rounded-lg border border-gray-300 dark:border-gray-700 p-4 bg-transparent">
                                @php
                                    $platforms = ['PC', 'Android', 'iOS', 'PlayStation', 'Xbox', 'Switch'];
                                @endphp

                                @foreach ($platforms as $platform)
                                    <div x-data="{ platformToggle: false }">
                                        <label for="platform_{{ $loop->index }}"
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                            <div class="relative">
                                                <input type="checkbox" name="platforms[]"
                                                    id="platform_{{ $loop->index }}" value="{{ $platform }}"
                                                    class="sr-only" @change="platformToggle = !platformToggle" />

                                                <div :class="platformToggle ? 'border-brand-500 bg-brand-500' :
                                                    'bg-transparent border-gray-300 dark:border-gray-700'"
                                                    class="hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px] duration-200">
                                                    <span :class="platformToggle ? '' : 'opacity-0'">
                                                        <svg width="14" height="14" viewBox="0 0 14 14"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                                stroke="currentColor" stroke-width="1.94437"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            {{ $platform }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('platforms')" class="mt-2" />
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
                                                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="currentColor"
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

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-black dark:text-white">Mô
                                tả</label>
                            <textarea name="description" rows="5"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm transition-all duration-200 text-black border-gray-300 focus:border-brand-500 focus:ring-brand-500/10 dark:text-white dark:border-gray-700 dark:bg-gray-900 dark:focus:border-brand-500">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="mb-5 text-base font-medium text-gray-800 dark:text-white/90">Đường dẫn & Liên kết tải
                        game</h3>
                    <div class="relative">
                        <span
                            class="absolute top-1/2 left-0 inline-flex h-11 -translate-y-1/2 items-center justify-center border-r border-gray-200 py-3 pr-3 pl-3.5 text-gray-500 dark:border-gray-800 dark:text-gray-400">
                            http://
                        </span>
                        <input type="url" name="download_link" value="{{ old('download_link') }}"
                            placeholder="www.example.com"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[90px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    </div>
                </div>
            </div>
            {{-- Nhập ảnh game với Dropzone --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Ảnh đại diện
                    </h3>
                </div>
                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <div x-data="{
                        isDropping: false,
                        photoPreview: null,
                        handleFile(file) {
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = (e) => { this.photoPreview = e.target.result; };
                            reader.readAsDataURL(file);
                        },
                        removePhoto() {
                            this.photoPreview = null;
                            $refs.photoInput.value = '';
                        }
                    }" class="relative">

                        {{-- Drop Zone Container --}}
                        <div class="relative rounded-xl border-2 border-dashed transition-all duration-200 min-h-[200px] flex items-center justify-center overflow-hidden"
                            :class="isDropping ? 'border-brand-500 bg-brand-500/5' :
                                'border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900'"
                            @dragover.prevent="isDropping = true" @dragleave.prevent="isDropping = false"
                            @drop.prevent="
                    isDropping = false;
                    if ($event.dataTransfer.files.length) {
                        $refs.photoInput.files = $event.dataTransfer.files;
                        handleFile($event.dataTransfer.files[0]);
                    }
                ">

                            <input type="file" name="image" class="hidden" x-ref="photoInput" accept="image/*"
                                @change="handleFile($el.files[0])" />

                            {{-- Trạng thái chưa có ảnh --}}
                            <div class="text-center p-6" x-show="!photoPreview">
                                <div class="mb-4 flex justify-center">
                                    <div @click="$refs.photoInput.click()"
                                        class="cursor-pointer flex h-16 w-16 items-center justify-center rounded-full bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-300 dark:hover:bg-gray-700 transition">
                                        <svg class="fill-current" width="28" height="28" viewBox="0 0 29 28">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M14.5019 3.91699C14.2852 3.91699 14.0899 4.00891 13.953 4.15589L8.57363 9.53186C8.28065 9.82466 8.2805 10.2995 8.5733 10.5925C8.8661 10.8855 9.34097 10.8857 9.63396 10.5929L13.7519 6.47752V18.667C13.7519 19.0812 14.0877 19.417 14.5019 19.417C14.9161 19.417 15.2519 19.0812 15.2519 18.667V6.48234L19.3653 10.5929C19.6583 10.8857 20.1332 10.8855 20.426 10.5925C20.7188 10.2995 20.7186 9.82463 20.4256 9.53184L15.0838 4.19378C14.9463 4.02488 14.7367 3.91699 14.5019 3.91699ZM5.91626 18.667C5.91626 18.2528 5.58047 17.917 5.16626 17.917C4.75205 17.917 4.41626 18.2528 4.41626 18.667V21.8337C4.41626 23.0763 5.42362 24.0837 6.66626 24.0837H22.3339C23.5766 24.0837 24.5839 23.0763 24.5839 21.8337V18.667C24.5839 18.2528 24.2482 17.917 23.8339 17.917C23.4197 17.917 23.0839 18.2528 23.0839 18.667V21.8337C23.0839 22.2479 22.7482 22.5837 22.3339 22.5837H6.66626C6.25205 22.5837 5.91626 22.2479 5.91626 21.8337V18.667Z" />
                                        </svg>
                                    </div>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-white/90">Kéo thả ảnh vào đây
                                </h4>
                                <p class="mt-1 text-xs text-gray-500">hoặc <span @click="$refs.photoInput.click()"
                                        class="text-brand-500 cursor-pointer hover:underline font-medium">Chọn
                                        file</span></p>
                            </div>

                            {{-- Trạng thái đã có ảnh xem trước --}}
                            <div x-show="photoPreview" class="group relative w-full h-full p-2">
                                <img :src="photoPreview"
                                    class="max-h-80 w-full object-contain rounded-lg shadow-sm bg-white dark:bg-gray-800">

                                {{-- Overlay khi hover vào ảnh --}}
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/40 rounded-lg">
                                    <div class="flex gap-3">
                                        {{-- Nút thay đổi ảnh --}}
                                        <button type="button" @click="$refs.photoInput.click()"
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-gray-900 hover:bg-brand-500 hover:text-white transition-colors shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </button>
                                        {{-- Nút xóa ảnh --}}
                                        <button type="button" @click="removePhoto()"
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 transition-colors shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </div>
            </div>

            {{-- Trạng thái hiển thị --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <div x-data="{ switcherToggle: true }">
                    <label for="is_active_toggle"
                        class="flex cursor-pointer items-center justify-between text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                        <span>Trạng thái kích hoạt</span>

                        <div class="relative">
                            <input type="checkbox" name="is_active" id="is_active_toggle" class="sr-only"
                                value="1" x-model="switcherToggle" @change="switcherToggle = $el.checked" />

                            {{-- Thanh trượt --}}
                            <div class="block h-6 w-11 rounded-full duration-300"
                                :class="switcherToggle ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'">
                            </div>

                            {{-- Nút tròn --}}
                            <div :class="switcherToggle ? 'translate-x-full' : 'translate-x-0'"
                                class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear">
                            </div>
                        </div>
                    </label>
                    <p class="mt-2 text-xs text-gray-500">Nếu tắt, game sẽ không hiển thị ngoài trang chủ.</p>
                </div>
            </div>
        </div>
        </div>

        <div class="mt-8 flex items-center justify-end gap-x-6 border-t border-gray-100 pt-6 dark:border-gray-800">
            <a href="{{ route('admin.games.index') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                Hủy bỏ
            </a>

            <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Lưu Game
            </button>
        </div>
    </form>
</x-admin-layout>
