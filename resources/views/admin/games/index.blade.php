<x-admin-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Quản lý Game
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-gray-500 hover:text-black dark:text-white" href="{{ route('dashboard') }}">
                        Dashboard /
                    </a>
                </li>
                <li class="font-medium text-black dark:text-white">Games</li>
            </ol>
        </nav>
    </div>

    {{-- Khối danh sách --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-6 flex justify-between items-center border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-xl font-bold text-black dark:text-white">
                Danh sách game
            </h3>
            <div class="flex items-center gap-4">
                <span
                    class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                    Tổng: {{ $games->total() }} game
                </span>
                <a href="{{ route('admin.games.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Thêm Game
                </a>
            </div>
        </div>


        <div class="p-6">
            <div class="max-w-full overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-white/5">
                            <th class="px-5 py-3 sm:px-6">
                                <p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Game info
                                </p>
                            </th>

                            <th class="px-5 py-3 sm:px-6">
                                <p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Hình ảnh
                                </p>
                            </th>

                            <th class="px-5 py-3 sm:px-6">
                                <p class="text-left font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Thể loại
                                </p>
                            </th>
                            <th class="px-5 py-3 sm:px-6 text-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Giá tiền
                                </p>
                            </th>
                            <th class="px-5 py-3 sm:px-6 text-right">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Thao tác
                                </p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($games as $game)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-6 py-4">
                                    <h5 class="font-semibold text-black dark:text-white">
                                        {{ $game->name }}
                                    </h5>

                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        {{ Str::limit($game->description, 100, '...') }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-2 italic">
                                        Đăng bởi: {{ $game->publisher }}
                                    </p>

                                </td>

                                <td class="px-5 py-4">
                                    <div
                                        class="h-12 w-12 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                        @if ($game->image)
                                            <img src="{{ $game->image }}" alt="{{ $game->name }}"
                                                class="h-full w-full object-cover">
                                        @else
                                            <div
                                                class="flex h-full w-full items-center justify-center text-[10px] text-gray-400">
                                                No Img</div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if (!empty($game->category_ids) && is_array($game->category_ids))
                                            @foreach ($game->category_ids as $catId)
                                                @php
                                                    $category = \App\Models\Category::find($catId);
                                                @endphp
                                                @if ($category)
                                                    <span
                                                        class="inline-flex items-center justify-center gap-1 rounded-full bg-gray-800 px-2.5 py-0.5 text-sm font-medium text-white dark:bg-white/15 dark:text-white">
                                                        {{ $category->name }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-xs italic text-gray-400 dark:text-gray-500">Chưa phân
                                                loại</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($game->price == 0)
                                        <span
                                            class="inline-block rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-black dark:text-black">
                                            Miễn phí
                                        </span>
                                    @else
                                        <span
                                            class="inline-block rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-200 dark:text-blue-900">
                                            {{ number_format($game->price, 0, ',', '.') }} VND
                                        </span>
                                    @endif
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end space-x-3">
                                        {{-- Nút Sửa --}}
                                        <a href="{{ route('admin.games.edit', $game->id) }}"
                                            class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-primary dark:text-gray-400 dark:hover:bg-white/10 transition-all"
                                            title="Chỉnh sửa">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z">
                                                </path>
                                            </svg>
                                        </a>

                                        {{-- Nút Xóa --}}
                                        <form id="delete-game-form-{{ $game->id }}"
                                            action="{{ route('admin.games.destroy', $game->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                onclick="confirmDeleteGame('{{ $game->id }}', '{{ $game->name }}')"
                                                class="p-2 rounded-full text-gray-500 hover:bg-red-50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-red-500/10 transition-all"
                                                title="Xóa Game">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="mt-6">
                {{ $games->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

<script>
    function confirmDeleteGame(gameId, gameName) {
        Swal.fire({
            title: 'Xóa game này?',
            text: `Bạn có chắc muốn xóa game "${gameName}" không? Hành động này không thể hoàn tác!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Vâng, xóa nó!',
            cancelButtonText: 'Hủy bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-game-form-' + gameId).submit();
            }
        })
    }
</script>
