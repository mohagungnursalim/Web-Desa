<?php

namespace App\Livewire\Dashboard\Aduan;

use App\Models\Aduan as ModelsAduan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;


class Aduan extends Component
{
    public $search = '';
    public $limit = 7;
    public $totalAduans;
    public $aduans; 
    public $hasMore = true;

    public $aduanId,$aduanName,$aduanWa,$aduanImage = [],$aduanDescription,$aduanIsRead;

    
    public function mount()
    {
        $this->totalAduans = ModelsAduan::count();
        $this->aduans = collect();
    }

    public function updatingSearch()
    {
        $this->limit = 7;
    }

    public function updatedSearch()
    {
        usleep(500000);
        $this->loadInitialAduans();
    }

    public function loadInitialAduans()
    {
        $this->aduans = ModelsAduan::where('name', 'like', '%' . $this->search . '%')->latest()->take($this->limit)->get();
    }

    public function loadMore()
    {
        $this->limit += 7;
        $this->loadInitialAduans();
    }

    public function showPostDetail($id,$name,$wa_number,$image,$description)
    {
        try {
            $aduan = ModelsAduan::findOrFail($id);
            $this->aduanId = $id;
            $this->aduanName = $name;
            $this->aduanWa = $wa_number;
            $this->aduanImage = $image;
            $this->aduanDescription = $description;
    
            if ($this->aduanId == $id) {
                $this->dispatch('show-detail-modal'); // Panggil event untuk membuka modal
    
                $this->updateIsRead($id);
                $this->loadInitialAduans();
            }
        } catch (ModelNotFoundException $e) {
            $this->dispatch('error');
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
        try {
            ModelsAduan::findOrFail($id);
            $this->aduanId = $id;
            $this->aduanName = $name;
            $this->dispatch('show-delete-modal');
        } catch (ModelNotFoundException $e) {
            $this->dispatch('error');
        }
    }

     // Method Delete
     public function delete()
     {
         $aduan = ModelsAduan::findOrFail($this->aduanId);
 
         // Hapus data 
         $aduan->delete();

         $this->aduans = $this->aduans->filter(fn($item) => $item->id !== $this->aduanId);
         $this->totalAduans--;
         
         $this->dispatch('hide-delete-modal'); 
         $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
     }

    public function render()
    {

        return view('livewire.dashboard.aduan.aduan',[
            'aduans' => $this->aduans,
            'totalAduans' => $this->totalAduans
        ]);
    }
}
