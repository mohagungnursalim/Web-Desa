<nav class="bg-orange-500 fixed top-0 left-0 w-full z-50 shadow">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="{{ asset('storage/'.  \App\Models\Setting::getSetting('appLogo', null)) }}" class="h-10" alt="Logo">
        <span class="text-white self-center text-2xl font-semibold whitespace-nowrap">{{ \App\Models\Setting::getSetting('app_name', 'App Name') }}</span>
      </a>
      <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        @auth
        <a href="/dashboard"
           class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">Dashboard</a>
        @endauth
        <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-sticky" aria-expanded="false">
          <span class="sr-only"></span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
        </button>
      </div>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded bg-orange-500 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
          <li>
            <a wire:navigate href="/"
               class="block py-2 px-3 {{ Request::is('/') ? 'text-gray-700' : 'text-white' }} rounded hover:bg-gray-500 md:hover:bg-transparent md:hover:text-red-700 md:p-0"
               aria-current="">Beranda</a>            
          </li>
          <!-- Dropdown Profil -->
          <li class="relative">
            <button id="dropdownButton" type="button"
               class="block py-2 px-3 text-white rounded hover:bg-gray-500 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 flex items-center focus:outline-none">
              Profil
              <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
              </svg>
            </button>
            <!-- Dropdown -->
            <div id="dropdownMenu" class="absolute hidden mt-2 bg-gray-500 border border-gray-200 rounded-lg shadow-lg">
                  @foreach ($globalAbouts as $about)
                  <a href="/profil/{{ $about->slug }}" class="block px-8 text-white py-1 text-gray-700 bg-gray-500 hover:bg-gray-700 rounded-lg whitespace-nowrap min-w-[10rem]">
                  {{ $about->title }}
                  </a>    
                  @endforeach
            </div>

          </li>
     
          <li>
            <a href="#"
               class="block py-2 px-3 text-white rounded hover:bg-gray-500 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Layanan</a>
          </li>
          <li>
            <a href="#"
               class="block py-2 px-3 text-white rounded hover:bg-gray-500 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Aduan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

