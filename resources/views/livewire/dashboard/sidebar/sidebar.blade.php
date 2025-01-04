<div>
    <a wire:navigate href="/dashboard" class="brand-link">
        <img src="{{ asset('storage/' . $appLogo) }}" alt="App Logo" width="25%">
        <span class="brand-text font-weight-light">{{ $appName }}</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('storage/' . Auth::user()->image) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-header">--Konten--</li>

                <li class="nav-item {{ Request::is('dashboard/postingan*') || Request::is('dashboard/kategori-postingan') || Request::is('dashboard/tag-postingan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('dashboard/postingan*') || Request::is('dashboard/kategori-postingan') || Request::is('dashboard/tag-postingan') ? 'active' : '' }}">
                        <i class="bi bi-pencil-square"></i>
                        <p>
                            Postingan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a wire:navigate href="/dashboard/postingan" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i>
                                <p class="{{Request::is('dashboard/postingan*') ? 'text-warning' : ''}}">Master Postingan</p>
                            </a>
                        </li>

                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a wire:navigate href="/dashboard/kategori-postingan" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i>
                                <p class="{{Request::is('dashboard/kategori-postingan') ? 'text-warning' : ''}}">Master
                                    Kategori</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a wire:navigate href="/dashboard/tag-postingan" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i>
                                <p class="{{Request::is('dashboard/tag-postingan') ? 'text-warning' : ''}}">Master
                                    Tag</p>
                            </a>
                        </li>
                    </ul>
                </li>
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
                            <a wire:navigate href="/dashboard/produk" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i>
                                <p class="{{Request::is('dashboard/produk*') ? 'text-warning' : ''}}">Master Produk</p>
                            </a>
                        </li>

                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a wire:navigate href="/dashboard/kategori-produk" class="nav-link">
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
                            <a wire:navigate href="/dashboard/proyek" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i>
                                <p class="{{ Request::is('dashboard/proyek*') ? 'text-warning' : '' }}">Master Proyek
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a wire:navigate href="/dashboard/aduan-masyarakat" class="nav-link {{ Request::is('dashboard/aduan-masyarakat') ? 'active' : '' }}">
                        <i class="bi bi-envelope-arrow-down"></i>
                      <p>
                        Aduan Masyarakat
                      </p>
                    </a>
                </li>

                <li class="nav-header">--Pengaturan--</li>

                <li class="nav-item {{ Request::is('dashboard/profil') || Request::is('dashboard/kelola-akun') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('dashboard/profil') || Request::is('dashboard/kelola-akun') ? 'active' : '' }}">
                        <i class="bi bi-person-fill-gear"></i>
                        <p>
                            Akun
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a wire:navigate href="/dashboard/profil" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i> <i class="bi bi-person-vcard-fill"></i>
                                <p class="{{ Request::is('dashboard/profil') ? 'text-warning' : '' }}">Ubah Profil</p>
                            </a>
                        </li>
                        @can('role','admin')
                        <li class="nav-item">
                            <a wire:navigate href="/dashboard/kelola-akun" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i> <i class="bi bi-people-fill"></i>
                                <p class="{{ Request::is('dashboard/kelola-akun') ? 'text-warning' : '' }}">Kelola Akun</p>
                            </a>
                        </li>
                        @endcan
                        
                    </ul>
                </li>
                
                @can('role','admin')
                <li class="nav-item {{ Request::is('dashboard/pengaturan') || Request::is('dashboard/profil-kami') || Request::is('dashboard/layanan-kami') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('dashboard/pengaturan') || Request::is('dashboard/profil-kami') || Request::is('dashboard/layanan-kami') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <p>
                            Aplikasi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a wire:navigate href="/dashboard/pengaturan" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i> <i class="bi bi-window-fullscreen"></i>
                                <p class="{{ Request::is('dashboard/pengaturan') ? 'text-warning' : '' }}">Pengaturan Aplikasi</p>
                            </a>
                            <a wire:navigate href="/dashboard/profil-kami" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i> <i class="bi bi-window-stack"></i>
                                <p class="{{ Request::is('dashboard/profil-kami') ? 'text-warning' : '' }}">Profil Kami</p>
                            </a>
                            <a wire:navigate href="/dashboard/layanan-kami" class="nav-link">
                                <i class="bi bi-arrow-return-right"></i> <i class="bi bi-window-stack"></i>
                                <p class="{{ Request::is('dashboard/layanan-kami') ? 'text-warning' : '' }}">Layanan Kami</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                


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
</div>