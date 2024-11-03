<?php

namespace App\Livewire\Dashboard\Sidebar;

use Livewire\Component;
use App\Models\Setting;

class Sidebar extends Component
{
    public $appName;
    public $footerText;

    protected $listeners = ['appNameUpdated' => 'updateAppName', 'footerTextUpdated' => 'updateFooterText'];

    public function mount()
    {
        $this->appName = Setting::getSetting('app_name', config('app.name'));
        $this->footerText = Setting::getSetting('footer_text', 'Default footer text');
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
        return view('livewire.dashboard.sidebar.sidebar');
    }
}
