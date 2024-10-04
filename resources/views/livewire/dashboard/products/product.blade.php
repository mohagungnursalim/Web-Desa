<div class="py-4">
    @push('styles')
    {{-- <style>
    .short-text {
    display: block;
}

.full-text {
    display: none;
}
</style> --}}
    @endpush
    <div class="container">

        <div class="card-body text-dark">

            <!-- Wrapper untuk memastikan tabel di tengah -->
            <div class="d-flex justify-content-center">

                <div class="w-100">

                    <a href="/dashboard/produk/tambah-produk" class="btn btn-primary mb-4">Tambah Produk</a>

                    <!-- Input untuk mencari produk -->
                    <div class="mb-2">
                        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari produk.."
                            class="form-control" style="color: black;">

                        &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                    </div>

                    <div class="container-fluid">
                        <!-- End Row -->
                        <div class="row">
                            @if ($products->isNotEmpty())
                            <div class="col-12 m-b-30">
                                <div class="row">
                                    @foreach ($products as $index => $product)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card">
                                            {{-- Menampilkan gambar produk --}}
                                            <img class="img-fluid" src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->title }}">

                                            <div class="card-body">

                                                {{-- Loop kategori terkait --}}
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($product->categories as $category)
                                                    <button
                                                        class="badge bg-dark me-2">{{ $category->name }}</button>&nbsp;
                                                    @endforeach
                                                </div>
                                                {{-- Menampilkan judul produk --}}
                                                <h5 class="card-title">{{ $product->title }}</h5>
                                                
                                                {{-- Menampilkan deskripsi produk --}}
                                                <td class="text-wrap small">
                                                    {{-- Tampilkan teks singkat dari deskripsi --}}
                                                    <span class="short-text">
                                                        {!! \Illuminate\Support\Str::limit(strip_tags($product->description), 50) !!}
                                                        @if (\Illuminate\Support\Str::length(strip_tags($product->description)) > 50)
                                                        <span class="read-more-btn text-primary" style="cursor: pointer;" onclick="toggleDescription(this)">Selengkapnya</span>
                                                        @endif
                                                    </span>

                                                    {{-- Tampilkan deskripsi lengkap, tersembunyi secara default --}}
                                                    @if (\Illuminate\Support\Str::length(strip_tags($product->description)) > 50)
                                                    <span class="full-text" style="display: none;">
                                                        {!! $product->description !!}
                                                        <span class="read-less-btn text-primary" style="cursor: pointer;" onclick="toggleDescription(this)">Lebih sedikit</span>
                                                    </span>
                                                    @endif
                                                </td>

                                                {{-- Menampilkan harga produk dengan format angka --}}
                                                <p class="card-text">
                                                    <small
                                                        class="text-muted">Rp{{ number_format($product->price, 0, ',', '.') }}</small>
                                                </p>

                                                <div class="text-center">
                                                    <a href="{{ route('dashboard.produk.edit',$product->id) }}"
                                                        class="badge bg-warning text-white"
                                                        style="text-decoration: none;">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>

                                                    <button data-toggle="modal"
                                                        data-target="#modalDelete{{ $product->id }}" type="button"
                                                        class="badge bg-danger text-white" style="border: none">
                                                        <i class="bi bi-trash3"></i> Delete
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
                                &nbsp;&nbsp; Produk tidak tersedia..
                            </div>
                            @endif
                        </div>


                    </div>




                    <!-- Tombol Load More -->
                    @if($products->count() >= $limit && $totalProducts > $limit)
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
        @foreach ($products as $product)

        <div class="modal" id="modalDelete{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="deleteModalLabel{{ $product->id }}">
                            Hapus Produk "{{ $product->title }}" </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        Apakah anda yakin ingin menghapus produk ini?
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button wire:loading.remove wire:target='delete({{ $product->id }})' type="button"
                            class="btn btn-secondary" data-dismiss="modal">Batal
                        </button>
                        <button wire:loading.remove wire:click="delete({{ $product->id }})" type="button"
                            class="btn btn-danger">Hapus
                        </button>

                        <button wire:loading wire:target='delete({{ $product->id }})' class="btn btn-danger" disabled>
                            Menghapus <span class="spinner-grow spinner-grow-sm" role="status"
                                aria-hidden="true"></span>
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
                        text: "Data produk berhasil dihapus!",
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
                        text: "Data produk gagal dihapus!",
                        icon: "error",
                        timer: 1500,
                        timerProgressBar: true,
                    });
                });
            })

        </script>
        @endpush
    </div>
</div>
