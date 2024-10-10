<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="../../index3.html" class="brand-link">
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <li class="nav-header">Konten</li>
                <li class="nav-item {{ Request::is('dashboard/produk*') || Request::is('dashboard/kategori-produk*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('dashboard/produk*') || Request::is('dashboard/kategori-produk*') ? 'active' : '' }}">
                        <i class="bi bi-bag"></i>
                        <p>
                            Produk
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/dashboard/produk" class="nav-link {{Request::is('dashboard/produk*') ? 'active' : ''}}">
                                <i class="bi bi-arrow-return-right"></i>
                                <p>Master Produk</p>
                            </a>
                        </li>
                       
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/dashboard/kategori-produk" class="nav-link {{Request::is('dashboard/kategori-produk') ? 'active' : ''}}">
                                <i class="bi bi-arrow-return-right"></i>
                                <p>Master Kategori Produk</p>
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
                            <a href="/dashboard/proyek" class="nav-link {{ Request::is('dashboard/proyek*') ? 'active' : '' }}">
                                <i class="bi bi-arrow-return-right"></i>
                                <p>Master Proyek</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
        
                <li class="nav-header">Pengaturan</li>

            </ul>
        </nav>

    </div>

</aside>