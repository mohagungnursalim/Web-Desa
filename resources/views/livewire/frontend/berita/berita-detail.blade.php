<div class="flex flex-col items-center py-10 min-h-screen px-4 sm:px-6 md:px-10">

    <main class="pt-8 pb-16  lg:pb-24 bg-white antialiased">

        <!-- Breadcrumb -->
        <nav class="flex mb-4 px-5 py-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">

                <li>
                    <div class="flex items-center">
                        <a wire:navigate href="/berita"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Berita</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>

                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
            <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue">
                <header class="mb-4 lg:mb-6">
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-700 lg:mb-6 lg:text-4xl">
                        {{ $post->title }}</h1>
                    <p class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">
                        <i class="bi bi-calendar"></i> {{ $post->created_at->format('d/m/Y') }}
                    </p>
                    <p class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">
                        Dilihat: <i class="bi bi-eye"></i> {{ $post->views }} x <br>
                    </p>

                    <figure
                        class="relative overflow-hidden rounded-xl shadow-lg transition-transform transform hover:scale-105">
                        <img class="w-full h-auto rounded-lg" src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}">
                        <figcaption
                            class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-center py-2 text-sm">
                            {{-- Source/Catatan --}}
                            Source: heheheh
                        </figcaption>
                    </figure>
                    <div class="flex space-x-2">
                        @foreach ($post->categories as $category)
                        <span
                            class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-gray-500">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </header>

                {{-- Isi konten --}}
                {!! $post->description !!}

                <p class="text-sm font-bold text-gray-500">Tagar:</p>
                <div class="mt-4 flex space-x-2">
                    @foreach ($post->tags as $tag)
                    <p class="bg-gray-200 rounded-full px-3 py-1 text-sm font-medium text-gray-700">#{{ $tag->name }}
                    </p>
                    @endforeach
                </div>
                <p class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">
                    Pengunjung: <i class="bi bi-eye"></i> {{ $uniqueCount }} x <br>
                </p>
            </article>
        </div>


        <div data-dial-init class="fixed flex end-6 bottom-6 group">
            <div id="speed-dial-menu-horizontal" class="flex items-center hidden me-4 space-x-2 rtl:space-x-reverse">
                <!-- Share to WhatsApp -->
                <button type="button" data-tooltip-target="tooltip-whatsapp" data-tooltip-placement="top"
                    onclick="shareToWhatsApp()"
                    class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200  shadow-sm  hover:bg-gray-50  focus:ring-4 focus:ring-gray-300 focus:outline-none">
                    <i class="bi bi-whatsapp"></i>
                    <span class="sr-only">Bagikan ke WhatsApp</span>
                </button>
                <div id="tooltip-whatsapp" role="tooltip"
                    class="absolute z-10 invisible inline-block w-auto px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip ">
                    Bagikan ke WhatsApp
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>

                <!-- Copy Link -->
                <button type="button" data-tooltip-target="tooltip-copy" data-tooltip-placement="top"
                    onclick="copyToClipboard()"
                    class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200  focus:ring-4 focus:ring-gray-300 focus:outline-none">
                    <i class="bi bi-copy"></i>
                    <span class="sr-only">Salin link</span>
                </button>
                <div id="tooltip-copy" role="tooltip"
                    class="absolute z-10 invisible inline-block w-auto px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip ">
                    Salin link
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>


            <!-- Share Button -->
            <button type="button" data-dial-toggle="speed-dial-menu-horizontal"
                aria-controls="speed-dial-menu-horizontal" aria-expanded="false"
                class="flex items-center justify-center text-white bg-blue-700 rounded-full w-14 h-14 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none"
                data-tooltip-target="tooltip-share">
                <i class="bi bi-share-fill text-2xl"></i>
                <span class="sr-only">Share</span>
            </button>
            <div id="tooltip-share" role="tooltip"
                class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Share
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>

    </main>

    {{-- Share Post --}}
    <script>
        function shareToWhatsApp() {
            const url = window.location.href;
            const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(url)}`;
            window.open(whatsappUrl, '_blank');
        }

        function copyToClipboard() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link berhasil disalin!');
            }).catch(err => {
                alert('Gagal salin link: ' + err);
            });
        }

    </script>


</div>
