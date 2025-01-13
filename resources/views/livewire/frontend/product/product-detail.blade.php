<div class="flex flex-col items-center py-10 min-h-screen px-4 sm:px-6 md:px-10 bg-gray-50">
   <!-- Breadcrumb -->
   <nav class="flex mb-5 px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-white shadow-sm"
       aria-label="Breadcrumb">
       <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
           <li>
               <div class="flex items-center">
                   <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                       xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                           d="m1 9 4-4-4-4" />
                   </svg>
                   <a wire:navigate href="/produk"
                       class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">Produk</a>
               </div>
           </li>
           <li aria-current="page">
               <div class="flex items-center">
                   <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                       xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                           d="m1 9 4-4-4-4" />
                   </svg>
                   <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">
                       {{ $product->title }}
                   </span>
               </div>
           </li>
       </ol>
   </nav>

   <!-- Product Details Card -->
   <div class="bg-white border border-gray-200 rounded-lg shadow-lg w-full max-w-5xl flex flex-col md:flex-row">
       <!-- Carousel Section -->
       @php
       $images = is_string($product->image) ? json_decode($product->image, true) : $product->image;
       @endphp

       <div x-data="{ activeIndex: 0, images: {{ Js::from($images) }} }" class="relative w-full md:w-1/2">
           <div class="relative aspect-square md:aspect-auto overflow-hidden">
               <template x-for="(image, index) in images" :key="index">
                   <div :class="activeIndex === index ? 'block' : 'hidden'" class="duration-700 ease-in-out">
                       <img :src="'{{ asset('storage/') }}/' + image"
                           :alt="`{{ $product->title }} - Image ${index + 1}`"
                           class="object-cover w-full h-full rounded-lg" style="width: 550px">
                   </div>
               </template>
           </div>

           <!-- Tombol Sebelumnya -->
           <button x-show="images.length > 1" @click="activeIndex = (activeIndex - 1 + images.length) % images.length"
               class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
               <span
                   class="inline-flex items-center justify-center w-10 h-10 bg-white/30 group-hover:bg-white/50 rounded-full group-focus:ring-4 group-focus:ring-white">
                   <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                       xmlns="http://www.w3.org/2000/svg">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                       </path>
                   </svg>
               </span>
           </button>

           <!-- Tombol Berikutnya -->
           <button x-show="images.length > 1" @click="activeIndex = (activeIndex + 1) % images.length"
               class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
               <span
                   class="inline-flex items-center justify-center w-10 h-10 bg-white/30 group-hover:bg-white/50 rounded-full group-focus:ring-4 group-focus:ring-white">
                   <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                       xmlns="http://www.w3.org/2000/svg">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                   </svg>
               </span>
           </button>
       </div>

       <!-- Product Info Section -->
       <div class="p-6 flex flex-col justify-between w-full md:w-1/2" style="max-height: 60vh; overflow-y: auto;">
           <div>
               <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $product->title }}</h2>
               <p class="text-gray-700 leading-relaxed mb-4">
                   {!! $product->description !!}
               </p>
           </div>
       </div>
   </div>
   <div class="p-6 flex flex-col justify-between w-full md:w-1/2">
     
      <div class="flex items-center justify-between mt-4">
          <span
              class="text-2xl font-semibold text-green-500 bg-gray-200 hover:bg-gray-900 hover:text-white rounded-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
          <a href="https://wa.me/{{ $product->wa_number }}"
              class="inline-block px-6 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
              Order via WA
          </a>
      </div>
  </div>
</div>
