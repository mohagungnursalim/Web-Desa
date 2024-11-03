<?php

namespace App\Livewire\Dashboard\Footer;

use Livewire\Component;
use App\Models\Setting;

class Footer extends Component
{
    public $footerText;

    protected $listeners = ['footerTextUpdated' => 'updateFooterText'];

    public function mount()
    {
        $this->footerText = Setting::getSetting('footer_text', 'Default footer text');
    }

    public function updateFooterText($newText)
    {
        $this->footerText = $newText;
    }

    public function render()
    {
        return view('livewire.dashboard.footer.footer');
    }
}
