<div class="py-4">
    <div class="container">
        <h4 class="text-center">- App Settings -</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 25px;">
                    <div class="card-body">
                        <form wire:submit.prevent="saveSettings">
                            <div class="text-center mb-4">
                                @if ($image)
                                <!-- Preview saat gambar sedang diunggah -->
                                <div class="p-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>
                                @elseif ($appLogo)
                                <!-- Menampilkan gambar lama jika tidak ada upload baru -->
                                <img src="{{ asset('storage/' . $appLogo) }}" alt="App Logo"
                                    class="img-fluid img-thumbnail" width="100px">
                                @else
                                <p class="text-muted">No logo uploaded</p>
                                @endif

                                <!-- Loading bar saat upload -->
                                <br>
                                <div wire:loading wire:target="image" class="mt-2 col" style="width: 400px">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                            aria-valuemax="100">
                                            Mengunggah...
                                        </div>
                                    </div>
                                </div>

                                <!-- Input file -->
                                <div class="mt-3">
                                    <input type="file" wire:model="image">
                                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="appName" class="form-label">App Name</label>
                                <input type="text" id="appName" class="form-control" wire:model="appName">
                                @error('appName') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="footerText" class="form-label">Footer Text</label>
                                <textarea id="footerText" class="form-control" wire:model="footerText"></textarea>
                                @error('footerText') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="text" id="facebook" class="form-control" wire:model="facebook">
                                @error('facebook') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" id="instagram" class="form-control" wire:model="instagram">
                                @error('instagram') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" style="border-radius: 10px;"
                                    class="btn btn-primary">Simpan</button>
                            </div>
                        </form>





                        <div class="card-body">
                            <!-- Tombol untuk membuka modal -->
                            <button style="border-radius: 10px;" id="openModalBtn"
                                class="btn btn-dark mb-4 d-block d-md-inline-block">Tambah Link</button>

                            <!-- Input untuk mencari link-->
                            <div class="mb-2">
                                <input style="border-radius: 10px;" type="text" wire:model.live="search"
                                    placeholder="Cari link.." class="form-control" style="color: black;">

                                &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                            </div>

                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Link Judul</th>
                                        <th>Link Http</th>
                                        <th>Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($linkData as $index => $link)
                                    <tr>
                                        <td>{{ $linkData->firstItem() + $index }}</td>
                                        <!-- Menggunakan $linkData untuk iterasi -->
                                        <td>{{ $link->linkTitle }}</td>
                                        <td>{{ $link->linkHttp }}</td>
                                        <td>{{ $link->created_at }}</td>
                                        <td>{{ $link->updated_at }}</td>
                                        <td>
                                            <button style="border-radius: 10px;"
                                                wire:click="openUpdateModal({{ $link->id }})" class="btn btn-primary">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button style="border-radius: 10px;"
                                                wire:click="confirmDelete({{ $link->id }}, '{{ $link->linkTitle }}')"
                                                type="button" class="btn btn-danger text-white">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                        
                                    <tr>
                                        <td wire:loading.remove colspan="5" class="text-center">
                                            Tidak ada link yang ditemukan.</td>
        
        
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Tampilkan pagination jika data ada -->
                            <div class="d-flex justify-content-center">
                                {{ $linkData->links() }}
                                <!-- Pagination Livewire -->
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h4 class="text-center">- Beranda Settings -</h4>
    </div>
    <div class="container">
        {{-- Jumbotron --}}
        <div class="row">
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 25px;">
                    <div class="card-body">
                        <form wire:submit.prevent="saveJumbotronSettings">
                            <div class="text-center mb-4">
                                @if ($image2)
                                <!-- Preview saat gambar sedang diunggah -->
                                <div class="p-2">
                                    <img src="{{ $image2->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>
                                @elseif ($jumbotronImage)
                                <!-- Menampilkan gambar lama jika tidak ada upload baru -->
                                <img src="{{ asset('storage/' . $jumbotronImage) }}" alt="App Logo"
                                    class="img-fluid img-thumbnail" width="100px">
                                @else
                                <p class="text-muted">No image uploaded</p>
                                @endif

                                <!-- Loading bar saat upload -->
                                <br>
                                <div wire:loading wire:target="image2" class="mt-2 col" style="width: 400px">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                            aria-valuemax="100">
                                            Mengunggah...
                                        </div>
                                    </div>
                                </div>

                                <!-- Input file -->
                                <div class="mt-3">
                                    <input type="file" wire:model="image2">
                                    @error('image2') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jumbotronTitle" class="form-label">Jumbotron Title</label>
                                <input type="text" id="jumbotronTitle" class="form-control" wire:model="jumbotronTitle">
                                @error('jumbotronTitle') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jumbotronDescription" class="form-label">Jumbotron Description</label>
                                <textarea id="jumbotronDescription" class="form-control"
                                    wire:model="jumbotronDescription"></textarea>
                                @error('jumbotronDescription') <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" style="border-radius: 10px;"
                                    class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        {{-- OPD --}}
        <div class="row">
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 25px;">
                    <div class="card-body">
                        <form wire:submit.prevent="saveOpdSettings">
                            <div class="text-center mb-4">
                                @if ($image3)
                                <!-- Preview saat gambar sedang diunggah -->
                                <div class="p-2">
                                    <img src="{{ $image3->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>
                                @elseif ($opdImage)
                                <!-- Menampilkan gambar lama jika tidak ada upload baru -->
                                <img src="{{ asset('storage/' . $opdImage) }}" alt="App Logo"
                                    class="img-fluid img-thumbnail" width="100px">
                                @else
                                <p class="text-muted">No image uploaded</p>
                                @endif

                                <!-- Loading bar saat upload -->
                                <br>
                                <div wire:loading wire:target="image3" class="mt-2 col" style="width: 400px">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                            aria-valuemax="100">
                                            Mengunggah...
                                        </div>
                                    </div>
                                </div>

                                <!-- Input file -->
                                <div class="mt-3">
                                    <input type="file" wire:model="image3">
                                    @error('image3') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="opdTitle" class="form-label">Opd Title</label>
                                <input type="text" id="opdTitle" class="form-control" wire:model="opdTitle">
                                @error('opdTitle') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3" wire:ignore>
                                <label for="opdDescription" class="form-label">Opd Description</label>
                                <textarea id="opdDescription" class="form-control">{{ $opdDescription }}</textarea>
                                @error('opdDescription') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="opdName" class="form-label">Opd Name</label>
                                <input type="text" id="opdName" class="form-control" wire:model="opdName">
                                @error('opdName') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="opdPosition" class="form-label">Opd Position</label>
                                <input type="text" id="opdPosition" class="form-control" wire:model="opdPosition">
                                @error('opdPosition') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" style="border-radius: 10px;"
                                    class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ----------------Modal------------------------ --}}


    <!-- Modal Tambah Data -->
    <div id="addLinkModal" class="modal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="linkTitle">Link Judul</label>
                            <input type="text" placeholder="Ex: Website palukota.go.id" class="form-control"
                                id="linkTitle" wire:model="linkTitle">
                            @error('linkTitle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="linkHttp">Link Http</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://</span>
                                </div>
                                <input type="text" placeholder="Ex: palukota.go.id" class="form-control" id="linkHttp"
                                    wire:model="linkHttp">
                                @error('linkHttp') <span class="text-danger">{{ $message }}</span> @enderror
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
    <div class="modal fade" id="editLinkModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update">
                        <div class="form-group">
                            <label for="linkTitleUpdate">Link Judul</label>
                            <input type="text" placeholder="Ex: Website palukota.go.id" class="form-control"
                                id="linkTitleUpdate" wire:model="linkTitleUpdate">
                            @error('linkTitleUpdate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="linkHttpUpdate">Link Http</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://</span>
                                </div>
                                <input type="text" placeholder="Ex: palukota.go.id" class="form-control"
                                    id="linkHttpUpdate" wire:model="linkHttpUpdate">
                                @error('linkHttpUpdate') <span class="text-danger">{{ $message }}</span> @enderror
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
                        Hapus Link "{{ $linkTitle }}"
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus link ini?
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

    <!-- Bootstrap JS (Dibutuhkan oleh Summernote) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

    {{-- Init Summernote --}}
    <script>
        // summernote
        $(document).ready(function () {

            let debounceTimer;

            $('#opdDescription').summernote({
                height: 300,
                toolbar: [
                    // tambahkan toolbar sesuai dengan kebutuhan
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['view', ['codeview', 'help']]
                ],
                callbacks: {
                    onChange: function (contents, $editable) {
                        // Reset debounceTimer setiap kali ada perubahan
                        clearTimeout(debounceTimer);

                        debounceTimer = setTimeout(function () {
                            @this.set('opdDescription', contents); // Update model Livewire
                        }, 600); // 600ms
                    }
                }
            });
        });

    </script>

    {{-- Add Modal Form --}}
    <script>
        $(document).ready(function () {
            // Membuka modal ketika tombol ditekan
            $('#openModalBtn').click(function () {
                $('#addLinkModal').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('closeAddLinkModal', function (event) {
                $('#addLinkModal').modal('hide'); // Menutup modal
            });

            // Reset form di backend setelah modal ditutup
            $('#addLinkModal').on('hidden.bs.modal', function (e) {
                @this.call('resetForm'); // Reset input form di Livewire
            });

            // Jika modal ditutup, hapus backdrop jika ada
            $('#addLinkModal').on('hidden.bs.modal', function (e) {
                $('.modal-backdrop').remove(); // Hapus backdrop
            });
        });

    </script>

    {{-- Sweet alert,added success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('addedSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Link berhasil ditambahkan!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Edit Modal Form --}}
    <script>
        $(document).ready(function () {

            // Membuka modal Edit
            window.addEventListener('openEditLinkModal', function () {
                $('#editLinkModal').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('closeUpdatedModal', function () {
                $('#editLinkModal').modal('hide'); // Menutup modal

                // Menghapus backdrop ketika modal ditutup
                $('#editLinkModal').on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open'); // Hilangkan kelas modal-open pada body
                    $('.modal-backdrop').remove(); // Hapus modal-backdrop
                });
            });

            // Reset form di backend setelah modal ditutup
            $('#editLinkModal').on('hidden.bs.modal', function () {
                @this.call('resetForm'); // Memanggil fungsi resetForm di Component
            });
        });

    </script>

    {{-- Sweet alert,linkUpdated success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('linkUpdated', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Link berhasil diperbarui!",
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
                    text: "Link berhasil dihapus!",
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
