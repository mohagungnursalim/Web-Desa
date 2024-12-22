<div class="py-4">
    @push('styles')
    <style>
        .image-wrapper img {
            width: 100%;
            height: auto;
            transition: opacity 1s ease-in-out; /* Efek transisi */
            opacity: 0; /* Gambar asli dimulai dengan opacity 0 */
        }

        .image-wrapper img.lazyloaded {
            opacity: 1; /* Gambar asli menjadi terlihat */
        }

        
    </style>
    @endpush
    <div class="container-fluid col-md">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body">
                <!-- Tombol untuk membuka modal -->
                <button style="border-radius: 10px;" id="openModalBtn"
                    class="btn btn-primary mb-4 d-block d-md-inline-block">Tambah Kategori
                    Postingan</button>


                <!-- Input untuk mencari kategori postingan -->
                <div class="mb-2">
                    <input style="border-radius: 10px;" type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Cari kategori.." class="form-control" style="color: black;">

                    &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                </div>

                <div wire:init="loadInitialCategories">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Image</th>
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
                                <td class="image-wrapper">
                                    <img data-src="{{ asset('storage/' . $category->image) }}" style="width: 45px"
                                        alt="{{ $category->name }}" class="lazyload">
                                </td>
                                <td>{{ $category->created_at }}</td>
                                <td>{{ $category->updated_at }}</td>
                                <td>
                                    <!-- Tombol untuk membuka modal update -->
                                    <button style="border-radius: 10px;"
                                        wire:click="openUpdateModal({{ $category->id }})" class="btn btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- Tombol untuk membuka modal delete -->
                                    <button style="border-radius: 10px;"
                                        wire:click="confirmDelete({{ $category->id }}, '{{ $category->name }}' )"
                                        type="button" class="btn btn-danger text-white">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td wire:loading.remove wire:target="loadInitialCategories" colspan="7" class="text-center">Tidak ada kategori yang ditemukan.</td>
                            </tr>
                            @endforelse


                        </tbody>
                    </table>
                    <div class="text-center">
                        <!-- Loading saat memuat data pertama kali -->
                        <p wire:loading wire:target="loadInitialCategories" class="text-center">Memuat data..<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        </p>
                    </div>
                </div>

                <!-- Tombol Load More -->
                @if($categories->count() >= $limit && $totalCategories > $limit)
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
    <div id="addCategoryModal" class="modal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Postingan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        <div class="form-group">
                            <label for="image">Gambar Kategori</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Gambar</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" id="image" class="custom-file-input" wire:model="image">
                                    <label class="custom-file-label" for="image">
                                        @if ($image)
                                        File dipilih: {{ is_array($image) ? count($image) : 1 }}
                                        @else
                                        Pilih gambar
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @error('image') <span class="text-danger error">{{ $message }}</span> @enderror
                            <div class="d-flex flex-wrap mt-2">
                                @if ($image)

                                <div class="p-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>

                                @endif
                            </div>
                            <div wire:loading wire:target="image" class="mt-2 col" style="width: 400px">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100"
                                        aria-valuemax="100">
                                        Mengunggah...
                                    </div>
                                </div>
                            </div>
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

    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Update Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

                        <div class="form-group">
                            <label for="image">Gambar Kategori</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Gambar</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" id="image" class="custom-file-input" wire:model="image">
                                    <label class="custom-file-label" for="image">
                                        @if ($image)
                                        File dipilih: {{ is_array($image) ? count($image) : 1 }}
                                        @else
                                        Pilih gambar
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @error('image') <span class="text-danger error">{{ $message }}</span> @enderror


                            <div class="d-flex flex-wrap mt-2">
                                @if ($imageUpdate)
                                <!-- Tampilkan gambar lama -->
                                <div class="p-2 image-wrapper">
                                    <img data-src="{{ asset('storage/' . $imageUpdate) }}" alt="Gambar Lama"
                                        class="img-fluid img-thumbnail lazyload" width="100px">
                                </div>
                                @endif
                                @if ($image)
                                <p>Gambar baru👉</p>
                                <div class="p-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>
                                @endif
                            </div>


                            <div wire:loading wire:target="image" class="mt-2 col" style="width: 400px">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="100"
                                        aria-valuemax="100">
                                        Mengunggah...
                                    </div>
                                </div>
                            </div>
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
                        Hapus Kategori "{{ $postCategoryName }}"
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus kategori ini?
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    {{-- Add Modal Form --}}
    <script>
        $(document).ready(function () {
            // Membuka modal ketika tombol ditekan
            $('#openModalBtn').click(function () {
                $('#addCategoryModal').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('closeAddCategoryModal', function (event) {
                $('#addCategoryModal').modal('hide'); // Menutup modal
            });

            // Reset form di backend setelah modal ditutup
            $('#addCategoryModal').on('hidden.bs.modal', function (e) {
                @this.call('resetForm'); // Reset input form di Livewire
            });

            // Jika modal ditutup, hapus backdrop jika ada
            $('#addCategoryModal').on('hidden.bs.modal', function (e) {
                $('.modal-backdrop').remove(); // Hapus backdrop
            });
        });

    </script>

    {{-- Edit Modal Form --}}
    <script>
        $(document).ready(function () {
            // Membuka modal edit
            window.addEventListener('openEditCategoryModal', function (e) {
                $('#editCategoryModal').modal('show');
            });

            // Menutup modal
            window.addEventListener('closeUpdatedModal', function (e) {
                $('#editCategoryModal').modal('hide');

                // Hapus backdrop
                $('#editCategoryModal').on('hidden.bs.modal', function (e) {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            });

            // Reset form
            $('#editCategoryModal').on('hidden.bs.modal', function (e) {
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
