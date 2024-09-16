<!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar"> <!-- Ganti warna sidebar -->           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label text-secondary">-Utama-</li>
                    <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard" aria-expanded="false">
                            <i class="bi bi-speedometer"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('produk') ? 'active' : '' }}">
                        <a href="/dashboard/produk" aria-expanded="false">
                            <i class="bi bi-cart"></i><span class="nav-text">Produk</span>
                        </a>
                    </li>
                    <li class="nav-label text-secondary">-Pengaturan-</li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->