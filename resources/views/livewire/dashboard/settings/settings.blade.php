<div class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 mx-auto mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 25px;">
                    <div class="card-body">
                        <form wire:submit.prevent="saveSettings">
                            <div class="mb-3">
                                <label for="appName" class="form-label">App Name</label>
                                <input type="text" id="appName" class="form-control" wire:model="appName">
                            </div>
                    
                            <div class="mb-3">
                                <label for="footerText" class="form-label">Footer Text</label>
                                <input type="text" id="footerText" class="form-control" wire:model="footerText">
                            </div>
                    
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
