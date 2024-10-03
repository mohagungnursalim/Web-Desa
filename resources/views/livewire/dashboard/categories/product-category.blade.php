<div class="py-4">
    @push('styles')
    @endpush
    <div class="container-fluid col-md">
        <div class="card">
            <div class="card-body">
                <!-- Tombol untuk membuka modal -->
                <button wire:click="$set('isModalOpen', true)"  class="btn btn-primary mb-4 d-block d-md-inline-block">Tambah Kategori Produk</button>

                <!-- Input untuk mencari kategori produk -->
                <div class="mb-2">
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari kategori.."
                        class="form-control" style="color: black;">

                    &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                </div>

                <table class="table table-responsive-md">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Dibuat</th>
                            <th>Diperbarui</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>


                        @forelse ($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <!-- Tombol untuk membuka modal update -->
                                <button wire:click="openUpdateModal({{ $category->id }})" class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                </button>
                                <button data-toggle="modal" data-target="#modalDelete{{ $category->id }}" type="button"
                                    class="btn btn-danger text-white" style="border: none">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada kategori yang ditemukan.</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>


                <!-- Tombol Load More -->
                @if($categories->count() >= $limit && $totalCategories > $limit)
                <div class="mt-4 d-flex justify-content-center">
                    <!-- Tombol "Tampilkan Lebih" (akan hilang saat loading) -->
                    <button wire:click="loadMore" class="btn btn-info btn-rounded" wire:loading.remove
                        wire:target="loadMore">
                        Tampilkan Lebih
                    </button>

                    <!-- Tombol Loading (hanya muncul saat loading) -->
                    <button class="btn btn-info  btn-rounded" type="button" disabled wire:loading
                        wire:target="loadMore">
                        Memuat.. <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>


    {{-- ----------------Modal------------------------ --}}

    {{-- Modal Tambah Data --}}
    @if($isModalOpen)
    <div class="modal show d-block" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Produk</h5>
                    <button type="button" class="close" wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input type="text" placeholder="Masukan nama kategori.." class="form-control" id="name"
                                wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" wire:loading.remove wire:target='store' wire:click="closeModal">Tutup</button>
                    <button type="button" class="btn btn-primary" wire:loading.remove wire:click="store">Simpan</button>
                    <button type="button" class="btn btn-primary" disabled wire:loading wire:target='store'>
                        Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop show"></div>
    @endif


   <!-- Modal update -->
@if($isUpdateModalOpen)
<div class="modal show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Kategori</h5>
                <button type="button" class="close" wire:click="closeUpdateModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="update">
                    <div class="form-group">
                        <label for="categoryName">Nama Kategori</label>
                        <input type="text" class="form-control" id="categoryName" wire:model="categoryName">
                        @error('categoryName') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeUpdateModal">Tutup</button>
                <button type="button" class="btn btn-primary" wire:click="update">Simpan</button>
            </div> --}}
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" wire:loading.remove wire:target='update' wire:click="closeUpdateModal">Tutup</button>
                <button type="button" class="btn btn-primary" wire:loading.remove wire:click="update">Simpan</button>
                <button type="button" class="btn btn-primary" disabled wire:loading wire:target='update'>
                    Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

    
    {{-- Modal Delete --}}
    @foreach ($categories as $category)

    <div class="modal" id="modalDelete{{ $category->id }}" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModalLabel{{ $category->id }}">
                        Hapus Kategori Produk "{{ $category->name }}" </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus kategori ini?
                </div>
                <div class="modal-footer justify-content-center">
                    <button wire:loading.remove wire:target='delete({{ $category->id }})' type="button"
                        class="btn btn-secondary" data-dismiss="modal">Batal
                    </button>
                    <button wire:loading.remove wire:click="delete({{ $category->id }})" type="button"
                        class="btn btn-danger">Hapus
                    </button>

                    <button wire:loading wire:target='delete({{ $category->id }})' class="btn btn-danger" disabled>
                        Menghapus <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @endforeach

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Sweet alert,added success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('addedSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Kategori berhasil ditambahkan!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>
    {{-- Sweet alert,categoryUpdated success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('categoryUpdated', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Kategori berhasil diperbarui!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    <script>
        $(document).ready(function () {
            window.addEventListener('hideModalDelete', function (event) {
                var modalId = event.detail;

                if (Array.isArray(modalId)) {
                    modalId = modalId[0];
                }

                if (typeof modalId === 'string' && modalId.trim() !== '') {
                    var $modal = $('#' + modalId);

                    // Menutup modal
                    $modal.modal('hide');

                    // Fungsi untuk membersihkan modal dan backdrop
                    function cleanupModal() {
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $modal.removeClass('show');
                        $modal.css('display', 'none');
                        $('body').css('overflow', '');
                        $('body').css('padding-right', '');
                    }

                    // Mencoba membersihkan setelah animasi modal selesai
                    $modal.on('hidden.bs.modal', cleanupModal);

                    // Backup: jika event tidak terpicu, bersihkan setelah delay
                    setTimeout(cleanupModal, 500);
                } else {
                    console.error('Invalid modal ID:', modalId);
                }
            });
        });

    </script>

    {{-- Sweet alert,delete success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('deleteSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Kategori berhasil dihapus!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Sweet alert,delete gagal --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('deleteError', function (event) {
                Swal.fire({
                    title: "Oops!",
                    text: "Kategori gagal dihapus!",
                    icon: "error",
                    timer: 1500,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    @endpush
</div>
