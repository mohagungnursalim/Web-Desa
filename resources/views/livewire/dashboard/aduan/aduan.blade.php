<div class="py-4">
    @push('styles')
    @endpush
    <div class="container-fluid col-md">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body">

                <!-- Input untuk mencari tag -->
                <div class="mb-2">
                    <input style="border-radius: 10px;" type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Cari aduan.." class="form-control" style="color: black;">

                    &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                </div>

                <table class="table table-responsive-md">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No.WA</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Dibuat</th>
                            <th>Diperbarui</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>


                        @forelse ($aduans as $index => $aduan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $aduan->name }}</td>
                            <td>{{ $aduan->wa_number }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $aduan->image) }}" style="width: 45px"
                                    alt="{{ $aduan->name }}">
                            </td>
                            <td>{{ $aduan->description }}</td>
                            <td>{{ $aduan->created_at }}</td>
                            <td>{{ $aduan->updated_at }}</td>
                            <td>
                                <!-- Tombol untuk membuka modal update -->
                                <button style="border-radius: 10px;" wire:click="openUpdateModal({{ $aduan->id }})"
                                    class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Tombol untuk membuka modal delete -->
                                <button style="border-radius: 10px;" wire:click="confirmDelete({{ $aduan->id }}, '{{ $aduan->name }}' )" type="button" class="btn btn-danger text-white">
                                    <i class="bi bi-trash3"></i>
                                </button> 
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada aduan yang ditemukan.</td>
                        </tr>
                        @endforelse


                    </tbody>
                </table>


                <!-- Tombol Load More -->
                @if($aduans->count() >= $limit && $totalAduans > $limit)
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


        {{-- Modal Delete --}}
        {{-- <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header">
                        <h6 class="modal-title" id="deleteModalLabel">
                            Hapus Tag "{{ $postTagName }}"
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        Apakah anda yakin ingin menghapus tag ini?
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
        </div> --}}

    @push('scripts')

    {{-- Add Modal Form --}}
    <script>
        $(document).ready(function () {
            // Membuka modal ketika tombol ditekan
            $('#openModalBtn').click(function () {
                $('#addTagModal').modal('show');
            });

            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('closeAddTagModal', function (event) {
                $('#addTagModal').modal('hide'); // Menutup modal
            });

            // Reset form di backend setelah modal ditutup
            $('#addTagModal').on('hidden.bs.modal', function (e) {
                @this.call('resetForm'); // Reset input form di Livewire
            });

            // Jika modal ditutup, hapus backdrop jika ada
            $('#addTagModal').on('hidden.bs.modal', function (e) {
                $('.modal-backdrop').remove(); // Hapus backdrop
            });
        });

    </script>

    {{-- Edit Modal Form --}}
    <script>
        $(document).ready(function () {
            
            // Membuka modal Edit
            window.addEventListener('openEditTagModal', function () {
                $('#editTagModal').modal('show');
            });
    
            // Mendengarkan event dari Livewire untuk menutup modal
            window.addEventListener('closeUpdatedModal', function () {
                $('#editTagModal').modal('hide'); // Menutup modal
                
                // Menghapus backdrop ketika modal ditutup
                $('#editTagModal').on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open'); // Hilangkan kelas modal-open pada body
                    $('.modal-backdrop').remove(); // Hapus modal-backdrop
                });
            });
    
            // Reset form di backend setelah modal ditutup
            $('#editTagModal').on('hidden.bs.modal', function () {
                @this.call('resetForm'); // Memanggil fungsi resetForm di Component
            });
        });
    </script>

    {{-- Sweet alert,added success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('addedSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Tag berhasil ditambahkan!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    {{-- Sweet alert,tagUpdated success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('tagUpdated', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Tag berhasil diperbarui!",
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
                    text: "Tag berhasil dihapus!",
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
                    text: "Tag gagal dihapus!",
                    icon: "error",
                    timer: 1500,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    @endpush
</div>
