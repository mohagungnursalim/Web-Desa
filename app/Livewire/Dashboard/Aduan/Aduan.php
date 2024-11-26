<?php

namespace App\Livewire\Dashboard\Aduan;

use App\Models\Aduan as ModelsAduan;
use Livewire\Component;

use function Livewire\Volt\updated;

class Aduan extends Component
{
    public $search = '';
    public $limit = 7;
    public $totalAduans;
    public $hasMore = true;

    public $aduanId,$aduanName,$aduanWa,$aduanImage = [],$aduanDescription,$aduanIsRead;

    
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

    public function showPostDetail($id,$name,$wa_number,$image,$description)
    {
        $this->aduanId = $id;
        $this->aduanName = $name;
        $this->aduanWa = $wa_number;
        $this->aduanImage = $image;
        $this->aduanDescription = $description;

        if ($this->aduanId) {
            $this->dispatch('show-detail-modal'); // Panggil event untuk membuka modal

            $this->updateIsRead($id);
        }
    }

    public function updateIsRead($id)
    {
        $aduan = ModelsAduan::findOrFail($id);

        $aduan->update([
            'is_read' => true
        ]);

    }

    public function confirmDelete($id, $name)
    {
        $this->aduanId = $id;
        $this->aduanName = $name;
        $this->dispatch('show-delete-modal');
    }

     // Method Delete
     public function delete()
     {
         $aduan = ModelsAduan::findOrFail($this->aduanId);
 
         // Hapus data 
         $aduan->delete();
 
         $this->dispatch('hide-delete-modal'); 
         $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
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
