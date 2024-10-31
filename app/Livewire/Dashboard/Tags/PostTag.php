<?php

namespace App\Livewire\Dashboard\Tags;

use App\Models\PostTag as ModelsPostTag;
use Livewire\WithFileUploads;
use Livewire\Component;

class PostTag extends Component
{
    use WithFileUploads;

    public $search = '';
    public $limit = 7;
    public $totalTags;
    public $tag_id;
    public $hasMore = true;
    public $isModalOpen = false;

    // properti Form Add
    public $name;

    // properti Edit Form
    public $tagUpdate;

    // Delete
    public $postTagId;
    public $postTagName;



    public function mount()
    {
        $this->totalTags = ModelsPostTag::count();
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

    // validasi rules
    protected $rules = [
        'name' => 'required|string|max:30',
    ];

    //reset form
    public function resetForm()
    {
        $this->reset(['name']);
    }
    
    public function store()
    {
        $this->validate();

        sleep(1);
        ModelsPostTag::create([
            'name' => $this->name
        ]);

        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('closeAddTagModal');
        $this->dispatch('addedSuccess');       
        $this->resetForm(); 
    }

    public function openUpdateModal($id)
    {
        $tag = ModelsPostTag::find($id);
        $this->tag_id = $id;
        $this->tagUpdate = $tag->name; // Mengambil nama kategori

        $this->dispatch('openEditTagModal'); // Kirim event untuk membuka modal dengan jQuery
    }
    

    public function update()
    {
        // Validasi input
        $this->validate([
            'tagUpdate' => 'required|string|max:30',
        ]);

        $tag = ModelsPostTag::findOrFail($this->tag_id);

        // Update data 
        $tag->name = $this->tagUpdate;

        sleep(1);
        $tag->save();

        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('tagUpdated');
        $this->dispatch('closeUpdatedModal'); // Tutup modal setelah update
    }


    public function confirmDelete($id, $name)
    {
        $this->postTagId = $id;
        $this->postTagName = $name;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $tag = ModelsPostTag::findOrFail($this->postTagId);

        // Hapus data kategori
        $tag->delete();

        $this->dispatch('hide-delete-modal'); 
        $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
    }

    public function render()
    {
        $tags = ModelsPostTag::where('name', 'like', '%' . $this->search . '%')->latest()
            ->take($this->limit)->get();

        return view('livewire.dashboard.tags.post-tag', [
            'tags' => $tags,
            'totalTags' => $this->totalTags
        ]);
    }
}
