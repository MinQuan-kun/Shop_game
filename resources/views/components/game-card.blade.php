@props(['title', 'price', 'image', 'category'])

<div class="group relative bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <div class="aspect-w-16 aspect-h-9 w-full overflow-hidden bg-gray-200 group-hover:opacity-75 h-48">
        <img src="{{ $image }}" alt="{{ $title }}" class="h-full w-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500">
    </div>

    <div class="p-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-medium text-miku-500 mb-1">{{ $category }}</p>
                <h3 class="text-lg font-bold text-gray-900">
                    <a href="#">
                        <span aria-hidden="true" class="absolute inset-0"></span>
                        {{ $title }}
                    </a>
                </h3>
            </div>
        </div>
        
        <div class="mt-4 flex items-center justify-between">
            <p class="text-lg font-bold text-gray-900">{{ $price }}</p>
            <div class="rounded-full bg-miku-50 p-2 text-miku-500 group-hover:bg-miku-500 group-hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
        </div>
    </div>
</div>