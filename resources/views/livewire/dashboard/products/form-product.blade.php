<div class="py-4">
    @push('styles')

    <style>
        /* Ubah warna background dan teks untuk item yang dipilih */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1a1818;
            /* Ganti dengan warna yang Anda inginkan */
            color: #ffffff;
            /* Ganti dengan warna teks yang Anda inginkan */
            border: none;
        }

        /* Ubah warna saat hover pada item yang dipilih */
        .select2-container--default .select2-selection--multiple .select2-selection__choice:hover {
            background-color: #6d7a89;
            /* Ganti dengan warna hover yang Anda inginkan */
            color: #ffffff;
        }

    </style>
    @endpush
    <div class="container-fluid">
        <div class="card" style="border-radius: 25px;">
            <div class="card-body">
                <h4><a wire:navigate href="/dashboard/produk" style="border-radius: 10px;"
                        class="btn btn-white"><u>👈Kembali</u></a></h4>
                <form wire:submit.prevent="store" class="mt-4">
                    <div class="form-group">
                        <label for="title">Nama Produk</label>
                        <input type="text" id="title" class="form-control input-default" wire:model="title"
                            placeholder="Masukkan nama produk">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Gambar Produk</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Gambar</span>
                            </div>
                            <div class="custom-file">
                                <input multiple type="file" id="image" class="custom-file-input" wire:model="image">
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
                                <img src="{{ $img->temporaryUrl() }}" alt="Preview" class="img-fluid img-thumbnail"
                                    width="100px">
                            </div>
                            @endforeach
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
                    </div>

                    <!-- Multiple Select untuk Kategori Produk -->
                    <div wire:ignore class="form-group">
                        <label for="product_category">Kategori Produk</label>
                        <select id="product_category" class="form-control" multiple wire:model="product_category">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                <p class="text-dark">{{ $category->name }}</p>
                            </option>
                            @endforeach
                        </select>
                    </div>

                    @error('product_category') <span class="text-danger">{{ $message }}</span> @enderror

                    <!-- Input untuk WA Number -->
                    <div class="form-group">
                        <label for="wa_number">Nomor WhatsApp</label>
                        <input type="number" id="wa_number" class="form-control input-default" wire:model="wa_number"
                            placeholder="Masukkan nomor WhatsApp">
                        @error('wa_number') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Harga Produk</label>
                        <input type="number" id="price" class="form-control input-default" wire:model="price"
                            placeholder="Masukkan harga produk">
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div wire:ignore class="form-group">
                        <label for="description">Deskripsi Produk</label>
                        <textarea wire:model.defer="description" id="description" class="form-control"
                            name="description" cols="30" rows="10" placeholder="Masukkan deskripsi"></textarea>
                    </div>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="text-center">
                        <button style="border-radius: 10px;" type="submit" class="btn btn-primary" wire:loading.remove
                            wire:target="store">
                            Simpan
                        </button>
                        <button style="border-radius: 10px;" class="btn btn-primary" type="button" disabled wire:loading
                            wire:target="store">
                            Menyimpan <span class="spinner-grow spinner-grow-sm" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

    {{-- Summernote --}}
    <script data-navigate-once>
        document.addEventListener('livewire:navigated', () => {
            $(document).ready(function () {

                let debounceTimer;

                $('#description').summernote({
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
                                @this.set('description',
                                contents); // Update model Livewire
                            }, 800); // 800ms
                        }
                    }
                });
            });
        })

    </script>

    {{-- Select2 Kategori Form Tambah --}}
    <script data-navigate-once>
        document.addEventListener('livewire:navigated', function () {
            setTimeout(function () {
                initializeSelect2Kategori('#product_category', 'product_category');
            }, 1); // Timeout pendek 1ms
        });

        function initializeSelect2Kategori(selector, livewireProperty) {
            let debounceTimer;

            $(selector).select2({
                placeholder: '--Pilih Kategori--',
                minimumResultsForSearch: Infinity,
                width: '100%'
            }).on('change', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    @this.set(livewireProperty, $(this).val());
                }, 700);
            });
        }

    </script>

    @endpush
</div>
