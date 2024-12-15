<div class="py-4">
    <div class="container">
        <h4 class="text-center">- App Settings -</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 25px;">
                    <div class="card-body">
                        <form wire:submit.prevent="saveSettings">
                            <div class="text-center mb-4">
                                @if ($image)
                                <!-- Preview saat gambar sedang diunggah -->
                                <div class="p-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>
                                @elseif ($appLogo)
                                <!-- Menampilkan gambar lama jika tidak ada upload baru -->
                                <img src="{{ asset('storage/' . $appLogo) }}" alt="App Logo"
                                    class="img-fluid img-thumbnail" width="100px">
                                @else
                                <p class="text-muted">No logo uploaded</p>
                                @endif

                                <!-- Loading bar saat upload -->
                                <br>
                                <div wire:loading wire:target="image" class="mt-2 col" style="width: 400px">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                            aria-valuemax="100">
                                            Mengunggah...
                                        </div>
                                    </div>
                                </div>

                                <!-- Input file -->
                                <div class="mt-3">
                                    <input type="file" wire:model="image">
                                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="appName" class="form-label">App Name</label>
                                <input type="text" id="appName" class="form-control" wire:model="appName">
                                @error('appName') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="footerText" class="form-label">Footer Text</label>
                                <textarea id="footerText" class="form-control" wire:model="footerText"></textarea>
                                @error('footerText') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="text" id="facebook" class="form-control" wire:model="facebook">
                                @error('facebook') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" id="instagram" class="form-control" wire:model="instagram">
                                @error('instagram') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" style="border-radius: 10px;"
                                    class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h4 class="text-center">- Beranda Settings -</h4>
    </div>
    <div class="container">
        {{-- Jumbotron --}}
        <div class="row">
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 25px;">
                    <div class="card-body">
                        <form wire:submit.prevent="saveJumbotronSettings">
                            <div class="text-center mb-4">
                                @if ($image2)
                                <!-- Preview saat gambar sedang diunggah -->
                                <div class="p-2">
                                    <img src="{{ $image2->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>
                                @elseif ($jumbotronImage)
                                <!-- Menampilkan gambar lama jika tidak ada upload baru -->
                                <img src="{{ asset('storage/' . $jumbotronImage) }}" alt="App Logo"
                                    class="img-fluid img-thumbnail" width="100px">
                                @else
                                <p class="text-muted">No image uploaded</p>
                                @endif

                                <!-- Loading bar saat upload -->
                                <br>
                                <div wire:loading wire:target="image2" class="mt-2 col" style="width: 400px">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                            aria-valuemax="100">
                                            Mengunggah...
                                        </div>
                                    </div>
                                </div>

                                <!-- Input file -->
                                <div class="mt-3">
                                    <input type="file" wire:model="image2">
                                    @error('image2') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jumbotronTitle" class="form-label">Jumbotron Title</label>
                                <input type="text" id="jumbotronTitle" class="form-control" wire:model="jumbotronTitle">
                                @error('jumbotronTitle') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jumbotronDescription" class="form-label">Jumbotron Description</label>
                                <textarea id="jumbotronDescription" class="form-control"
                                    wire:model="jumbotronDescription"></textarea>
                                @error('jumbotronDescription') <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" style="border-radius: 10px;"
                                    class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        {{-- OPD --}}
        <div class="row">
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 25px;">
                    <div class="card-body">
                        <form wire:submit.prevent="saveOpdSettings">
                            <div class="text-center mb-4">
                                @if ($image3)
                                <!-- Preview saat gambar sedang diunggah -->
                                <div class="p-2">
                                    <img src="{{ $image3->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>
                                @elseif ($opdImage)
                                <!-- Menampilkan gambar lama jika tidak ada upload baru -->
                                <img src="{{ asset('storage/' . $opdImage) }}" alt="App Logo"
                                    class="img-fluid img-thumbnail" width="100px">
                                @else
                                <p class="text-muted">No image uploaded</p>
                                @endif

                                <!-- Loading bar saat upload -->
                                <br>
                                <div wire:loading wire:target="image3" class="mt-2 col" style="width: 400px">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                            aria-valuemax="100">
                                            Mengunggah...
                                        </div>
                                    </div>
                                </div>

                                <!-- Input file -->
                                <div class="mt-3">
                                    <input type="file" wire:model="image3">
                                    @error('image3') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="opdTitle" class="form-label">Opd Title</label>
                                <input type="text" id="opdTitle" class="form-control" wire:model="opdTitle">
                                @error('opdTitle') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3" wire:ignore>
                                <label for="opdDescription" class="form-label">Opd Description</label>
                                <textarea id="opdDescription" class="form-control">{{ $opdDescription }}</textarea>
                                @error('opdDescription') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="opdName" class="form-label">Opd Name</label>
                                <input type="text" id="opdName" class="form-control" wire:model="opdName">
                                @error('opdName') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="opdPosition" class="form-label">Opd Position</label>
                                <input type="text" id="opdPosition" class="form-control" wire:model="opdPosition">
                                @error('opdPosition') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" style="border-radius: 10px;"
                                    class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap JS (Dibutuhkan oleh Summernote) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

    <script>
        // summernote
        $(document).ready(function () {

            let debounceTimer;

            $('#opdDescription').summernote({
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
                            @this.set('opdDescription', contents); // Update model Livewire
                        }, 600); // 600ms
                    }
                }
            });
        });

    </script>
</div>
