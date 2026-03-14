<x-app-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Quản lý Game
        </h2>
        
        <a href="{{ route('admin.games.create') }}" 
           class="inline-flex items-center justify-center gap-2.5 rounded-full bg-primary py-4 px-10 text-center font-medium text-black dark:text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
            <span>
                <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 11H7V13H11V17H13V13H17V11H13V7H11V11Z" fill="" />
                </svg>
            </span>
            Thêm Game
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Thành công!</span> {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-6">
            <div class="max-w-full overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800">
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase text-xs">Game Info</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase text-xs">Danh mục</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase text-xs">Giá bán</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase text-xs">Lượt mua</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase text-xs">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($games as $game)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                {{-- Game Info --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-14 w-14 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                            @if ($game->image)
                                                <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full bg-gray-100 flex items-center justify-center text-xs text-gray-500">No Img</div>
                                            @endif
                                        </div>
                                        <div>
                                            <h5 class="font-semibold text-black dark:text-white">{{ $game->name }}</h5>
                                            <span class="text-xs text-gray-500">{{ $game->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Danh mục --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $game->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                {{-- Giá --}}
                                <td class="px-5 py-4 font-medium text-success-600 dark:text-success-400">
                                    {{ $game->price_format }}
                                </td>

                                {{-- Sold Count --}}
                                <td class="px-5 py-4 text-sm text-gray-500">
                                    {{ $game->sold_count }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center space-x-3">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.games.edit', $game->id) }}" class="text-gray-500 hover:text-primary transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa game này?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-500 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $games->links() }}
            </div>
        </div>
    </div>
</x-app-layout>