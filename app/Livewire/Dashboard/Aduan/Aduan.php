<?php

namespace App\Livewire\Dashboard\Aduan;

use App\Models\Aduan as ModelsAduan;
use Livewire\Component;

class Aduan extends Component
{
    public $search = '';
    public $limit = 7;
    public $totalAduans;
    public $hasMore = true;

    public $aduanId;
    public $aduanName;
    
    public function mount()
    {
        $this->totalAduans = ModelsAduan::count();
    }

    public function updatingSearch()
    {
        $this->limit = 7;
    }
    public function loadMore()
    {
        usleep(500000);
        $this->limit += 7;
    }

    public function confirmDelete($id, $name)
    {
        $this->aduanId = $id;
        $this->aduanName = $name;
        $this->dispatch('show-delete-modal');
    }

    public function render()
    {
        $aduans = ModelsAduan::where('name', 'like', '%' . $this->search . '%')->latest()
        ->take($this->limit)->get();

        return view('livewire.dashboard.aduan.aduan',[
            'aduans' => $aduans,
            'totalAduans' => $this->totalAduans
        ]);
    }
}
