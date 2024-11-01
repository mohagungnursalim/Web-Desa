<div class="py-4">
    @push('styles')
    <!-- CSS Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
    @endpush
    <div class="container">

        <div class="card-body text-dark">

            <!-- Wrapper untuk memastikan tabel di tengah -->
            <div class="d-flex justify-content-center">

                <div class="w-100">

                    <!-- Tombol untuk membuka modal -->
                    <button style="border-radius: 10px;" id="openModalBtn"
                        class="btn btn-primary mb-4 d-block d-md-inline-block">
                        Tambah Proyek
                    </button>


                    <!-- Input untuk mencari proyek -->
                    <div class="mb-2">
                        <input style="border-radius: 10px;" type="text" wire:model.live.debounce.500ms="search"
                            placeholder="Cari proyek.." class="form-control" style="color: black;">

                        &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                    </div>

                    <div class="container-fluid">
                        <!-- End Row -->
                        <div class="row">
                            @if ($projects->isNotEmpty())
                            <div class="col-12 m-b-30">
                                <div class="row">
                                    @foreach ($projects as $index => $project)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card" style="border-radius: 25px;">

                                            @php
                                            $images = is_string($project->image) ? json_decode($project->image, true) :
                                            $project->image;
                                            @endphp

                                            @if($images && is_array($images) && count($images) > 0)
                                            <div id="projectCarousel{{ $project->id }}" class="carousel slide"
                                                data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    @foreach($images as $imageIndex => $img)
                                                    <li data-target="#projectCarousel{{ $project->id }}"
                                                        data-slide-to="{{ $imageIndex }}"
                                                        class="{{ $imageIndex == 0 ? 'active' : '' }}"></li>
                                                    @endforeach
                                                </ol>
                                                <div class="carousel-inner">
                                                    @foreach($images as $imageIndex => $img)
                                                    <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                                        <img style="border-top-left-radius: 20px; border-top-right-radius: 20px;"
                                                            class="d-block w-100" src="{{ asset('storage/' . $img) }}"
                                                            alt="{{ $project->project_name }} - Image {{ $imageIndex + 1 }}">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @if(count($images) > 1)
                                                <a class="carousel-control-prev"
                                                    href="#projectCarousel{{ $project->id }}" role="button"
                                                    data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next"
                                                    href="#projectCarousel{{ $project->id }}" role="button"
                                                    data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                                @endif
                                            </div>
                                            @elseif($project->image)
                                            <img class="img-fluid" src="{{ asset('storage/' . $project->image) }}"
                                                alt="{{ $project->project_name }}">
                                            @endif

                                            <div class="card-body">
                                                <h4 class="card-title"><b>{{ $project->project_name }}</b></h4><br>
                                                <td class="text-wrap small">
                                                    <span class="short-text">
                                                        {!!\Illuminate\Support\Str::limit(strip_tags($project->project_description),50) !!}
                                                        @if (\Illuminate\Support\Str::length(strip_tags($project->project_description)) > 50)
                                                        <span class="read-more-btn text-primary"
                                                            style="cursor: pointer;"
                                                            onclick="toggleDescription(this)">Selengkapnya</span>
                                                        @endif
                                                    </span>

                                                    @if (\Illuminate\Support\Str::length(strip_tags($project->project_description)) > 50)
                                                    <span class="full-text" style="display: none;">
                                                        {!! $project->project_description !!}
                                                        <span class="read-less-btn text-primary"
                                                            style="cursor: pointer;"
                                                            onclick="toggleDescription(this)">Lebih sedikit</span>
                                                    </span>
                                                    @endif
                                                </td>

                                                <div class="text-center">
                                                    <!-- Tombol untuk membuka modal update -->
                                                    <button style="border-radius: 10px;"
                                                        wire:click="openUpdateModal({{ $project->id }})"
                                                        class="btn btn-primary">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button style="border-radius: 10px;" wire:click="confirmDelete({{ $project->id }}, '{{ $project->project_name }}')"
                                                        class="btn btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <!-- Jika tidak ada data yang ditemukan -->
                            <div wire:loading.remove class="text-center text-secondary">
                                &nbsp;&nbsp; Proyek tidak ditemukan..
                            </div>
                            @endif
                        </div>


                    </div>


                    <!-- Tombol Load More -->
                    @if($projects->count() >= $limit && $totalProjects > $limit)
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

        <!-- Modal Tambah Project -->
        <div id="addProjectModal" class="modal fade" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Proyek</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <form wire:submit.prevent="store">
                            <!-- Form input -->
                            <div class="form-group">
                                <label for="image">Gambar Proyek</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Gambar</span>
                                    </div>
                                    <div class="custom-file">
                                        <input multiple type="file" id="image" class="custom-file-input"
                                            wire:model="image">
                                        <label class="custom-file-label" for="image">
                                            @if ($image)
                                            File dipilih:{{ count($image) }}
                                            @else
                                            Pilih gambar
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                @error('image') <span class="text-danger error">{{ $message }}</span> @enderror
                                <div class="d-flex flex-wrap mt-2">
                                    @if ($image)
                                    @foreach ($image as $img)
                                    <div class="p-2">
                                        <img src="{{ $img->temporaryUrl() }}" alt="Preview"
                                            class="img-fluid img-thumbnail" width="100px">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div wire:loading wire:target="image" class="mt-2 col" style="width: 400px">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 100%" aria-valuenow="100"
                                            aria-valuemin="100" aria-valuemax="100">
                                            Mengunggah...
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="project_name">Nama Proyek</label>
                                <input type="text" class="form-control" id="project_name"
                                    wire:model.defer="project_name" placeholder="Masukan nama project">
                                @error('project_name') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>

                            <div wire:ignore class="form-group">
                                <label for="project_description">Deskripsi Proyek</label>
                                <textarea class="form-control" id="project_description"
                                    wire:model.defer="project_description"
                                    placeholder="Masukan deskripsi project"></textarea>
                            </div>
                            @error('project_description') <span class="text-danger error">{{ $message }}</span>
                            @enderror

                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" wire:model.defer="start_date">
                                @error('start_date') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="end_date" wire:model.defer="end_date">
                                @error('end_date') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <!-- Tombol untuk menyimpan data -->
                        <button style="border-radius: 10px;" type="button" class="btn btn-secondary" wire:loading.remove
                            wire:target='store' data-dismiss="modal">Tutup</button>
                        <button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
                            wire:click="store">Simpan</button>
                        <button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
                            wire:target='store'>
                            Menyimpan <span class="spinner-grow spinner-grow-sm" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Proyek</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <form wire:submit.prevent="update">
                            <!-- Input untuk gambar -->
                            <div class="form-group">
                                <label for="image">Gambar Proyek</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Gambar</span>
                                    </div>
                                    <div class="custom-file">
                                        <input multiple type="file" id="image" class="custom-file-input"
                                            wire:model="image">
                                        <label class="custom-file-label" for="image">
                                            @if ($image)
                                            File dipilih: {{ count($image) }}
                                            @else
                                            Pilih gambar
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                @error('image') <span class="text-danger error">{{ $message }}</span> @enderror

                                <!-- Preview gambar yang sudah ada di database -->
                                @if($existingImages && is_array($existingImages) && count($existingImages) > 0)
                                <div class="d-flex flex-wrap">
                                    @foreach($existingImages as $img)
                                    <div class="p-2">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Gambar Proyek"
                                            class="img-fluid img-thumbnail" width="100px">
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p>Tidak ada gambar tersimpan.</p>
                                @endif

                                <!-- Preview gambar yang dipilih -->
                                @if($image)
                                <div class="mt-3 preview">
                                    <p>Preview Gambar Baru:</p>
                                    <div class="d-flex flex-wrap">
                                        @foreach($image as $img)
                                        <div class="p-2">
                                            <img src="{{ $img->temporaryUrl() }}" alt="Preview Gambar"
                                                class="img-fluid img-thumbnail" width="100px">
                                        </div>
                                        @endforeach
                                    </div>
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

                            <!-- Form lainnya -->
                            <div class="form-group">
                                <label for="project_name">Nama Proyek</label>
                                <input type="text" class="form-control" id="project_name" wire:model="project_name">
                                @error('project_name') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>

                            <div wire:ignore class="form-group">
                                <label for="project_description_edit">Deskripsi Proyek</label>
                                <textarea id="project_description_edit" class="form-control summernote"
                                    wire:model.defer="project_description"></textarea>
                            </div>
                            @error('project_description') <span class="text-danger error mb-1">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" wire:model="start_date">
                                @error('start_date') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="end_date" wire:model="end_date">
                                @error('end_date') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button style="border-radius: 10px;" type="button" class="btn btn-secondary" wire:loading.remove
                            wire:target='update' data-dismiss="modal">Tutup</button>
                        <button style="border-radius: 10px;" type="button" class="btn btn-primary" wire:loading.remove
                            wire:click="update">Simpan</button>
                        <button style="border-radius: 10px;" type="button" class="btn btn-primary" disabled wire:loading
                            wire:target='update'>
                            Menyimpan <span class="spinner-grow spinner-grow-sm" role="status"
                                aria-hidden="true"></span>
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
                            Hapus Proyek "{{ $projectName }}"
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        Apakah anda yakin ingin menghapus proyek ini?
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button style="border-radius: 10px;" wire:loading.remove wire:target='delete' type="button"
                            class="btn btn-secondary" data-dismiss="modal">Batal
                        </button>
                        <button style="border-radius: 10px;" wire:loading.remove wire:click="delete" type="button"
                            class="btn btn-danger">Hapus
                        </button>

                        <button style="border-radius: 10px;" wire:loading wire:target='delete'
                            class="btn btn-danger" disabled>
                            Menghapus <span class="spinner-grow spinner-grow-sm" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        @push('scripts')

        <!-- Summernote JS -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

        {{-- Modal Add --}}
        <script>
            $(document).ready(function () {
                // Membuka modal ketika tombol ditekan
                $('#openModalBtn').click(function () {
                    $('#addProjectModal').modal('show');

                    @this.set('project_name', '');
                    @this.set('start_date', '');
                    @this.set('end_date', '');
                });

                // Mendengarkan event dari Livewire untuk menutup modal
                window.addEventListener('closeAddProjectModal', function (event) {
                    $('#addProjectModal').modal('hide'); // Menutup modal
                });

                // Reset form di backend setelah modal ditutup
                $('#addProjectModal').on('hidden.bs.modal', function (e) {
                    @this.call('resetForm');
                    @this.set('project_name', '');
                    @this.set('start_date', '');
                    @this.set('end_date', '');
                });

                $('#addProjectModal').on('hidden.bs.modal', function (e) {
                    $('#project_description').summernote('code', ''); // Reset Summernote
                    @this.set('project_description', ''); // Reset Livewire model
                });
                // Jika modal ditutup, hapus backdrop jika ada
                $('#addProjectModal').on('hidden.bs.modal', function (e) {
                    $('.modal-backdrop').remove(); // Hapus backdrop
                });
            });

        </script>

        {{-- Summernote add --}}
        <script data-navigate-once>
            document.addEventListener('livewire:navigated', () => {
                $(document).ready(function () {

                    let debounceTimer;

                    $('#project_description').summernote({
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
                                    @this.set('project_description',
                                        contents); // Update model Livewire
                                }, 800); // 800ms
                            }
                        }
                    });
                });
            })

        </script>

        {{-- Edit Modal --}}
        <script>
            $(document).ready(function () {

                // Membuka modal Edit
                window.addEventListener('openEditProjectModal', function () {
                    $('#editProjectModal').modal('show');
                });

                // Mendengarkan event dari Livewire untuk menutup modal
                window.addEventListener('closeEditProjectModal', function () {
                    $('#editProjectModal').modal('hide'); // Menutup modal

                    // Menghapus backdrop ketika modal ditutup
                    $('#editProjectModal').on('hidden.bs.modal', function () {
                        $('body').removeClass(
                        'modal-open'); // Hilangkan kelas modal-open pada body
                        $('.modal-backdrop').remove(); // Hapus modal-backdrop
                    });
                });

                // Reset form di backend setelah modal ditutup
                $('#editProjectModal').on('hidden.bs.modal', function () {
                    @this.call('resetForm'); // Memanggil fungsi resetForm di Livewire
                    @this.set('project_name', '');
                    @this.set('start_date', '');
                    @this.set('end_date', '');
                    @this.set('project_description', ''); // Reset Livewire model
                });
            });

        </script>

        {{-- Summernote Edit --}}
        <script>
            $(document).ready(function () {
                let debounceTimer;

                function initSummernoteEdit() {
                    $('#project_description_edit').summernote({
                        height: 150,
                        toolbar: [
                            ['font', ['bold', 'italic', 'underline', 'clear']],
                            ['para', ['ul', 'ol']],
                            ['view', ['codeview', 'help']]
                        ],
                        callbacks: {
                            onChange: function (contents, $editable) {
                                clearTimeout(debounceTimer);
                                debounceTimer = setTimeout(function () {
                                    @this.set('project_description',
                                    contents); // Set value ke Livewire
                                }, 800); //800ms
                            }
                        }
                    });
                }

                // Inisialisasi Summernote saat modal ditampilkan
                $('#editProjectModal').on('shown.bs.modal', function () {
                    initSummernoteEdit();
                });

                // Hapus Summernote ketika modal ditutup
                $('#editProjectModal').on('hidden.bs.modal', function (e) {
                    $('#project_description_edit').summernote('destroy'); // Hapus instance Summernote
                });
            });

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

        {{-- Hide/Show Project Description --}}
        <script>
            function toggleDescription(element) {
                // Dapatkan elemen-elemen terkait
                var shortText = element.parentElement.parentElement.querySelector('.short-text');
                var fullText = element.parentElement.parentElement.querySelector('.full-text');

                // Periksa apakah teks pendek sedang ditampilkan
                if (shortText.style.display === 'none') {
                    // Jika teks pendek tersembunyi, tampilkan teks pendek dan sembunyikan teks penuh
                    shortText.style.display = 'inline';
                    fullText.style.display = 'none';
                } else {
                    // Jika teks pendek terlihat, sembunyikan teks pendek dan tampilkan teks penuh
                    shortText.style.display = 'none';
                    fullText.style.display = 'inline';
                }
            }

        </script>

        {{-- Sweet alert,added success --}}
        <script>
            $(document).ready(function () {
                window.addEventListener('addedSuccess', function (event) {
                    Swal.fire({
                        title: "Sukses!",
                        text: "Proyek berhasil ditambahkan!",
                        icon: "success",
                        timer: 1000,
                        timerProgressBar: true,
                    });
                });
            })

        </script>

        {{-- Sweet alert,project updated --}}
        <script>
            $(document).ready(function () {
                window.addEventListener('projectUpdated', function (event) {
                    Swal.fire({
                        title: "Sukses!",
                        text: "Proyek berhasil diperbarui!",
                        icon: "success",
                        timer: 1000,
                        timerProgressBar: true,
                    });
                });
            })

        </script>

        {{-- Sweet alert,delete success --}}
        <script>
            $(document).ready(function () {
                window.addEventListener('deleteSuccess', function (event) {
                    Swal.fire({
                        title: "Sukses!",
                        text: "Proyek berhasil dihapus!",
                        icon: "success",
                        timer: 1000,
                        timerProgressBar: true,
                    });
                });
            })

        </script>

        @endpush

    </div>
