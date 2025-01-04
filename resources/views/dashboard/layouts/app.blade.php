{{-- New Template --}}
@include('dashboard.layouts.head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css">
<style>
/* Mengatur z-index untuk progress bar agar berada di atas elemen lain */
#nprogress .bar {
    height: 3px !important;
    z-index: 9999 !important; /* Pastikan progress bar di atas semua elemen */
}

#nprogress {
    z-index: 9999 !important; /* Memastikan kontainer NProgress juga di atas */
}

</style>
<style>
    /* Gaya CSS untuk Preloader */
    #preloader {
        position: fixed;
        top: 0;
        left: 125px;
        width: 100%;
        height: 100%;
        z-index: 9999; /* Pastikan preloader di atas elemen lain */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .spinner-border {
        color: #989898;
        width: 8rem;
        height: 8rem;
        border-width: 1rem;
    }
    
    #nprogress .spinner {
        display: none !important;
    }
</style>
<script type="importmap">
    {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.2.0/"
            }
        }
</script>
@vite([
    'resources/css/style.css',
    'resources/css/placeholder-image.css',
    'resources/css/placeholder-image-product.css',
    'resources/css/placeholder-image-project.css',
    ])


<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader" style="display: none;">
        <div class="spinner-border" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
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
    <!-- Impor AdminLTE setelah jQuery dan Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    {{-- Select2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
        <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    
    <script>
        // Mendengarkan event navigasi Livewire
        document.addEventListener('livewire:navigate', () => {
            // Tampilkan preloader saat navigasi terjadi
            document.getElementById('preloader').style.display = 'flex';
        });

        document.addEventListener('livewire:navigated', () => {
            // Sembunyikan preloader setelah navigasi selesai
            document.getElementById('preloader').style.display = 'none';
        });
    </script>
        <!-- Livewire Integration -->
        <script>
            // Configure NProgress
            NProgress.configure({
                template: '<div class="bar" role="bar" height: 3px;"><div class="peg"></div></div>'
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
