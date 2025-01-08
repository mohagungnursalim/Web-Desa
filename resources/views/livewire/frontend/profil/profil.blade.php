<div>
    <main class="pt-24 pb-16 lg:pb-24 bg-white antialiased min-h-screen">
        <div class="flex justify-center px-4 mx-auto max-w-screen-xl">
            <div class="w-full max-w-4xl bg-gray-50 shadow-md rounded-lg p-6">
                <h4 class="text-2xl font-semibold text-gray-800 mb-4 underline decoration-indigo-500">{{ $profil->title }}</h4>
                <div class="prose max-w-full overflow-hidden overflow-ellips
                is break-words">
                    {!! $profil->description !!}
                </div>
            </div>
        </div>
    </main>
</div>
