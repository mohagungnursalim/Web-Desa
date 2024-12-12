<?php

namespace App\Livewire\Dashboard\Sidebar;

use Livewire\Component;
use App\Models\Setting;

class Sidebar extends Component
{
    public $appName;
    public $footerText;
    public $appLogo;

    protected $listeners = [
        'appNameUpdated' => 'updateAppName', 
        'footerTextUpdated' => 'updateFooterText',
        'appLogoUpdated' => 'updatedAppLogo'
    ];

    public function mount()
    {
        $this->appName = Setting::getSetting('app_name', config('app.name'));
        $this->footerText = Setting::getSetting('footer_text', 'Default footer text');
        $this->appLogo = Setting::getSetting('appLogo', null);
    }

    public function render()
    {
        return view('livewire.dashboard.sidebar.sidebar');
    }
}
