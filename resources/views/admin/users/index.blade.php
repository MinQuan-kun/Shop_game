<x-app-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            User Management
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li class="font-medium text-primary">Users</li>
            </ol>
        </nav>
    </div>
    <div class="space-y-5 sm:space-y-6">
        
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    List of Users
                </h3>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2.5 rounded-full bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-6">
                    <span>+ Add User</span>
                </a>
            </div>

            <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="max-w-full overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-5 py-3 sm:px-6 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">User</p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Role</p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Joined Date</p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-right">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
                                    </th>
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($users as $user)
                                <tr>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 overflow-hidden rounded-full">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $user->name }}" />
                                            </div>
                                            <div>
                                                <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                    {{ $user->name }}
                                                </span>
                                                <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                                    {{ $user->email }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{-- Giả sử bạn có cột role hoặc check isAdmin --}}
                                            {{ $user->role ?? 'Member' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                                Active
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                {{ $user->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 sm:px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-white">
                                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.17812 8.99981 3.17812C14.5686 3.17812 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.49043 10.0406 4.8233 13.1344 8.99981 13.1344C13.1763 13.1344 15.5092 10.0406 16.1436 8.99999C15.5092 7.95936 13.1763 4.86562 8.99981 4.86562C4.8233 4.86562 2.49043 7.95936 1.85605 8.99999Z" fill=""/>
                                                    <path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z" fill=""/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500 ml-2">
                                                   <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.7531 2.47502H11.5875V1.9969C11.5875 1.15315 10.9125 0.478149 10.0687 0.478149H7.90312C7.05937 0.478149 6.38437 1.15315 6.38437 1.9969V2.47502H4.21875C3.40312 2.47502 2.72812 3.15002 2.72812 3.96565V4.8094C2.72812 5.42815 3.09375 5.9344 3.62812 6.1594L4.07812 15.4688C4.13437 16.6219 5.09062 17.5219 6.24375 17.5219H11.7281C12.8812 17.5219 13.8375 16.6219 13.8937 15.4688L14.3437 6.1594C14.8781 5.9344 15.2437 5.42815 15.2437 4.8094V3.96565C15.2437 3.15002 14.5687 2.47502 13.7531 2.47502ZM7.67812 1.9969C7.67812 1.85627 7.79062 1.74377 7.93125 1.74377H10.0406C10.1812 1.74377 10.2937 1.85627 10.2937 1.9969V2.47502H7.67812V1.9969ZM11.2781 15.6656H6.69375L6.24375 6.3844H11.7281L11.2781 15.6656ZM13.9781 4.8094C13.9781 4.9219 13.8937 5.00627 13.7812 5.00627H4.19062C4.07812 5.00627 3.99375 4.9219 3.99375 4.8094V3.96565C3.99375 3.85315 4.07812 3.76877 4.19062 3.76877H13.7812C13.8937 3.76877 13.9781 3.85315 13.9781 3.96565V4.8094Z" fill=""/>
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
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        </div>
</x-app-layout>