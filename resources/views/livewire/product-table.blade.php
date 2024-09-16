<div class="py-4">
    <div class="container">
        <div class="card">
            <div class="card-body text-dark">

                <!-- Wrapper untuk memastikan tabel di tengah -->
                <div class="d-flex justify-content-center">
                    <div class="w-100">

                        <!-- Input untuk mencari produk -->
                        <div class="mb-2">
                            <input type="text" wire:model.live="search" placeholder="Cari produk.." class="form-control"
                                style="color: black;">
                        </div>

                        <!-- Tabel Produk -->
                        @if ($products->isNotEmpty()) <!-- Cek jika ada produk -->
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <!-- Jika tidak ada data yang ditemukan -->
                            <div class="text-center text-secondary mt-4">
                                Produk tidak ditemukan..
                            </div>
                        @endif

                        <!-- Loader -->
                        <div wire:loading class="text-dark">
                            Loading...
                        </div>

                        <!-- Tombol Load More -->
                        @if($products->count() >= $limit && $totalProducts > $limit)
                        <div class="mt-4 d-flex justify-content-center">
                            <button wire:click="loadMore" class="btn btn-primary">
                                Load More
                            </button>
                        </div>
                        @endif

                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
