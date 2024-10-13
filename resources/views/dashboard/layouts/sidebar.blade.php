<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <style>
        /* Warna untuk link yang aktif */
        .nav-sidebar .nav-link.active {
            background-color: #efa845 !important;
            /* Warna hijau terang */
            color: #ffffff !important;
            /* Warna teks putih */
        }

        /* Warna untuk dropdown menu (nav-treeview) */
        .nav-sidebar .nav-treeview .nav-link.active {
            background-color: #767168 !important;
            /* Warna hijau turquoise */
            color: #ffffff !important;
            /* Warna teks putih */
        }

    </style>
    <a href="/dashboard" class="brand-link">
        {{-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">Web Desa</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div> --}}
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-header">--Konten--</li>
                <li
                    class="nav-item {{ Request::is('dashboard/produk*') || Request::is('dashboard/kategori-produk*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::is('dashboard/produk*') || Request::is('dashboard/kategori-produk*') ? 'active' : '' }}">
                        <i class="bi bi-bag"></i>
                        <p>
                            Produk
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/dashboard/produk" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i>
                                <p class="{{Request::is('dashboard/produk*') ? 'text-warning' : ''}}">Master Produk</p>
                            </a>
                        </li>

                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/dashboard/kategori-produk" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i>
                                <p class="{{Request::is('dashboard/kategori-produk') ? 'text-warning' : ''}}">Master
                                    Kategori Produk</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item {{ Request::is('dashboard/proyek*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('dashboard/proyek*') ? 'active' : '' }}">
                        <i class="bi bi-building-fill-gear"></i>
                        <p>
                            Proyek
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/dashboard/proyek" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i>
                                <p class="{{ Request::is('dashboard/proyek*') ? 'text-warning' : '' }}">Master Proyek
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-header">--Pengaturan--</li>

                <li class="nav-item {{ Request::is('dashboard/profil') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('dashboard/profil') ? 'active' : '' }}">
                        <i class="bi bi-person-fill-gear"></i>
                        <p>
                            Akun
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/dashboard/profil" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i> <i class="bi bi-person-vcard-fill"></i>
                                <p class="{{ Request::is('dashboard/profil') ? 'text-warning' : '' }}">Ubah Profil</p>
                            </a>
                        </li>

                    </ul>
                </li>




                {{-- LogOut --}}
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="openLogoutModal()">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p class="text">LogOut</p>
                    </a>
                </li>


            </ul>
        </nav>

    </div>

</aside>

<div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi LogOut</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Sesi kamu akan berakhir dengan mengklik LogOut!</p>

            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button style="border-radius: 10px;" type="submit" class="btn btn-danger">LogOut</button>
                </div>
            </form>

        </div>

    </div>
</div>


@push('scripts')
<script>
    function openLogoutModal() {
        $('#logoutModal').modal('show');

    }

</script>


@endpush
