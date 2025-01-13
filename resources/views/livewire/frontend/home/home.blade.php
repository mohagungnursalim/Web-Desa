<div>
    <style>
        .full-page {
            height: 100vh;
            /* Membuat elemen setinggi viewport */
            width: 100%;
            /* Lebar elemen penuh */
            background-size: cover;
            /* Memastikan gambar menyesuaikan layar */
            background-position: center;
            /* Menyelaraskan gambar ke tengah */
            background-repeat: no-repeat;
            /* Menghindari pengulangan gambar */
        }

    </style>
    <section class="bg-white">

        {{-- Jumbotron Section --}}
        <section
            class="bg-center bg-no-repeat full-page bg-gray-700 bg-blend-multiply" style="background-image: url('{{ asset('storage/' . \App\Models\Setting::getSetting('jumbotronImage', null)) }}');">>
            <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-4xl lg:text-1xl">
                    {{-- Jumbotron Title --}}
                    {{ \App\Models\Setting::getSetting('jumbotronTitle', 'Jumbotron Title') }}</h1>
                <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
                    {{-- Jumbotron Description --}}
                    {{ \App\Models\Setting::getSetting('jumbotronDescription', 'Jumbotron Description') }}
                </p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                    <a wire:navigate href="/layanan-kami"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Layanan  <i class="bi bi-people ml-1"></i>
                    </a>
                    <a wire:navigate href="/berita"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Berita <i class="bi bi-newspaper ml-1"></i>
                    </a>
                    <a wire:navigate href="/produk"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Produk <i class="bi bi-cart3 ml-1"></i>
                    </a>
                    <a wire:navigate href="/proyek"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Proyek <i class="bi bi-clipboard2-data-fill ml-1"></i>
                    </a>
                    <a wire:navigate href="/aduan"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Aduan Masyarakat <i class="bi bi-envelope-arrow-up-fill ml-1"></i>
                    </a>
                    <a href="https://cekdptonline.kpu.go.id/"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Cek DPT Online <i class="bi bi-people-fill ml-1"></i> <i class="bi bi-check-all ml-1"></i>
                    </a>
                </div>
            </div>
        </section>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffe0b2" fill-opacity="1" d="M0,288L40,250.7C80,213,160,139,240,138.7C320,139,400,213,480,202.7C560,192,640,96,720,85.3C800,75,880,149,960,170.7C1040,192,1120,160,1200,154.7C1280,149,1360,171,1400,181.3L1440,192L1440,0L1400,0C1360,0,1280,0,1200,0C1120,0,1040,0,960,0C880,0,800,0,720,0C640,0,560,0,480,0C400,0,320,0,240,0C160,0,80,0,40,0L0,0Z"></path></svg>

        {{-- OPD Section --}}
        <div class=" mx-auto max-w-screen-xl px-4 py-10 flex-grow">
            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div class="mr-auto place-self-center lg:col-span-7">
                    <h1
                        class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-gray-700 underline decoration-indigo-500">
                        {{-- OPD Title --}}
                        {{ \App\Models\Setting::getSetting('opdTitle', 'OPD Title') }}
                    </h1>
                    <p class="mb-6 text-gray-500">
                        {{-- OPD Description --}}
                        {!! \App\Models\Setting::getSetting('opdDescription', 'OPD Description') !!}
                    </p>
                    <h4 class="flex justify-center font-extrabold ">{{ \App\Models\Setting::getSetting('opdName', 'OPD Name') }}</h4>
                    <p class="flex justify-center">{{ \App\Models\Setting::getSetting('opdPosition', 'OPD Position') }}</p>
                </div>
                <div class="flex justify-center items-center lg:col-span-5">
                    {{-- OPD Logo --}}
                    <img class="w-full max-w-xs lg:max-w-full lg:w-auto"
                        src="{{ asset('storage/'.  \App\Models\Setting::getSetting('opdImage', null)) }}"
                        alt="Logo Kota Palu" width="50%">
                        
                </div>

            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffe0b2" fill-opacity="1" d="M0,288L40,266.7C80,245,160,203,240,186.7C320,171,400,181,480,197.3C560,213,640,235,720,208C800,181,880,107,960,101.3C1040,96,1120,160,1200,192C1280,224,1360,224,1400,224L1440,224L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path></svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffe0b2" fill-opacity="1" d="M0,288L40,266.7C80,245,160,203,240,186.7C320,171,400,181,480,197.3C560,213,640,235,720,208C800,181,880,107,960,101.3C1040,96,1120,160,1200,192C1280,224,1360,224,1400,224L1440,224L1440,0L1400,0C1360,0,1280,0,1200,0C1120,0,1040,0,960,0C880,0,800,0,720,0C640,0,560,0,480,0C400,0,320,0,240,0C160,0,80,0,40,0L0,0Z"></path></svg>



        {{-- Carousel --}}
        <div class="mt-20 mx-auto max-w-screen-xl px-4 py-10 flex-grow">
            <div id="indicators-carousel" class="relative w-full mt-10" data-carousel="slide">
                <h3
                    class="mb-5 text-4xl text-end font-extrabold underline decoration-indigo-500 leading-none text-gray-700 md:text-5xl lg:text-1xl">
                    Berita Terkini</h3>
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-xl md:h-96">
                    @foreach ($posts as $index => $post)
                    <div class="{{ $index === 0 ? 'block' : 'hidden' }} flex justify-center items-center duration-700 ease-in-out"
                        data-carousel-item="{{ $index === 0 ? 'active' : '' }}">

                        <a wire:navigate href="/berita/{{ $post->slug }}">
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
                    <button type="button"
                        class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-blue-600' : 'bg-gray-300' }}"
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
                <a wire:navigate href="/berita" class="text-amber-700 underline font-semibold underline decoration-gray-500">Lihat
                    lebih banyak postingan..</a>
            </div>
        </div>
       

        {{-- Produk --}}
        <div class="mt-20 mx-auto max-w-screen-xl px-4 py-10 flex-grow">
            <h3 class="text-center mb-7 text-4xl font-extrabold underline decoration-indigo-500 leading-none text-gray-700 md:text-5xl lg:text-1xl">
                Produk
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 justify-items-center">
                @foreach ($products as $product)
                <div class="w-full max-w-xs bg-white border border-gray-200 rounded-lg shadow">
                    @php
                    // Decode image JSON jika berupa string
                    $images = is_string($product->image) ? json_decode($product->image, true) : $product->image;
                    @endphp
        
                    @if ($images && is_array($images) && count($images) > 0)
                    <div id="productCarousel{{ $product->id }}" class="relative w-full" data-carousel="static">
                        <!-- Tambahkan tinggi dinamis untuk pembungkus -->
                        <div class="relative min-h-[200px] overflow-hidden rounded-t-lg">
                            @foreach ($images as $index => $img)
                            <div class="{{ $index === 0 ? 'block' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                                <!-- Properti gambar -->
                                <img src="{{ asset('storage/' . $img) }}" 
                                    class="block w-auto h-auto object-contain" 
                                    alt="{{ $product->title }} - Image {{ $index + 1 }}">
                            </div>
                            @endforeach
                        </div>
                        @if (count($images) > 1)
                        <button type="button"
                            class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 bg-white/30 group-hover:bg-white/50 rounded-full group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button"
                            class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 bg-white/30 group-hover:bg-white/50 rounded-full group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                        @endif
                    </div>
                    @else
                    <!-- Default gambar jika hanya ada satu -->
                    <img class="block w-auto h-auto object-contain" 
                        src="{{ asset('storage/' . $product->image) }}" 
                        alt="{{ $product->title }}">
                    @endif
        
                    <div class="px-5 pb-3 mt-3">
                        <a wire:navigate href="/produk/{{ $product->id }}/detail">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900">
                                {{ $product->title }}
                            </h5>
                            <p class="mt-2 text-gray-500">
                                {!! Str::limit(strip_tags($product->description), 150, '...') !!}
                            </p>
                            <div class="flex items-center justify-between mt-5">
                                <span class="text-2xl font-semibold text-green-500">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a wire:navigate href="/produk" class="text-amber-700 underline font-semibold underline decoration-gray-500">Lihat
                    lebih banyak produk..</a>
            </div>
        </div>
        
        




    </section>
</div>
