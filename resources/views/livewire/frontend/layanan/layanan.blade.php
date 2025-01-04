<div> 
    <main class="pt-24 pb-16 lg:pb-24 bg-white antialiased min-h-screen">
        <div class="flex justify-center px-4 mx-auto max-w-screen-xl">
            <div class="w-full max-w-4xl p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <h5 class="text-xl font-bold leading-none text-gray-900 mb-3">
                    Layanan Kami
                </h5>
                <div class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50" 
                        id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                        @foreach ($layanans as $index => $layanan)
                            <li class="me-2">
                                <button id="tab-{{ $index }}" 
                                        data-tabs-target="#content-{{ $index }}" 
                                        type="button" 
                                        role="tab" 
                                        aria-controls="content-{{ $index }}" 
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}" 
                                        class="inline-block p-4 {{ $loop->first ? 'text-blue-600 bg-white' : 'text-gray-500' }} rounded-ss-lg hover:bg-gray-100">
                                    {{ $layanan->title }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div id="defaultTabContent">
                        @foreach ($layanans as $index => $layanan)
                            <div class="{{ $loop->first ? '' : 'hidden' }} p-4 bg-white rounded-lg md:p-8" 
                                 id="content-{{ $index }}" 
                                 role="tabpanel" 
                                 aria-labelledby="tab-{{ $index }}">
                                <p class="text-gray-700">
                                    <div class="ck-content">
                                        {!! $layanan->description !!}
                                    </div>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
