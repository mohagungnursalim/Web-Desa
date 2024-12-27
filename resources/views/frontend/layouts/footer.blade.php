<footer class="bg-orange-100 mt-auto">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="#" class="flex items-center space-x-3">
                    <img src="{{ asset('storage/'. $appLogo) }}" class="h-10" alt="Flowbite Logo">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap">{{ $appName }}</span>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Sosial Media</h2>
                    <ul class="text-gray-500 font-medium">
                        <li class="mb-4">
                            <a href="{{ $facebook }}" class="hover:underline">Facebook</a>
                        </li>
                        <li>
                            <a href="{{ $instagram }}" class="hover:underline">Instagram</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Link Tautan</h2>
                    <ul class="text-gray-500 font-medium">
                        @foreach ($globalLinks as $link)
                        <li class="mb-4">
                            <a href="https://{{ $link->linkHttp }}" class="hover:underline">{{ $link->linkTitle }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center">
                {{ $footerText }}
            </span>
            <div class="flex mt-4 sm:justify-center sm:mt-0">
                <!-- Social media icons -->
            </div>
        </div>
    </div>
</footer>