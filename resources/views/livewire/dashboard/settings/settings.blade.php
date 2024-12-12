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
                            <div class="text-center">
                                <button type="submit" style="border-radius: 10px;" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h4 class="text-center">- Hero Settings -</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 25px;">
                    <div class="card-body">
                        <form wire:submit.prevent="saveheroSettings">
                            <div class="text-center mb-4">
                                @if ($image)
                                <!-- Preview saat gambar sedang diunggah -->
                                <div class="p-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                        class="img-fluid img-thumbnail" width="100px">
                                </div>
                                @elseif ($heroImage)
                                <!-- Menampilkan gambar lama jika tidak ada upload baru -->
                                <img src="{{ asset('storage/' . $heroImage) }}" alt="App Logo"
                                    class="img-fluid img-thumbnail" width="100px">
                                @else
                                <p class="text-muted">No image uploaded</p>
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
                                <label for="heroTitle" class="form-label">Hero Title</label>
                                <input type="text" id="heroTitle" class="form-control" wire:model="heroTitle">
                                @error('heroTitle') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="heroDescription" class="form-label">Hero Description</label>
                                <textarea id="heroDescription" class="form-control" wire:model="heroDescription"></textarea>
                                @error('heroDescription') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" style="border-radius: 10px;" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
