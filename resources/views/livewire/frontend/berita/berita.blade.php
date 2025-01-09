<div class="flex flex-col items-center py-10 min-h-screen px-4 sm:px-6 md:px-10">
    <h3
        class="text-center mt-2 mb-7 text-4xl font-extrabold underline decoration-indigo-500 leading-none text-gray-700 md:text-4xl lg:text-1xl">
        Berita
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
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-gray-800 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
        </svg>     
    </a>

    <!-- Content Posts -->
    <div wire:init="loadInitialPosts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-7xl">
        @forelse ($posts as $index => $post)
        <div class="bg-white border border-gray-200 rounded-lg shadow transition-transform transform hover:scale-105">
            <a href="/berita/{{ $post->slug }}">
                <div class="lazy-placeholder-posts rounded-lg " x-data="{ imageSrc: null }"
                    x-init="setTimeout(() => { imageSrc = $el.querySelector('img').dataset.src }, 500)">
                    <img :src="imageSrc" data-src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                        class="lazy-img rounded-lg  h-48 object-cover">
                </div>
            </a>
            <div class="p-5">
                <a href="/berita/{{ $post->slug }}">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                        {{ $post->title }}
                    </h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">
                    {{ $post->excerpt }}
                </p>
            </div>
        </div>
        @empty
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <p wire:loading.remove wire:target="loadInitialPosts,search" class="text-gray-500">Postingan tidak tersedia <i
                    class="bi bi-emoji-frown"></i></p>
        </div>
        @endforelse
    </div>

    <!-- Skeleton Loader Init -->
    <div wire:loading wire:target="loadInitialPosts" class="w-full max-w-7xl">
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
    @if($posts->count() >= $limit && $totalPosts > $limit)
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
            @foreach(range(1, min($remainingPosts, 6)) as $index)
            <div role="status"
                class="bg-white border border-gray-200 rounded-lg shadow p-4 animate-pulse flex-shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                <div class="flex items-center justify-center h-48 mb-4 bg-gray-300 rounded">
                    <svg class="w-10 h-10 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 20">
                        <path
                            d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z" />
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                    </svg>
                </div>
                <div class="h-2.5 bg-gray-200 rounded-full w-50 mb-4"></div>
                <div class="h-2 bg-gray-200 rounded-full mb-2.5"></div>
                <div class="h-2 bg-gray-200 rounded-full"></div>
            </div>
            @endforeach
        </div>
    </div>

</div>
