<?php

namespace App\Livewire\Frontend\Layanan;

use App\Models\Layanan as ModelsLayanan;
use Livewire\Component;

class Layanan extends Component
{
    public function render()
    {
        $layanans = ModelsLayanan::select(['id','title','slug','description'])->oldest()->get();
        return view('livewire.frontend.layanan.layanan',[
            'layanans' => $layanans
        ]);
    }
}
