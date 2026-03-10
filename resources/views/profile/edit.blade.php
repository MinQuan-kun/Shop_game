<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mirai Store') }} - Hồ sơ cá nhân</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1f2937; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #6b7280; }
        [x-cloak] { display: none !important; }
        
        /* Input Disabled Style giống React */
        input:disabled {
            background-color: rgba(17, 24, 39, 0.5); /* bg-gray-900/50 */
            color: #9ca3af; /* text-gray-400 */
            cursor: not-allowed;
            border-color: #374151; /* border-gray-700 */
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#0b1121] text-gray-100">

    <x-shop-header />

    <main class="min-h-screen pt-12 pb-20 px-4" 
          x-data="{ activeTab: 'info', rewardsTab: 'available' }">
        
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- === CỘT TRÁI: SIDEBAR === --}}
            <div class="lg:col-span-3">
                <div class="bg-[#151f32] rounded-2xl p-6 border border-gray-700 shadow-xl text-center sticky top-24">
                    
                    <div class="relative w-32 h-32 mx-auto mb-4 group">
                        <div class="w-full h-full rounded-full overflow-hidden border-4 border-gray-700 shadow-lg relative bg-gray-800">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=128" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @endif
                            
                            <label class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center cursor-pointer z-10">
                                <div class="flex flex-col items-center text-white">
                                    <i class="fas fa-camera text-2xl mb-1"></i>
                                    <span class="text-xs font-bold">Đổi ảnh</span>
                                </div>
                                <input type="file" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-white mb-1">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-400 mb-6 truncate">{{ $user->email }}</p>

                    <div class="space-y-2">
                        <button @click="activeTab = 'info'" 
                                :class="activeTab === 'info' ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/40' : 'hover:bg-gray-700/50 text-gray-400 hover:text-gray-200'"
                                class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-medium">
                            <i class="fas fa-user w-5 text-center"></i> Thông tin cá nhân
                        </button>

                        <button @click="activeTab = 'history'" 
                                :class="activeTab === 'history' ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/40' : 'hover:bg-gray-700/50 text-gray-400 hover:text-gray-200'"
                                class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-medium">
                            <i class="fas fa-history w-5 text-center"></i> Game đã mua
                        </button>

                        <button @click="activeTab = 'reviews'" 
                                :class="activeTab === 'reviews' ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/40' : 'hover:bg-gray-700/50 text-gray-400 hover:text-gray-200'"
                                class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-medium">
                            <i class="fas fa-star w-5 text-center"></i> Lịch sử nạp
                        </button>

                        <button @click="activeTab = 'rewards'" 
                                :class="activeTab === 'rewards' ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/40' : 'hover:bg-gray-700/50 text-gray-400 hover:text-gray-200'"
                                class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition font-medium">
                            <i class="fas fa-gift w-5 text-center"></i> Donate
                        </button>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-6 pt-6 border-t border-gray-700">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300 font-medium text-sm flex items-center justify-center gap-2 w-full transition">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>

            {{-- === CỘT PHẢI: NỘI DUNG CHÍNH === --}}
            <div class="lg:col-span-9">
                <div class="bg-[#151f32] rounded-2xl p-6 md:p-8 border border-gray-700 shadow-xl min-h-[600px]">

                    {{-- TAB 1: THÔNG TIN CÁ NHÂN (Đã bỏ Card điểm) --}}
                    <div x-show="activeTab === 'info'" 
                         x-transition:enter="transition ease-out duration-300 transform" 
                         x-transition:enter-start="opacity-0 translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0">
                        
                        <div x-data="{ isEditing: {{ $errors->any() ? 'true' : 'false' }} }">
                            <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
                                <h3 class="text-2xl font-bold text-white">Thông Tin Cá Nhân</h3>
                                <button type="button" x-show="!isEditing" @click="isEditing = true" class="text-sm bg-blue-600/10 text-blue-400 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition border border-blue-600/30 font-bold">
                                    <i class="fas fa-pen mr-2"></i> Chỉnh sửa
                                </button>
                            </div>

                            <form method="post" action="{{ route('profile.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @csrf @method('patch')

                                <div class="space-y-2">
                                    <label class="text-gray-400 text-sm font-medium">Họ và tên</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                           :disabled="!isEditing" 
                                           class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 focus:border-orange-500 outline-none text-white transition-all">
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2 space-y-2">
                                    <label class="text-gray-400 text-sm font-medium">Email (Không thể thay đổi)</label>
                                    <input type="email" value="{{ $user->email }}" disabled 
                                           class="w-full bg-gray-900/30 border border-gray-800 rounded-xl px-4 py-3 text-gray-500 font-mono">
                                </div>
                                
                                <div class="md:col-span-2 bg-gray-900/30 p-5 rounded-xl border border-gray-800 mt-2" 
                                     x-show="isEditing" x-transition>
                                    <p class="text-orange-500 text-sm mb-4 font-bold uppercase tracking-wider">
                                        <i class="fas fa-lock mr-2"></i> Đổi mật khẩu (Tùy chọn)
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-gray-400 text-sm font-medium">Mật khẩu mới</label>
                                            <input type="password" name="password" placeholder="Nhập mật khẩu mới..." 
                                                   class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 focus:border-orange-500 outline-none text-white">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-gray-400 text-sm font-medium">Xác nhận mật khẩu</label>
                                            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu..." 
                                                   class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 focus:border-orange-500 outline-none text-white">
                                        </div>
                                    </div>
                                    @if($errors->updatePassword->any())
                                        <div class="mt-2 text-red-500 text-sm">
                                            {{ $errors->updatePassword->first() }}
                                        </div>
                                    @endif
                                </div>

                                <div class="md:col-span-2 flex justify-end gap-3 mt-4 pt-4 border-t border-gray-700" 
                                     x-show="isEditing" x-transition>
                                    <button type="button" @click="isEditing = false" 
                                            class="px-6 py-2.5 rounded-xl bg-gray-700 hover:bg-gray-600 transition font-bold text-gray-300">
                                        Hủy bỏ
                                    </button>
                                    <button type="submit" 
                                            class="px-8 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-500 transition font-bold text-white shadow-lg shadow-orange-900/40 transform active:scale-95">
                                        Lưu thay đổi
                                    </button>
                                </div>
                            </form>
                            
                            @if (session('status') === 'profile-updated')
                                <div class="mt-4 p-4 bg-green-900/20 border border-green-800 rounded-xl text-green-400 flex items-center gap-3">
                                    <i class="fas fa-check-circle text-xl"></i>
                                    <span class="font-medium">Cập nhật thông tin thành công!</span>
                                </div>
                            @endif

                            <div class="mt-12 pt-8 border-t border-gray-800 flex justify-center">
                                <button @click="$dispatch('open-modal', 'confirm-user-deletion')"
                                        class="text-red-500 hover:text-red-400 text-sm font-medium flex items-center gap-2 transition opacity-60 hover:opacity-100">
                                    <i class="fas fa-trash-alt"></i> Xóa tài khoản vĩnh viễn
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 2: Game đã mua --}}


                    {{-- TAB 3: Lịch sử nạp --}}


                    {{-- TAB 4: Donate --}}


                </div>
            </div>
        </div>
    </main>

    <x-footer />
    
    {{-- MODAL XÓA TÀI KHOẢN --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#1f2937] text-white border border-gray-700">
            @csrf
            @method('delete')
            <h2 class="text-lg font-medium text-white">{{ __('Bạn có chắc chắn muốn xóa tài khoản?') }}</h2>
            <p class="mt-1 text-sm text-gray-400">{{ __('Hành động này không thể hoàn tác. Vui lòng nhập mật khẩu để xác nhận.') }}</p>
            <div class="mt-6">
                <input id="password" name="password" type="password" placeholder="Mật khẩu" class="mt-1 block w-3/4 bg-gray-900 border border-gray-600 rounded-lg px-4 py-2 text-white focus:border-orange-500 outline-none" />
                @if($errors->userDeletion->has('password'))
                    <span class="text-red-400 text-sm mt-2 block">{{ $errors->userDeletion->first('password') }}</span>
                @endif
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-600 rounded-lg text-white font-medium hover:bg-gray-500">{{ __('Hủy') }}</button>
                <button type="submit" class="px-4 py-2 bg-red-600 rounded-lg text-white font-medium shadow-lg hover:bg-red-500">{{ __('Xóa tài khoản') }}</button>
            </div>
        </form>
    </x-modal>

</body>
</html>