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
                <li class="nav-item {{Request::is('dashboard/produk*') ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('dashboard/produk*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/dashboard/produk" class="nav-link {{Request::is('dashboard/produk*') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Master Produk</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
        
                <li class="nav-header">Pengaturan</li>

            </ul>
        </nav>

    </div>

</aside>