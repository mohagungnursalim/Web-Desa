<div class="py-4">
    @push('styles')
    <style>
        /* Gaya untuk blok kode */
        pre {
            background-color: #000000;
            /* Background gelap */
            color: #f8f8f2;
            /* Warna teks */
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            /* Scroll horizontal jika teks terlalu panjang */
            font-family: 'Courier New', Courier, monospace;
            /* Font monospaced */
            font-size: 14px;
            position: relative;
        }

    </style>

    <style>
        .post-content img {
            max-width: 100%;
            height: auto;

        }

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
                                    <button style="border-radius: 10px;" data-toggle="modal"
                                        data-target="#modalDetail{{ $post->id }}" type="button"
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
    <script>
        window.addEventListener('livewire:navigated', () => {
        // Cari semua elemen <pre> di dalam CKEditor
        $('.post-content pre').each(function () {
            var pre = $(this);

            // Cek jika header sudah ditambahkan, jika iya, lewati
            if (pre.prev('.code-header').length > 0) return;

            // Ambil class bahasa dari elemen <code>
            var languageClass = pre.find('code').attr('class');
            var languageName = languageClass ? languageClass.split('-')[1] : 'kode';

            // Buat header dengan gaya yang sesuai
            var header = $(
                '<div class="code-header" style="background-color: #3d3d3d; color: #f8f8f2; padding: 5px; border-bottom: 1px solid #ccc; font-family: \'Courier New\', Courier, monospace; font-size: 14px; border-radius: 5px; font-weight: bold;">' +
                languageName + '</div>');

            // Tempatkan header di atas elemen <pre>
            pre.before(header);
        });
    });
    </script>
  
    
    {{-- Menampilkan Iframe --}}
    <script>
        window.addEventListener('livewire:navigated', () => {
            // Temukan semua elemen <oembed> dan konversi ke <iframe>
            document.querySelectorAll('oembed[url]').forEach(element => {
                // Ambil URL dari atribut `url`
                const url = element.getAttribute('url');

                // Buat elemen <iframe>
                const iframe = document.createElement('iframe');
                iframe.setAttribute('width', '100%');
                iframe.setAttribute('height', '400');
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('allowfullscreen', '');
                iframe.setAttribute('src', url.replace("watch?v=", "embed/"));

                // Ganti <oembed> dengan <iframe>
                element.parentNode.replaceChild(iframe, element);
            });
        });
    </script>


    @endpush
</div>
