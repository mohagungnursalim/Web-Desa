<?php

namespace App\Livewire\Frontend\Profil;

use App\Models\About;
use Livewire\Component;

class Profil extends Component
{
    public $profil;

    public function mount($slug)
    {
       $profil = About::where('slug',$slug)->first();
         if (!$profil) {
              abort(404);
         }
        $this->profil = $profil;
    }

    
    public function render()
    {
        return view('livewire.frontend.profil.profil');
    }
}
