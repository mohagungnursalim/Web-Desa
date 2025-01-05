<div>
    <main class="pt-24 pb-16 lg:pb-24 bg-white antialiased min-h-screen">
        <div class="flex justify-center px-4 mx-auto max-w-screen-xl">
            <div class="w-full max-w-4xl p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <h5 class="text-xl font-bold leading-none text-gray-900 mb-3">
                    Layanan Kami
                </h5>

                <div id="accordion-collapse" data-accordion="collapse">
                    @foreach ($layanans as $index => $layanan)
                    <h2 id="accordion-collapse-heading-{{ $index + 1 }}">
                        <button type="button"
                            class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 gap-3"
                            data-accordion-target="#accordion-collapse-body-{{ $index + 1 }}" aria-expanded="false"
                            aria-controls="accordion-collapse-body-{{ $index + 1 }}">
                            <span>{{ $layanan->title }}</span>
                            <svg data-accordion-icon class="w-3 h-3 transition-transform rotate-0 shrink-0"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div style="max-height: 75vh; overflow-y: auto;" id="accordion-collapse-body-{{ $index + 1 }}" class="hidden"
                        aria-labelledby="accordion-collapse-heading-{{ $index + 1 }}">
                        <div class="p-5 border border-b-0 border-gray-200 ck-content bg-white text-gray-700">
                            {!! $layanan->description !!}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
