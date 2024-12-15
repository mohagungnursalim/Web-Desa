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

    public $jumbotronTitle;
    public $jumbotronDescription;
    public $jumbotronImage;

    public $opdTitle;
    public $opdDescription;
    public $opdImage;
    public $opdName;
    public $opdPosition;

    

    public $appLogo; // Untuk tampilan gambar yang ada
    public $image,$image2,$image3;   // Image Preview


    public function mount()
    {
        // app
        $this->appName = Setting::getSetting('app_name', config('app.name'));
        $this->footerText = Setting::getSetting('footer_text', 'Default footer text');
        $this->appLogo = Setting::getSetting('appLogo', null);

        // jumbotron
        $this->jumbotronTitle = Setting::getSetting('jumbotronTitle', 'Jumbotron Title');
        $this->jumbotronDescription = Setting::getSetting('jumbotronDescription', 'Jumbotron Description');
        $this->jumbotronImage = Setting::getSetting('jumbotronImage', 'Jumbotron Image');
    
        // opd
        $this->opdTitle = Setting::getSetting('opdTitle', 'OPD Title');
        $this->opdDescription = Setting::getSetting('opdDescription','OPD Description');
        $this->opdImage = Setting::getSetting('opdImage', 'OPD Image');
        $this->opdName = Setting::getSetting('opdName', 'OPD Name');
        $this->opdPosition = Setting::getSetting('opdPosition', 'OPD Position');


    }

    // Settings For AppName,FooterText & AppLogo
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

        toast('Pengaturan Aplikasi berhasil!','success');
        return $this->redirect('/dashboard/pengaturan', navigate: true);

    }

    // Settings for Jumbotron
    public function saveJumbotronSettings()
    {
        // Validasi input
        $this->validate([
            'jumbotronTitle' => 'required|string|max:255',
            'jumbotronDescription' => 'nullable|string',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan teks pengaturan
        Setting::setSetting('jumbotronTitle', $this->jumbotronTitle);
        Setting::setSetting('jumbotronDescription', $this->jumbotronDescription);

        // Simpan gambar jika ada upload baru
        if ($this->image2) {
            $newImagePath = $this->image2->store('jumbotron-image', 'public');

            // Hapus gambar lama jika ada
            if ($this->jumbotronImage && file_exists(public_path('storage/' . $this->jumbotronImage))) {
                unlink(public_path('storage/' . $this->jumbotronImage));
            }

            // Perbarui path gambar di database
            Setting::setSetting('jumbotronImage', $newImagePath);
            $this->jumbotronImage = $newImagePath;
        }

        toast('Jumbotron berhasil diperbarui!','success');
        return $this->redirect('/dashboard/pengaturan', navigate: true);

    }

    public function saveOpdSettings()
    {
        // Validasi input
        $this->validate([
            'opdTitle' => 'required|string|max:255',
            'opdDescription' => 'nullable|string',
            'opdName' => 'required|string|max:70',
            'opdPosition' => 'required|string|max:30',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan teks pengaturan
        Setting::setSetting('opdTitle', $this->opdTitle);
        Setting::setSetting('opdDescription', $this->opdDescription);
        Setting::setSetting('opdName', $this->opdName);
        Setting::setSetting('opdPosition', $this->opdPosition);

        // Simpan gambar jika ada upload baru
        if ($this->image3) {
            $newImagePath = $this->image3->store('opd-image', 'public');

            // Hapus gambar lama jika ada
            if ($this->opdImage && file_exists(public_path('storage/' . $this->opdImage))) {
                unlink(public_path('storage/' . $this->opdImage));
            }

            // Perbarui path gambar di database
            Setting::setSetting('opdImage', $newImagePath);
            $this->opdImage = $newImagePath;
        }

        toast('OPD berhasil diperbarui!','success');
        return $this->redirect('/dashboard/pengaturan', navigate: true);

    }
    public function render()
    {
        return view('livewire.dashboard.settings.settings');
    }
}
