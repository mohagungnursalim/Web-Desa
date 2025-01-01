<div class="py-4">
    @push('styles')

    @endpush
    <div class="container">

        <div class="card-body text-dark">

            <!-- Wrapper untuk memastikan tabel di tengah -->
            <div class="d-flex justify-content-center">

                <div class="w-100">

                    <a wire:navigate href="/dashboard/produk/tambah-produk"  style="border-radius: 10px;" class="btn btn-primary mb-4">Tambah Produk</a>

                    <!-- Input untuk mencari produk -->
                    <div class="mb-2">
                        <input  style="border-radius: 10px;" type="text" wire:model.live.debounce.500ms="search" placeholder="Cari produk.."
                            class="form-control" style="color: black;">

                        &nbsp;&nbsp;<a wire:loading wire:target='search' class="text-secondary">Mencari..</a>
                    </div>
                    <div wire:init="loadInitialProducts">
                    <div class="container-fluid">
                        <!-- End Row -->
                        <div class="row">
                            <div class="col-12 m-b-30">
                                <div class="row">
                                    @forelse ($products as $index => $product)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card"  style="border-radius: 20px;">
                                            {{-- Menampilkan gambar produk --}}
                                            @php
                                            $images = is_string($product->image) ? json_decode($product->image, true) :
                                            $product->image;
                                            @endphp

                                            @if($images && is_array($images) && count($images) > 0)
                                            <div id="productCarousel{{ $product->id }}" class="carousel slide" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    @foreach($images as $imageIndex => $img)
                                                    <li data-target="#productCarousel{{ $product->id }}" 
                                                        data-slide-to="{{ $imageIndex }}" 
                                                        class="{{ $imageIndex == 0 ? 'active' : '' }}"></li>
                                                    @endforeach
                                                </ol>
                                                <div class="carousel-inner">
                                                    @foreach($images as $imageIndex => $img)
                                                    <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                                        <div class="lazy-placeholder-product" 
                                                            x-data="{ imageSrc: null }" 
                                                            x-init="setTimeout(() => { imageSrc = $el.querySelector('img').dataset.src }, 500)">
                                                            <img 
                                                                :src="imageSrc" 
                                                                data-src="{{ asset('storage/' . $img) }}" 
                                                                alt="{{ $product->title }} - Image {{ $imageIndex + 1 }}" 
                                                                class="lazy-img">
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @if(count($images) > 1)
                                                <a class="carousel-control-prev" href="#productCarousel{{ $product->id }}" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#productCarousel{{ $product->id }}" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                                @endif
                                            </div>
                                            @elseif($product->image)
                                            <div class="lazy-placeholder-product" 
                                                x-data="{ imageSrc: null }" 
                                                x-init="setTimeout(() => { imageSrc = $el.querySelector('img').dataset.src }, 500)">
                                                <img 
                                                    :src="imageSrc" 
                                                    data-src="{{ asset('storage/' . $product->image) }}" 
                                                    alt="{{ $product->title }}" 
                                                    class="lazy-img">
                                            </div>
                                            @endif


                                            <div class="card-body">

                                                {{-- Loop kategori terkait --}}
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($product->categories as $category)
                                                    <button  style="border-radius: 10px;"
                                                        class="badge bg-dark me-2">{{ $category->name }}</button>&nbsp;
                                                    @endforeach
                                                </div>
                                                {{-- Menampilkan judul produk --}}
                                                <h5 class="card-title"><b>{{ $product->title }}</b></h5><br>
                                                
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
                                                    <a wire:navigate href="{{ route('dashboard.produk.edit',$product->id) }}"
                                                        class="badge bg-warning text-white"
                                                        style="text-decoration: none; border-radius: 20px">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>

                                                    <button wire:click="confirmDelete({{ $product->id }},'{{ $product->title }}')" type="button"
                                                        class="badge bg-danger text-white" style="border: none; border-radius: 20px;">
                                                        <i class="bi bi-trash3"></i> Delete
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <!-- Jika tidak ada data yang ditemukan -->
                                    <div wire:loading.remove class="text-center text-secondary">
                                        &nbsp;&nbsp; Produk tidak tersedia..
                                    </div>
                                    @endforelse
                                </div>
                                <div class="text-center">
                                    <!-- Loading saat memuat data pertama kali -->
                                    <p wire:loading wire:target="loadInitialProducts" class="text-center">Memuat data..<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    </p>
                                </div>
                            </div>

                        </div>


                    </div>
                    </div>
                   
                   <!-- Tombol Load More -->
                @if($products->count() >= $limit && $totalProducts > $limit)
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
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteModalLabel">
                        Hapus Produk "{{ $productTitle }}"
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah anda yakin ingin menghapus produk ini?
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
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
                        text: "Data produk berhasil dihapus!",
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
</div>
