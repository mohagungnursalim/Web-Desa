<?php

namespace App\Livewire\Dashboard\Settings;

use App\Models\Setting;
use Livewire\WithFileUploads;
use Livewire\Component;

class Settings extends Component
{
    use WithFileUploads;

    public $appName;
    public $footerText;
    public $heroTitle;
    public $heroDescription;
    public $heroImage;
    public $appLogo; // Untuk tampilan gambar yang ada
    public $image;   // Untuk upload gambar baru

    protected $listeners = [
        'appNameUpdated' => 'updateAppName',
        'footerTextUpdated' => 'updateFooterText',
        'appLogoUpdated' => 'updateAppLogo',
    ];

    public function mount()
    {
        $this->appName = Setting::getSetting('app_name', config('app.name'));
        $this->footerText = Setting::getSetting('footer_text', 'Default footer text');
        $this->appLogo = Setting::getSetting('appLogo', null);

        $this->heroTitle = Setting::getSetting('heroTitle', 'Hero Title');
        $this->heroDescription = Setting::getSetting('heroDescription', 'Hero Description');
        $this->heroImage = Setting::getSetting('heroImage', 'Hero Image');
       
    }

    public function saveSettings()
    {
        // Validasi input
        $this->validate([
            'appName' => 'required|string|max:255',
            'footerText' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan teks pengaturan
        Setting::setSetting('app_name', $this->appName);
        Setting::setSetting('footer_text', $this->footerText);

        // Simpan gambar jika ada upload baru
        if ($this->image) {
            $newImagePath = $this->image->store('app-logo', 'public');

            // Hapus gambar lama jika ada
            if ($this->appLogo && file_exists(public_path('storage/' . $this->appLogo))) {
                unlink(public_path('storage/' . $this->appLogo));
            }

            // Perbarui path gambar di database
            Setting::setSetting('appLogo', $newImagePath);
            $this->appLogo = $newImagePath;
        }

        toast('Pengaturan berhasil diperbarui!','success');
        return $this->redirect('/dashboard/pengaturan', navigate: true);

    }

    public function saveheroSettings()
    {
        // Validasi input
        $this->validate([
            'heroTitle' => 'required|string|max:255',
            'heroDescription' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan teks pengaturan
        Setting::setSetting('heroTitle', $this->heroTitle);
        Setting::setSetting('heroDescription', $this->heroDescription);

        // Simpan gambar jika ada upload baru
        if ($this->image) {
            $newImagePath = $this->image->store('hero-image', 'public');

            // Hapus gambar lama jika ada
            if ($this->heroImage && file_exists(public_path('storage/' . $this->heroImage))) {
                unlink(public_path('storage/' . $this->heroImage));
            }

            // Perbarui path gambar di database
            Setting::setSetting('heroImage', $newImagePath);
            $this->heroImage = $newImagePath;
        }

        toast('Hero section berhasil diperbarui!','success');
        return $this->redirect('/dashboard/pengaturan', navigate: true);

    }

    public function render()
    {
        return view('livewire.dashboard.settings.settings');
    }
}
