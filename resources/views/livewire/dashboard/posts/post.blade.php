<div class="py-4">
    @push('styles')
    <style>
        /* Gaya untuk blok kode */
        pre {
            background-color: #353434;
            /* Background gelap */
            color: #f8f8f2;
            /* Warna teks */
            padding: 15px;
            border-radius: 20px;
            overflow-x: auto;
            /* Scroll horizontal jika teks terlalu panjang */
            font-family: 'Courier New', Courier, monospace;
            /* Font monospaced */
            font-size: 14px;
            position: relative;
        }
    </style>

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

    {{-- Img Style --}}
    <style>
        .post-content img {
                max-width: 100%;
                height: auto;
            }
            .image_resized {
            display: block; /* Agar gambar dapat diperlakukan sebagai blok */
            margin-left: auto;
            margin-right: auto; /* Mengatur margin kiri dan kanan otomatis untuk sentralisasi */
        }
        .image-style-block-align-left{
            float: left;
        }
        .image-style-block-align-right {
            float: right; /* Untuk gambar di sebelah kanan */
        }
        /* Jika ingin menjaga gambar tetap di tengah hanya saat tidak ada kelas alignment */
        figure.image {
            text-align: center; /* Menempatkan gambar di tengah dalam figure */
        }
    </style>
    <style>
        /* CSS untuk highlight */
        .marker-yellow {
            background-color: #fdfd77;
        }
        .marker-green {
            background-color: #63f963;
        }
        .marker-pink {
            background-color: #fc92c4;
        }
        .marker-blue {
            background-color: #9ecbff;
        }
    </style>
    @endpush
    <div class="container-fluid col-md">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body" style="padding: 20px;">

                <a wire:navigate href="/dashboard/postingan/tambah-data" style="border-radius: 10px;"
                    class="btn btn-primary mb-4">Tambah
                    Postingan</a>
                
                <div class="mb-2">
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari postingan.."
                        class="form-control" style="color: black; border-radius: 10px;">
                    &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                </div>
                <div style="overflow-x: auto;" wire:init="loadInitialPosts">
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
                                <td class="image-wrapper">
                                    <img data-src="{{ asset('storage/' . $post->image) }}" style="width: 45px"
                                        alt="{{ $post->title }}" class="lazyload">
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
                                <td>
                                    @if ($post->status == "published")
                                        <button style="border: none; background-color:#a7d0f4" class="badge">{{ $post->status }}</button>
                                    @elseif($post->status == "draft")
                                    <button style="border: none; background-color:#c4c4c4" class="badge">{{ $post->status }}</button>
                                    @else
                                    <button style="border: none; background-color:#f0e77e" class="badge">{{ $post->status }}</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('blog/' . $post->slug) }}">
                                        {{ url('blog/' . $post->slug) }}
                                    </a>
                                </td>
                                <td>
                                    @isset($post->published_at)
                                    {{ $post->published_at }}
                                    @else
                                    -
                                    @endisset
                                    
                                </td>
                                <td>{{ $post->created_at }}</td>
                                <td>{{ $post->updated_at }}</td>
                                <td class="d-flex justify-content-start">
                                    <!-- Menambahkan kelas d-flex untuk layout flex -->
                                    <!-- Tombol untuk membuka modal detail -->
                                    <button style="border-radius: 10px;" wire:click="showPostDetail({{ $post->id }})" type="button"
                                        class="btn btn-secondary text-white mb-1 me-2">
                                        <!-- Tambahkan kelas me-2 untuk margin di sebelah kanan -->
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <!-- Tombol edit data -->
                                    <a wire:navigate href="{{ route('dashboard.post.edit',$post->slug) }}"
                                        style="border-radius: 10px;" class="btn btn-warning mb-1 me-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Tombol untuk membuka modal delete -->
                                    <button style="border-radius: 10px;" wire:click="confirmDelete({{ $post->id }}, '{{ $post->title }}')" type="button"
                                        class="btn btn-danger text-white mb-1 me-2">
                                        <!-- Tambahkan kelas me-2 untuk margin di sebelah kanan -->
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td wire:loading.remove wire:target="loadInitialPosts" colspan="14" class="text-center">Tidak ada postingan yang ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="text-center">
                        <!-- Loading saat memuat data pertama kali -->
                        <p wire:loading wire:target="loadInitialPosts" class="text-center">Memuat data..<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        </p>
                    </div>
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
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title">
                        <b>{{ $selectedPost ? $selectedPost->title : '' }}</b>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-left: 200px; padding-right: 200px; max-height: 75vh; overflow-y: auto;">
                    <div class="text-center mb-3 image-wrapper">
                        @if ($selectedPost && $selectedPost->image)
                            <img class="img-thumbnail lazyload" src="{{ asset('storage/' . $selectedPost->image) }}" alt="{{ $selectedPost->title }}"
                                style="width: 520px">
                        @endif
                    </div>
                    <div class="post-content">
                        {{-- {!! $selectedPost ? $selectedPost->description : '' !!} --}}
                        {!! $selectedPost ? $selectedPost->formatted_description : '' !!}
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
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header">
                        <h6 class="modal-title" id="deleteModalLabel">
                            Hapus Postingan "{{ $postTitle }}"
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        Apakah anda yakin ingin menghapus post ini?
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>

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
                    text: "Postingan berhasil dihapus!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            });
        })
    </script>




    {{-- Code Style --}}




    @endpush
</div>