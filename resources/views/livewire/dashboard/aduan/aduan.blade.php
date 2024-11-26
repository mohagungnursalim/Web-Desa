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
                        <tr @if($aduan->is_read == null) style="background-color:rgb(226, 226, 226)" @else @endif >
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

                                <!-- Tombol untuk membuka modal detail -->
                                <button style="border-radius: 10px;"
                                    wire:click="showPostDetail({{ $aduan->id }},'{{ $aduan->name }}','{{ $aduan->wa_number }}','{{ $aduan->image }}','{{ $aduan->description }}')"
                                    type="button" class="btn btn-secondary text-white mb-1 me-2">
                                    <!-- Tambahkan kelas me-2 untuk margin di sebelah kanan -->
                                    <i class="bi bi-eye"></i>
                                </button>

                                <!-- Tombol untuk membuka modal delete -->
                                <button style="border-radius: 10px;"
                                    wire:click="confirmDelete({{ $aduan->id }}, '{{ $aduan->name }}' )" type="button"
                                    class="btn btn-danger text-white">
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


    {{-- Modal Detail --}}
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title">
                        <b>{{ $aduanName}}</b>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"
                    style="padding-left: 200px; padding-right: 200px; max-height: 75vh; overflow-y: auto;">
                    <div class="text-center mb-3">
                        @if ($aduanId && is_array($aduanImage))
                        @foreach ($aduanImage as $image)
                        <img class="img-thumbnail" src="{{ asset('storage/' . $image) }}" alt="{{ $aduanName }}"
                            style="width: 520px; margin-bottom: 10px;">
                        @endforeach
                        @else
                        <p>Gambar tidak tersedia.</p>
                        @endif
                    </div>
                    <div class="post-content">

                        {!! $aduanDescription !!}
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;" type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tutup
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
                        Hapus Aduan "{{ $aduanName }}"
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus aduan ini?
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


    {{-- Detail Modal --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('show-detail-modal', function () {
                $('#modalDetail').modal('show');
            });

            function cleanupModal() {
                $('#modalDetail').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }

            // Bersihkan backdrop saat modal ditutup
            $('#modalDetail').on('hidden.bs.modal', cleanupModal);
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
            });

        });

    </script>

    {{-- Sweet alert,delete success --}}
    <script>
        $(document).ready(function () {
            window.addEventListener('deleteSuccess', function (event) {
                Swal.fire({
                    title: "Sukses!",
                    text: "Aduan berhasil dihapus!",
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
                    text: "Aduan gagal dihapus!",
                    icon: "error",
                    timer: 1500,
                    timerProgressBar: true,
                });
            });
        })

    </script>

    @endpush
</div>
