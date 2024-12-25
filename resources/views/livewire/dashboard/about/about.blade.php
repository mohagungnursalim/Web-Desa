<div class="py-4">
    @push('styles')
    @endpush
    <div class="container-fluid col-md">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body">
                <!-- Tombol untuk membuka modal -->
                <button style="border-radius: 10px;" id="openModalBtn"
                    class="btn btn-primary mb-4 d-block d-md-inline-block">Tambah </button>


                <!-- Input untuk mencari -->
                <div class="mb-2">
                    <input style="border-radius: 10px;" type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Cari.." class="form-control" style="color: black;">

                    &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                </div>

                <div wire:init="loadInitialAbouts">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Dibuat</th>
                                <th>Diperbarui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>


                            @forelse ($abouts as $index => $about)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $about->title }}</td>
                                <td>{!! $about->description !!}</td>
                                <td>{{ $about->created_at }}</td>
                                <td>{{ $about->updated_at }}</td>
                                <td>
                                    <!-- Tombol untuk membuka modal update -->
                                    <button style="border-radius: 10px;"
                                        wire:click="openUpdateModal({{ $about->id }})" class="btn btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- Tombol untuk membuka modal delete -->
                                    <button style="border-radius: 10px;"
                                        wire:click="confirmDelete({{ $about->id }}, '{{ $about->title }}' )"
                                        type="button" class="btn btn-danger text-white">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td wire:loading.remove wire:target="loadInitialAbouts" colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
                            </tr>
                            @endforelse


                        </tbody>
                    </table>
                    <div class="text-center">
                        <!-- Loading saat memuat data pertama kali -->
                        <p wire:loading wire:target="loadInitialAbouts" class="text-center">Memuat data..<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        </p>
                    </div>
                </div>

                <!-- Tombol Load More -->
                @if($abouts->count() >= $limit && $totalAbouts > $limit)
                <div class="mt-4 d-flex justify-content-center">
                    <!-- Tombol "Tampilkan Lebih" (akan hilang saat loading) -->
                    <button style="border-radius: 20px;" wire:click="loadMore" class="btn btn-dark btn-rounded"
                        wire:loading.remove wire:target="loadMore">
                        Tampilkan Lebih
                    </button>

                    <!-- Tombol Loading (hanya muncul saat loading) -->
                    <button style="border-radius: 20px;" class="btn btn-dark  btn-rounded" type="button" disabled
                        wire:loading wire:target="loadMore">
                        Memuat.. <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
                @endif


            </div>
        </div>
    </div>


    {{-- ----------------Modal------------------------ --}}


    <!-- Modal Tambah Data -->
    <div id="addAboutModal" class="modal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" placeholder="Masukan judul.." class="form-control" id="title"
                                wire:model="title">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
						<div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea placeholder="Masukan deskripsi.." class="form-control" id="description"
                                wire:model="description"> 
							</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:loading.remove wire:target="store">Tutup</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
                        wire:click="store">Simpan</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
                        wire:target="store">
                        Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit -->
    <div class="modal fade" id="editAboutModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update">
                        <div class="form-group">
                            <label for="aboutTitle">Nama Kategori</label>
                            <input type="text" class="form-control" id="aboutTitle" wire:model="aboutTitle">
                            @error('aboutTitle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
						<div class="form-group">
                            <label for="aboutDescription">Deskripsi</label>
                            <textarea placeholder="Masukan deskripsi.." class="form-control" id="aboutDescription"
                                wire:model="aboutDescription"> 
							</textarea>
                            @error('aboutDescription') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        

                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" type="button" class="btn btn-secondary" wire:loading.remove
                        wire:target='update' data-dismiss="modal" aria-label="Close">Tutup</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
                        wire:click="update">Simpan</button>
                    <button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
                        wire:target='update'>
                        Menyimpan <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModalLabel">
                        Hapus Data "{{ $aboutTitle }}"
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" wire:loading.remove wire:target='delete' type="button"
                        class="btn btn-secondary" data-dismiss="modal">Batal
                    </button>
                    <button style="border-radius: 10px;" wire:loading.remove wire:click="delete" type="button"
                        class="btn btn-danger">Hapus
                    </button>

                    <button style="border-radius: 10px;" wire:loading wire:target='delete' class="btn btn-danger"
                        disabled>
                        Menghapus <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    {{-- Add Modal Form --}}
    <script>
        $(document).ready(function () {
            // Membuka modal ketika tombol ditekan
            $('#openModalBtn').click(function () {
                $('#addAboutModal').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('closeAddAboutModal', function (event) {
                $('#addAboutModal').modal('hide'); // Menutup modal
            });

            // Reset form di backend setelah modal ditutup
            $('#addAboutModal').on('hidden.bs.modal', function (e) {
                @this.call('resetForm'); // Reset input form di Livewire
            });

            // Jika modal ditutup, hapus backdrop jika ada
            $('#addAboutModal').on('hidden.bs.modal', function (e) {
                $('.modal-backdrop').remove(); // Hapus backdrop
            });
        });

    </script>

    {{-- Edit Modal Form --}}
    <script>
        $(document).ready(function () {
            // Membuka modal edit
            window.addEventListener('openEditAboutModal', function (e) {
                $('#editAboutModal').modal('show');
            });

            // Menutup modal
            window.addEventListener('closeUpdatedModal', function (e) {
                $('#editAboutModal').modal('hide');

                // Hapus backdrop
                $('#editAboutModal').on('hidden.bs.modal', function (e) {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            });

            // Reset form
            $('#editAboutModal').on('hidden.bs.modal', function (e) {
                @this.call('resetForm');
            })

        })

    </script>

    {{-- Sweet alert,added success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('addedSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Berhasil ditambahkan!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>
    {{-- Sweet alert,aboutUpdated success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('aboutUpdated', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Berhasil diperbarui!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Delete Modal --}}
    <script>
        $(document).ready(function () {

            // Membuka modal Delete
            window.addEventListener('show-delete-modal', function () {
                $('#modalDelete').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('hide-delete-modal', function () {
                $('#modalDelete').modal('hide'); // Menutup modal

                // Menghapus backdrop ketika modal ditutup
                $('#modalDelete').on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open'); // Hilangkan kelas modal-open pada body
                    $('.modal-backdrop').remove(); // Hapus modal-backdrop
                });
            });

        });

    </script>

    {{-- Sweet alert,delete success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('deleteSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Berhasil dihapus!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Sweet alert,error --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('error', function (event) {
                Swal.fire({
                    title: "Oops!",
                    text: "Data tidak valid/sudah terhapus.",
                    icon: "error",
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton: true,
                });
            });
        })

    </script>

    @endpush
</div>
