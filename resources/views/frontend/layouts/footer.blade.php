<footer class="bg-white mt-auto">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="#" class="flex items-center space-x-3">
                    <img src="{{ asset('storage/'.  \App\Models\Setting::getSetting('appLogo', null)) }}" class="h-10" alt="Flowbite Logo">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap">{{ \App\Models\Setting::getSetting('app_name', 'App Name') }}</span>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Resources</h2>
                    <ul class="text-gray-500 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Flowbite</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Tailwind CSS</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Follow us</h2>
                    <ul class="text-gray-500 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Github</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Discord</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Legal</h2>
                    <ul class="text-gray-500 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Terms & Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center">
                {!! \App\Models\Setting::getSetting('footer_text', 'Footer App') !!}
            </span>
            <div class="flex mt-4 sm:justify-center sm:mt-0">
                <!-- Social media icons -->
            </div>
        </div>
    </div>
</footer>