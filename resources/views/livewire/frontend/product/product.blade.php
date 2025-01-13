<div class="flex flex-col items-center py-10 min-h-screen px-4 sm:px-6 md:px-10">
    <h3
        class="text-center mt-2 mb-7 text-4xl font-extrabold underline decoration-indigo-500 leading-none text-gray-700 md:text-4xl lg:text-1xl">
        Produk
    </h3>

    {{-- Pencarian --}}
    <div class="relative w-full max-w-3xl mb-6">
        <input type="text" wire:model.lazy="search"
            class="w-full p-4 pl-12 pr-4 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="Masukan kata kunci lalu enter.." />
        <button type="submit" class="absolute inset-y-0 left-0 flex items-center px-3 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>

    </div>
    <a wire:loading wire:target='search' class="text-secondary mb-3">
        Mencari...
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-gray-800 animate-spin"
            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="#E5E7EB" />
            <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentColor" />
        </svg>
    </a>

    <!-- Content Products -->
    <div wire:init="loadInitialProducts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-7xl">
        @forelse ($products as $product)

        <div
            class="bg-white border border-gray-200 rounded-lg shadow transition-transform transform hover:scale-105 h-full flex flex-col">
            @php
            $images = is_string($product->image) ? json_decode($product->image, true) : $product->image;
            @endphp

            @if ($images && is_array($images) && count($images) > 1)
            <!-- Carousel -->
            <div x-data="{ activeIndex: 0, images: {{ Js::from($images) }} }" class="relative w-full">
                <div class="relative min-h-[200px] overflow-hidden rounded-t-lg">
                    <template x-for="(image, index) in images" :key="index">
                        <div :class="activeIndex === index ? 'block' : 'hidden'" class="duration-700 ease-in-out">
                            <div class="lazy-placeholder-products rounded-lg" x-data="{ imageSrc: null }"
                                x-init="setTimeout(() => { imageSrc = '{{ asset('storage/') }}/' + image }, 500)">
                                <img :src="imageSrc" :alt="`{{ $product->title }} - Image ${index + 1}`"
                                    class="lazy-img block w-auto h-auto object-contain rounded-lg">
                            </div>
                        </div>
                    </template>
                </div>

                <button @click="activeIndex = (activeIndex - 1 + images.length) % images.length"
                    class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 bg-white/30 group-hover:bg-white/50 rounded-full group-focus:ring-4 group-focus:ring-white">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </span>
                </button>
                <button @click="activeIndex = (activeIndex + 1) % images.length"
                    class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 bg-white/30 group-hover:bg-white/50 rounded-full group-focus:ring-4 group-focus:ring-white">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </span>
                </button>
            </div>
            @else
            <!-- Single Image -->
            <div class="lazy-placeholder-products rounded-lg" x-data="{ imageSrc: null }"
                x-init="setTimeout(() => { imageSrc = '{{ asset('storage/') . '/' . ($images[0] ?? $product->image) }}' }, 500)">
                <img :src="imageSrc" data-src="{{ asset('storage/') . '/' . ($images[0] ?? $product->image) }}"
                    class="lazy-img block w-auto h-auto object-contain rounded-lg" alt="{{ $product->title }}">
            </div>
            @endif
            <div class="px-5 pb-3 mt-3">
                <div class="flex flex-wrap gap-2">
                    {{-- @foreach ($product->categories as $category)
                        <span class="bg-gray-300 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $category->name }}
                    </span>
                    @endforeach --}}
                </div>

                <a href="/produk/{{ $product->id }}/detail" class="h-full">
                    <h5 class="text-xl font-semibold tracking-tight text-gray-900">{{ $product->title }}</h5>

                    <p class="mt-2 text-gray-500">
                        {!! Str::limit(strip_tags($product->description), 150, '...') !!}
                    </p>
                    <div class="flex items-center justify-between mt-5">
                        <span class="text-2xl font-semibold text-green-500">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        {{-- <a href="https://wa.me/{{ $product->wa_number }}" target="_blank" class="text-white
                            bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium
                            rounded-lg text-sm px-5 py-2.5 text-center">
                            Order via WA
                        </a> --}}
                    </div>
                </a>
            </div>
        </div>

        @empty
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <p wire:loading.remove wire:target="loadInitialProducts,search" class="text-gray-500">Produk tidak tersedia
                <i class="bi bi-emoji-frown"></i></p>
        </div>
        @endforelse
    </div>


    <!-- Skeleton Loader Init -->
    <div wire:loading wire:target="loadInitialProducts" class="w-full max-w-7xl">
        <div class="flex flex-row flex-wrap gap-6">
            @foreach (range(1, 6) as $index)
            <div role="status"
                class="bg-white border border-gray-200 rounded-lg shadow p-4 animate-pulse flex-shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                <div class="flex items-center justify-center h-48 mb-4 bg-gray-300 rounded">

                </div>
                <div class="h-2.5 bg-gray-200 rounded-full w-50 mb-4"></div>
                <div class="h-2 bg-gray-200 rounded-full mb-2.5"></div>
                <div class="h-2 bg-gray-200 rounded-full"></div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tombol Load More -->
    @if($products->count() >= $limit && $totalProducts > $limit)
    <div class="mt-4 flex justify-center">
        <!-- Tombol "Tampilkan Lebih" (akan hilang saat loading) -->
        <button wire:click="loadMore"
            class="bg-gray-800 text-white px-6 py-2 rounded-full shadow-md hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-400 focus:ring-opacity-50"
            wire:loading.remove wire:target="loadMore">
            Tampilkan Lebih
        </button>
        <!-- Tombol Loading (hanya muncul saat loading) -->
        <button
            class="mb-5 bg-gray-800 text-white px-6 py-2 rounded-full shadow-md cursor-not-allowed focus:outline-none focus:ring focus:ring-gray-400 focus:ring-opacity-50"
            type="button" disabled wire:loading wire:target="loadMore">
            Memuat..
            <svg class="inline w-5 h-5 text-white animate-spin ml-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 100 8v4a8 8 0 01-8-8z"></path>
            </svg>
        </button>
    </div>
    @endif


    <!-- Skeleton Loader LoadMore -->
    <div wire:loading wire:target="loadMore" class="w-full max-w-7xl">
        <div class="flex flex-row flex-wrap gap-6">
            @foreach(range(1, min($remainingProducts, 6)) as $index)
            <div role="status"
                class="bg-white border border-gray-200 rounded-lg shadow p-4 animate-pulse flex-shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                <div class="flex items-center justify-center h-48 mb-4 bg-gray-300 rounded">
    
                </div>
                <div class="h-2.5 bg-gray-200 rounded-full w-50 mb-4"></div>
                <div class="h-2 bg-gray-200 rounded-full mb-2.5"></div>
                <div class="h-2 bg-gray-200 rounded-full"></div>
            </div>
            @endforeach
        </div>
    </div>

</div>
