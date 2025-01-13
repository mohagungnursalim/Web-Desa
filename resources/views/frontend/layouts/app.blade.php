<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome Page')</title>
    <script type="importmap">
        {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.2.0/"
                }
            }
    </script>
    @vite([
    'resources/css/app2.css',
    'resources/js/app2.js',
    'resources/css/style2.css',
    'resources/css/frontend/placeholder-image-posts.css',
    'resources/css/frontend/placeholder-image-products.css',
    ])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <style>
        .progress-bar {
            height: 5px !important;
            /* Sesuaikan dengan nilai yang diinginkan */
        }

        .spinner {
            display: none !important;
        }

    </style>
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen">
    <!-- Navbar -->
    @include('frontend.layouts.navbar')

    <!-- Main Content -->

    @yield('content')
    <!-- Scroll to Top Button -->
    <button id="scrollToTopBtn" type="button"
        class="flex mb-2 items-center justify-center text-white bg-gray-700 rounded-full w-14 h-14 hover:bg-gray-800 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-opacity opacity-0 fixed bottom-20 right-6"
        style="display: none; z-index: 9999;" onclick="scrollToTop()" data-tooltip-target="tooltip-scroll">
        <i class="bi bi-arrow-up-circle text-4xl"></i>
        <span class="sr-only">Scroll to top</span>
    </button>
    <div id="tooltip-scroll" role="tooltip"
        class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        Scroll to Top
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <!-- Livewire Integration -->
    <script>
        // Configure NProgress
        NProgress.configure({
            template: '<div class="bar" role="bar" style="background: #06ffd5; height: 3px;"><div class="peg"></div></div>',
            showSpinner: false
        });

        // Listen for Livewire Navigation Events
        document.addEventListener('livewire:navigate', () => {
            NProgress.start();
        });

        document.addEventListener('livewire:navigated', () => {
            NProgress.done();
        });

    </script>

    {{-- Scroll to Top Button --}}
    <script>
        // Declare the scroll logic function globally
        function handleScrollToTopVisibility() {
            const scrollToTopBtn = document.getElementById('scrollToTopBtn');
            if (window.scrollY > 200) {
                scrollToTopBtn.style.display = 'block';
                scrollToTopBtn.style.opacity = '1';
            } else {
                scrollToTopBtn.style.opacity = '0';
                scrollToTopBtn.style.display = 'none';

            }
        }
    
        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    
        // Attach scroll event and Livewire navigated event
        document.addEventListener('DOMContentLoaded', () => {
            // Attach the scroll listener on page load
            window.addEventListener('scroll', handleScrollToTopVisibility);
    
            // Reattach the scroll listener after Livewire navigates
            document.addEventListener('livewire:navigated', () => {
                window.addEventListener('scroll', handleScrollToTopVisibility);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
