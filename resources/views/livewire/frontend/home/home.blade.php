<div>
    <section class="bg-white">

        {{-- Jumbotron --}}
        <section
            class="bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
            <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-4xl lg:text-1xl">
                    Selamat Datang Website Resmi Kelurahan Lambara</h1>
                <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Sumber Informasi dan
                    Layanan Kelurahan Lambara.</p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                    <a href="#"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Berita <i class="bi bi-newspaper ml-1"></i>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Produk <i class="bi bi-cart3 ml-1"></i>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Kontak <i class="bi bi-envelope-arrow-up-fill ml-1"></i>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Cek DPT Online <i class="bi bi-people-fill ml-1"></i> <i class="bi bi-check-all ml-1"></i>
                    </a>
                </div>
            </div>
        </section>

        {{-- Sambutan Kepala OPD --}}
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-gray-700 underline decoration-indigo-500">
                    {{-- Hero Title --}}
                    {{ \App\Models\Setting::getSetting('heroTitle', 'Hero Title') }}
                </h1>
                <p class="max-w-2xl mb-6 text-gray-500">
                    {{-- Hero Description --}}
                    {{ \App\Models\Setting::getSetting('heroDescription', 'Hero Description') }}
                </p>

            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                {{-- Hero Logo--}}
                <img src="{{ asset('storage/'.  \App\Models\Setting::getSetting('heroImage', null)) }}" width="70%"
                    alt="Logo Kota Palu">

            </div>
        </div>

        {{-- Carousel --}}
        <div id="indicators-carousel" class="relative w-full mt-10" data-carousel="slide">
            <h3
                class="mb-5 text-4xl font-extrabold underline decoration-indigo-500 leading-none text-gray-700 md:text-5xl lg:text-1xl">
                Berita Terkini</h3>
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-xl md:h-96">
                @foreach ($posts as $index => $post)
                <div class="{{ $index === 0 ? 'block' : 'hidden' }} flex justify-center items-center duration-700 ease-in-out"
                    data-carousel-item="{{ $index === 0 ? 'active' : '' }}">

                    <a href="/postingan/{{ $post->slug }}">
                        <img src="{{ asset('storage/' . $post->image) }}"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                            alt="{{ $post->title }}">

                        <!-- Kontainer untuk teks -->
                        <div
                            class="absolute inset-0 flex flex-col justify-center items-center bg-black/5 p-4 rounded-md text-center">
                            <h1 class="text-xl font-semibold mb-2 text-white">
                                {{ Str::limit(strip_tags($post->title),60,'..')  }}</h1>
                            <p class="text-sm max-w-md bg-black/30 text-white px-4 py-2 rounded-md">
                                {{ Str::limit(strip_tags($post->description), 150, '...') }}
                            </p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                @foreach ($posts as $index => $post)
                <button type="button" class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-blue-600' : 'bg-gray-300' }}"
                    aria-label="Slide {{ $index + 1 }}" data-carousel-slide-to="{{ $index }}"></button>
                @endforeach
            </div>

            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-500/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-white-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-500/30 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-white-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>


        </div>
        <div class="text-center mt-5">
            <a href="/postingan" class="text-amber-400 underline font-semibold underline decoration-gray-500">Lihat
                lebih banyak postingan..</a>
        </div>

    </section>
</div>
