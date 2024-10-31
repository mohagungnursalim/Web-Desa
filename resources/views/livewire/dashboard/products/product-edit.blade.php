<div class="py-4">
    @push('styles')
    {{-- <link href="https://cdn.jsdelivr.net/npm/slim-select@latest/dist/slimselect.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
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
                <h4><a wire:navigate href="/dashboard/produk" style="border-radius: 10px;" class="btn btn-white"><u>👈Kembali</u></a></h4>
                <form wire:submit.prevent="update">
                    <div class="form-group">
                        <label for="title">Nama Produk</label>
                        <input type="text" id="title" class="form-control" wire:model="title"
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

                    <div wire:ignore class="form-group">
                        <label for="product_category">Kategori Produk</label>
                        <select id="product_category" class="form-control" multiple wire:model="selectedId">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, $selectedId) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('selectedId') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="form-group">
                        <label for="wa_number">Nomor WhatsApp</label>
                        <input type="number" id="wa_number" class="form-control" wire:model="wa_number"
                            placeholder="Masukkan nomor WhatsApp">
                        @error('wa_number') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Harga Produk</label>
                        <input type="number" id="price" class="form-control" wire:model="price"
                            placeholder="Masukkan harga produk">
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div wire:ignore class="form-group">
                        <label for="description">Deskripsi Produk</label>
                        <textarea wire:model.defer="description" id="description" class="form-control" rows="3"
                            placeholder="Masukkan deskripsi"></textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="text-center">
                        <button style="border-radius: 10px;" type="submit" class="btn btn-primary" wire:loading.remove wire:target="update">
                            Simpan
                        </button>
                        <button style="border-radius: 10px;" class="btn btn-primary" type="button" disabled wire:loading wire:target="update">
                            Memperbarui <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap JS (Dibutuhkan oleh Summernote) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

    <script>
        // summernote
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
                            @this.set('description', contents); // Update model Livewire
                        }, 600); // 600ms
                    }
                }
            });
        });

    </script>

    {{-- Select2 kategori form edit --}}
	<script>
		$(document).ready(function () {
			$('#product_category').select2({
				placeholder: '--Pilih Kategori--',
				minimumResultsForSearch: Infinity,
				width: '100%',
			});
	
			let debounceTimer;
			$('#product_category').on('change', function (e) {
				clearTimeout(debounceTimer);
				debounceTimer = setTimeout(() => {
					@this.set('selectedId', $(this).val());
				}, 700); // Menambahkan debounce 700ms
			});
	
			// Set initial value from Livewire
			const selectedIds = @json($selectedId ?? []);
			$('#product_category').val(selectedIds).trigger('change');
	
			// Update Select2 when Livewire updates the data
			Livewire.hook('message.processed', (message, component) => {
				$('#product_category').val(@json($selectedId ?? [])).trigger('change');
			});
		});
	</script>
    @endpush
</div>
