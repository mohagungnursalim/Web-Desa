<div class="flex flex-col items-center py-10 min-h-screen px-4 sm:px-6 md:px-10">
 
<main class="pt-8 pb-16  lg:pb-24 bg-white antialiased">
    
<!-- Breadcrumb -->
<nav class="flex mb-4 px-5 py-3" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
     
      <li>
        <div class="flex items-center">
          <a wire:navigate href="/berita" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Berita</a>
        </div>
      </li>
      <li aria-current="page">
        <div class="flex items-center">
          <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>

        </div>
      </li>
    </ol>
  </nav>
  
    <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
        <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <header class="mb-4 lg:mb-6">
                <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-700 lg:mb-6 lg:text-4xl">{{ $post->title }}</h1>
                <p class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">
                    <i class="bi bi-calendar"></i> {{ $post->created_at->format('d/m/Y') }}
                  </p>
                <p class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">
                 Dilihat: <i class="bi bi-eye"></i> {{ $post->views }} x <br>
                </p>
                <figure class="relative overflow-hidden rounded-xl shadow-lg transition-transform transform hover:scale-105">
                    <img class="w-full h-auto rounded-lg" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                    <figcaption class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-center py-2 text-sm">
                        {{-- Source/Catatan --}}
                        Source: heheheh
                    </figcaption>
                </figure>
                <div class="mt-4 flex space-x-2">
                    @foreach ($post->categories as $category)
                        <p class="bg-gray-900 rounded px-3 py-1 text-sm font-medium text-white">{{ $category->name }}</p>
                    @endforeach
                </div>
            </header>
            
           {{-- Isi konten --}}
            {!! $post->description !!}

            <p class="text-sm font-bold text-gray-500">Tagar:</p>
            <div class="mt-4 flex space-x-2">
                @foreach ($post->tags as $tag)
                    <p class="bg-gray-200 rounded-full px-3 py-1 text-sm font-medium text-gray-700">#{{ $tag->name }}</p>
                @endforeach
            </div>
            <p class="ms-1 text-sm font-medium text-gray-500 md:ms-2 ">
              Pengunjung: <i class="bi bi-eye"></i> {{ $uniqueCount }} x <br>
             </p>
        </article>
    </div>
  </main>
  
  
</div>
