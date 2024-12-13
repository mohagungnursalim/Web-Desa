<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome Page')</title>
    @vite(['resources/css/app.css', 'resources/js/app2.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <style>
        .progress-bar {
            height: 5px !important; /* Sesuaikan dengan nilai yang diinginkan */
        }
    </style>
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen">
    <!-- Navbar -->
    @include('frontend.layouts.navbar')

    <!-- Main Content -->
    
        @yield('content')


    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <!-- Livewire Integration -->
    <script>
        // Configure NProgress
        NProgress.configure({
            template: '<div class="bar" role="bar" style="background: #06ffd5; height: 3px;"><div class="peg"></div></div>'
        });

        // Listen for Livewire Navigation Events
        document.addEventListener('livewire:navigate', () => {
            NProgress.start();
        });

        document.addEventListener('livewire:navigated', () => {
            NProgress.done();
        });

    </script>
    @stack('scripts')
</body>

</html>
