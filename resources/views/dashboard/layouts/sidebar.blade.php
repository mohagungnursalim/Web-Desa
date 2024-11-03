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
    @livewire('dashboard.sidebar.sidebar')

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
