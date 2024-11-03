<?php

namespace App\Livewire\Dashboard\Settings;

use App\Models\Setting;
use Livewire\Component;

class Settings extends Component
{
    public $appName;
    public $footerText;

    protected $listeners = [
        'appNameUpdated' => 'updateAppName',
        'footerTextUpdated' => 'updateFooterText',
    ];

    public function mount()
    {
        // Ambil pengaturan dari database atau gunakan default jika tidak ada
        $this->appName = Setting::getSetting('app_name', config('app.name'));
        $this->footerText = Setting::getSetting('footer_text', 'Default footer text');
    }

    public function saveSettings()
    {
        // Simpan pengaturan ke database
        Setting::setSetting('app_name', $this->appName);
        Setting::setSetting('footer_text', $this->footerText);

        // dispatch event untuk memperbarui tampilan di komponen lain tanpa reload
        $this->dispatch('appNameUpdated', $this->appName);
        $this->dispatch('footerTextUpdated', $this->footerText);

        toast('Pengaturan berhasil diperbarui!','success');
        return $this->redirect('/dashboard/pengaturan', navigate: true);
    }

    public function updateAppName($newName)
    {
        $this->appName = $newName;
    }

    public function updateFooterText($newText)
    {
        $this->footerText = $newText;
    }

    public function render()
    {
        return view('livewire.dashboard.settings.settings');
    }
}
