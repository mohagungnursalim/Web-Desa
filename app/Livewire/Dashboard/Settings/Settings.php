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
    public $heroTitle,$heroTitle2;
    public $heroDescription,$heroDescription2;
    public $heroImage,$heroImage2;
    public $appLogo; // Untuk tampilan gambar yang ada
    public $image,$image2,$image3;   // Untuk upload gambar baru


    public function mount()
    {
        $this->appName = Setting::getSetting('app_name', config('app.name'));
        $this->footerText = Setting::getSetting('footer_text', 'Default footer text');
        $this->appLogo = Setting::getSetting('appLogo', null);

        $this->heroTitle = Setting::getSetting('heroTitle', 'Hero Title');
        $this->heroDescription = Setting::getSetting('heroDescription', 'Hero Description');
        $this->heroImage = Setting::getSetting('heroImage', 'Hero Image');
       
        $this->heroTitle2 = Setting::getSetting('heroTitle2', 'Hero Title2');
        $this->heroDescription2 = Setting::getSetting('heroDescription2', 'Hero Description2');
        $this->heroImage2 = Setting::getSetting('heroImage2', 'Hero Image2');
    }

    public function saveSettings()
    {
        // Validasi input
        $this->validate([
            'appName' => 'required|string|max:255',
            'footerText' => 'nullable|string|max:500',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan teks pengaturan
        Setting::setSetting('app_name', $this->appName);
        Setting::setSetting('footer_text', $this->footerText);

        // Simpan gambar jika ada upload baru
        if ($this->image2) {
            $newImagePath = $this->image2->store('app-logo', 'public');

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
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan teks pengaturan
        Setting::setSetting('heroTitle', $this->heroTitle);
        Setting::setSetting('heroDescription', $this->heroDescription);

        // Simpan gambar jika ada upload baru
        if ($this->image2) {
            $newImagePath = $this->image2->store('hero-image', 'public');

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

    public function saveheroSettings2()
    {
        // Validasi input
        $this->validate([
            'heroTitle2' => 'required|string|max:255',
            'heroDescription2' => 'nullable|string',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan teks pengaturan
        Setting::setSetting('heroTitle2', $this->heroTitle2);
        Setting::setSetting('heroDescription2', $this->heroDescription2);

        // Simpan gambar jika ada upload baru
        if ($this->image3) {
            $newImagePath = $this->image3->store('hero-image', 'public');

            // Hapus gambar lama jika ada
            if ($this->heroImage2 && file_exists(public_path('storage/' . $this->heroImage2))) {
                unlink(public_path('storage/' . $this->heroImage2));
            }

            // Perbarui path gambar di database
            Setting::setSetting('heroImage2', $newImagePath);
            $this->heroImage2 = $newImagePath;
        }

        toast('Hero section 2 berhasil diperbarui!','success');
        return $this->redirect('/dashboard/pengaturan', navigate: true);

    }
    public function render()
    {
        return view('livewire.dashboard.settings.settings');
    }
}
