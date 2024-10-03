{{-- New Template --}}
@include('dashboard.layouts.head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
{{-- Masukan Head disini --}}

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        {{-- Masukan navbar disini --}}
        @include('dashboard.layouts.navbar')

        {{-- Masukan sidebar disini --}}
        @include('dashboard.layouts.sidebar')

        <div class="content-wrapper">

            {{-- Sweetalert --}}
            @include('sweetalert::alert')
            {{-- Masukan konten disini --}}
            @yield('content')

        </div>

        {{-- Masukan footer disini --}}
        @include('dashboard.layouts.footer')
        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    @stack('scripts')
</body>

</html>
