<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome Page')</title>  
    @vite(['resources/css/app.css', 'resources/js/app2.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen">
    <!-- Navbar -->
    @include('frontend.layouts.navbar')

    <!-- Main Content -->
    <div class="mt-20 mx-auto max-w-screen-xl px-4 py-10 flex-grow">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>

</html>
