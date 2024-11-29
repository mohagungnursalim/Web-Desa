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
    public $isModalOpen = false;
    public $tags;

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
        $this->tags = collect(); // Koleksi kosong sebagai default
        
    }

    public function updatingSearch()
    {
        $this->limit = 7; // Reset limit saat pencarian baru

        usleep(700000); //menampilkan data pencarian 700ms
        $this->loadInitialTags(); // Muat ulang data berdasarkan pencarian
    }


    public function loadInitialTags()
    {
     
        $this->tags = ModelsPostTag::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->take($this->limit)
            ->get();
    }

    public function loadMore()
    {
       
        $this->limit += 7; // Tambahkan batas limit

        // Ambil data tambahan berdasarkan limit baru dan pencarian
        $newTags = ModelsPostTag::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->take($this->limit) // Ambil data sesuai limit yang baru
            ->get();

        // Simpan hanya data yang belum ada di $this->tags
        $this->tags = $newTags;
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
 
        $newTag = ModelsPostTag::create([
            'name' => $this->name
        ]);

        // Tambahkan data baru ke dalam properti $tags
        $this->tags->prepend($newTag);

        // Update total tag
        $this->totalTags++;

        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('closeAddTagModal');
        $this->dispatch('addedSuccess');

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
    
        // Hapus data dari properti $tags
        $this->tags = $this->tags->filter(function ($item) use ($tag) {
            return $item->id !== $tag->id; // Hanya ambil data yang ID-nya tidak sesuai dengan tag yang dihapus
        })->values(); // Reset indeks koleksi agar urutan kembali berurutan
    
        // Kurangi total tag
        $this->totalTags--;
    
        // Kirim event untuk menutup modal dan menampilkan notifikasi
        $this->dispatch('hide-delete-modal'); 
        $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
    }
    


    public function render()
    {
        return view('livewire.dashboard.tags.post-tag', [
            'tags' => $this->tags,
            'totalTags' => $this->totalTags,
        ]);
    }

}
