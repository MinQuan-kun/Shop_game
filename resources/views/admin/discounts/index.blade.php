<x-admin-layout>
    <div class="p-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <span class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-xl text-blue-600 dark:text-blue-400">
                    <i class="fa-solid fa-tags text-xl"></i>
                </span>
                Quản lý mã giảm giá
            </h1>
            <a href="{{ route('admin.discounts.create') }}"
                class="group flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-lg hover:shadow-blue-500/30 active:scale-95">
                <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
                <span>Tạo mã mới</span>
            </a>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center justify-between animate-fade-in-down">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-green-700 dark:text-green-400 hover:opacity-75">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Table Container --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mã giảm giá</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Loại</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Giá trị</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hạn sử dụng</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lượt dùng</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($discounts as $discount)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                {{-- Code --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-gray-100 dark:bg-gray-700 p-2 rounded-lg text-gray-500 dark:text-gray-400">
                                            <i class="fa-solid fa-ticket"></i>
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white font-mono tracking-wide">
                                            {{ $discount->code }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Type --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($discount->type === 'percentage')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-success-100 text-success-800 dark:bg-success-900/30 dark:text-success-300 border border-success-200 dark:border-success-800">
                                            <i class="fa-solid fa-percent text-[10px]"></i> Phần trăm
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                            <i class="fa-solid fa-tag text-[10px]"></i> Cố định
                                        </span>
                                    @endif
                                </td>

                                {{-- Value --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                                        @if($discount->type === 'percentage')
                                            {{ floatval($discount->value) }}%
                                        @else
                                            {{ number_format($discount->value, 0, ',', '.') }} đ
                                        @endif
                                    </span>
                                </td>

                                {{-- Expires --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($discount->expires_at)
                                        <div class="flex items-center gap-2 text-sm {{ $discount->isValid() ? 'text-gray-600 dark:text-gray-300' : 'text-red-500 dark:text-red-400' }}">
                                            <i class="fa-regular fa-clock"></i>
                                            {{ $discount->expires_at->format('d/m/Y') }}
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Không giới hạn</span>
                                    @endif
                                </td>

                                {{-- Usage --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            @php
                                                $percent = $discount->usage_limit > 0 ? ($discount->used_count / $discount->usage_limit) * 100 : 0;
                                            @endphp
                                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                            {{ $discount->used_count }} / {{ $discount->usage_limit ?? '∞' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Status Switcher (AJAX w/ Alpine) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div x-data="{ 
                                            active: {{ $discount->is_active ? 'true' : 'false' }}, 
                                            loading: false,
                                            toggle() {
                                                if(this.loading) return;
                                                this.loading = true;
                                                const originalState = this.active;
                                                this.active = !this.active; // Optimistic UI update
                                                
                                                fetch('{{ route('admin.discounts.toggle', $discount->id) }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    }
                                                })
                                                .then(res => res.json())
                                                .then(data => {
                                                    this.loading = false;
                                                    if(!data.success) this.active = originalState; // Revert if fail
                                                })
                                                .catch(() => {
                                                    this.loading = false;
                                                    this.active = originalState; // Revert if error
                                                });
                                            }
                                        }">
                                        
                                        <div @click="toggle()" class="cursor-pointer relative inline-flex items-center group">
                                            {{-- Track --}}
                                            <div class="w-11 h-6 rounded-full transition-colors duration-300 ease-in-out"
                                                :class="active ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-600 group-hover:bg-gray-300 dark:group-hover:bg-gray-500'">
                                            </div>
                                            
                                            {{-- Thumb --}}
                                            <div class="absolute left-[2px] w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-300 ease-in-out transform"
                                                :class="active ? 'translate-x-full' : 'translate-x-0'">
                                                {{-- Loading Spinner (Optional) --}}
                                                <i x-show="loading" class="fa-solid fa-circle-notch fa-spin text-[10px] text-blue-500 absolute inset-0 m-auto"></i>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.discounts.edit', $discount->id) }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white transition-all"
                                            title="Chỉnh sửa">
                                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                                        </a>

                                        <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này không? Hành động này không thể hoàn tác.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white transition-all"
                                                title="Xóa">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="flex flex-col items-center justify-center py-16 text-center">
                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-full mb-4">
                                            <i class="fa-solid fa-ticket text-4xl text-gray-300 dark:text-gray-500"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Chưa có mã giảm giá nào</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4 text-sm">Hãy tạo mã giảm giá đầu tiên để thu hút khách hàng.</p>
                                        <a href="{{ route('admin.discounts.create') }}"
                                            class="text-blue-600 dark:text-blue-400 hover:underline font-medium text-sm">
                                            Tạo mã giảm giá mới &rarr;
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if($discounts->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $discounts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>