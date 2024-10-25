<div class="py-4">
    @push('styles')
   <style>
    .post-content img {
        max-width: 100%;
        height: auto;
      
    }
   </style>
    @endpush
    <div class="container-fluid col-md">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body" style="padding: 20px;">
                <!-- Tombol untuk membuka modal -->
                <a href="/dashboard/postingan/tambah-data" style="border-radius: 10px;" class="btn btn-primary mb-4">Tambah
                    Postingan</a>

                <!-- Input untuk mencari postingan -->
                <div class="mb-2">
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari postingan.."
                        class="form-control" style="color: black; border-radius: 10px;">

                    &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tagar</th>
                                <th>Ringkasan</th>
                                <th>Penulis</th>
                                <th>Dilihat</th>
                                <th>Status</th>
                                <th>Link</th>
                                <th>Diterbitkan</th>
                                <th>Dibuat</th>
                                <th>Diperbarui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $index => $post)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $post->image) }}" style="width: 45px"
                                        alt="{{ $post->title }}">
                                </td>
                                <td>{{ $post->title }}</td>
                                <td class="sm">
                                    @foreach ($post->categories as $category)
                                    <button class="badge bg-dark" style="border: none">{{ $category->name }}</button>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($post->tags as $tag)
                                        <a>#{{ $tag->name }}</a>
                                    @endforeach
                                </td>
                                <td>{{ $post->excerpt }}</td>
                                <td>
                                    {{ $post->user->name }}
                                </td>
                                <td>{{ $post->views }}x</td>
                                <td>{{ $post->status }}</td>
                                <td>
                                    <a href="{{ url('blog/' . $post->slug) }}">
                                        {{ url('blog/' . $post->slug) }}
                                    </a>
                                </td>
                                <td>{{ $post->published_at }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td>{{ $post->updated_at }}</td>
                                <td class="d-flex justify-content-start">
                                    <!-- Menambahkan kelas d-flex untuk layout flex -->

                                    <!-- Tombol untuk membuka modal detail -->
                                    <button style="border-radius: 10px;" data-toggle="modal"
                                        data-target="#modalDetail{{ $post->id }}" type="button"
                                        class="btn btn-secondary text-white mb-1 me-2">
                                        <!-- Tambahkan kelas me-2 untuk margin di sebelah kanan -->
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <!-- Tombol edit data -->
                                    <a href="{{ route('dashboard.post.edit',$post->slug) }}" style="border-radius: 10px;" 
                                        class="btn btn-warning mb-1 me-2">
                                        
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Tombol untuk membuka modal delete -->
                                    <button style="border-radius: 10px;" data-toggle="modal"
                                        data-target="#modalDelete{{ $post->id }}"
                                        type="button" class="btn btn-danger text-white mb-1 me-2">
                                        <!-- Tambahkan kelas me-2 untuk margin di sebelah kanan -->
                                        <i class="bi bi-trash"></i>
                                    </button>


                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="14" class="text-center">Tidak ada postingan yang ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Load More -->
                @if($posts->count() >= $limit && $totalPosts > $limit)
                <div class="mt-4 d-flex justify-content-center">
                    <!-- Tombol "Tampilkan Lebih" (akan hilang saat loading) -->
                    <button style="border-radius: 20px;" wire:click="loadMore" class="btn btn-dark btn-rounded"
                        wire:loading.remove wire:target="loadMore">
                        Tampilkan Lebih
                    </button>

                    <!-- Tombol Loading (hanya muncul saat loading) -->
                    <button style="border-radius: 20px;" class="btn btn-dark btn-rounded" type="button" disabled
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
    @foreach ($posts as $post)
    <div class="modal fade" id="modalDetail{{ $post->id }}" tabindex="-1" role="dialog"
        aria-labelledby="detailModalLabel{{ $post->id }}" aria-hidden="true" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title">
                        <b>{{ $post->title }}</b>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"
                    style="padding-left: 200px; padding-right: 200px; max-height: 75vh; overflow-y: auto;">
                    <!-- Menggunakan kelas p-4 untuk padding -->
                    <div class="text-center mb-3">
                        <!-- Menambahkan margin bawah untuk jarak antara gambar dan deskripsi -->
                        <img class="img-thumbnail" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                            style="width: 250px">
                    </div>
                    <div class="post-content">
                        {!! $post->description !!}
                        <!-- Pastikan deskripsi aman untuk ditampilkan -->
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
    @endforeach

    {{-- Modal Delete --}}
    @foreach ($posts as $post)

    <div class="modal" id="modalDelete{{ $post->id }}" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel{{ $post->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"  style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModalLabel{{ $post->id }}">
                        Hapus Postingan "{{ $post->title }}" </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus postingan ini?
                </div>
                <div class="modal-footer justify-content-center">
                    <button style="border-radius: 10px;"  wire:loading.remove wire:target='delete({{ $post->id }})' type="button"
                        class="btn btn-secondary" data-dismiss="modal">Batal
                    </button>
                    <button style="border-radius: 10px;" wire:loading.remove wire:click="delete({{ $post->id }})" type="button"
                        class="btn btn-danger">Hapus
                    </button>

                    <button style="border-radius: 10px;" wire:loading wire:target='delete({{ $post->id }})' class="btn btn-danger" disabled>
                        Menghapus <span class="spinner-grow spinner-grow-sm" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @endforeach


    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Detail Modal --}}
    <script>
        $(document).on('click', '.open-modal', function (event) {
            var modalId = $(this).data('modal-id'); // Menggunakan atribut data untuk mendapatkan ID modal

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

    </script>

    {{-- Hide modal delete --}}
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
                    setTimeout(cleanupModal, 50);
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
                        text: "Postingan berhasil dihapus!",
                        icon: "success",
                        timer: 1000,
                        timerProgressBar: true,
                    });
                });
            })
    
        </script>
    @endpush
</div>
