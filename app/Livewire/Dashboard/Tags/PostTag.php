<?php

namespace App\Livewire\Dashboard\Tags;

use App\Models\PostTag as ModelsPostTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\WithFileUploads;
use Livewire\Component;

class PostTag extends Component
{
    use WithFileUploads;

    public $search = '';
    public $limit = 7;
    public $totalTags;
    public $tags;
    public $tag_id;
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
        $this->tags = collect(); // Koleksi kosong untuk defer loading
    }

    public function updatingSearch()
    {
        $this->limit = 7; // Reset limit saat pencarian diubah
    }

    public function updatedSearch()
    {
        usleep(500000); // Tambahkan jeda pencarian
        $this->loadInitialTags(); // Muat data sesuai pencarian
    }

    public function loadInitialTags()
    {
        $this->tags = ModelsPostTag::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->take($this->limit) // Ambil data berdasarkan limit terbaru
            ->get();
    }
    

    public function loadMore()
    {
        $this->limit += 7; // Tingkatkan limit tanpa menggunakan skip
        $this->loadInitialTags(); // Panggil fungsi untuk memuat data baru sesuai limit
    }


    // validasi rules
    protected $rules = [
        'name' => 'required|string|max:30',
    ];

    public function resetForm()
    {
        $this->reset(['name']);
    }

    public function store()
    {
        $this->validate();

        $newTag = ModelsPostTag::create(['name' => $this->name]);

        $this->tags->prepend($newTag); // Tambahkan data baru ke awal
        $this->totalTags++; // Perbarui total data
        $this->dispatch('closeAddTagModal'); // Tutup modal tambah
        $this->dispatch('addedSuccess'); // Notifikasi sukses
    }

    public function openUpdateModal($id)
    {
       try {
            $tag = ModelsPostTag::findOrFail($id);
            $this->tag_id = $tag->id;
            $this->tagUpdate = $tag->name;
            $this->dispatch('openEditTagModal'); // Buka modal edit
        } catch (ModelNotFoundException $e) {
            $this->dispatch('error'); // Notifikasi error
        }
    }

    public function update()
    {
        $this->validate([
            'tagUpdate' => 'required|string|max:30',
        ]);

        $tag = ModelsPostTag::findOrFail($this->tag_id);
        $tag->update(['name' => $this->tagUpdate]); // Update data
        $this->dispatch('closeUpdatedModal'); // Tutup modal edit
        $this->dispatch('tagUpdated'); // Notifikasi sukses
    }

    public function confirmDelete($id, $name)
    {
        try {
            ModelsPostTag::findOrFail($id); // Cek apakah data ada
        
            $this->postTagId = $id;
            $this->postTagName = $name;
            $this->dispatch('show-delete-modal'); // Buka modal konfirmasi hapus
        } catch (ModelNotFoundException $e) {
            $this->dispatch('error'); // Notifikasi error
        }
    }

    public function delete()
    {
        $tag = ModelsPostTag::findOrFail($this->postTagId);
        $tag->delete(); // Hapus data dari database

        $this->tags = $this->tags->filter(fn($item) => $item->id !== $this->postTagId); // Hapus dari koleksi
        $this->totalTags--; // Kurangi total data
        $this->dispatch('hide-delete-modal'); // Tutup modal hapus
        $this->dispatch('deleteSuccess'); // Notifikasi sukses
    }

    public function render()
    {
        return view('livewire.dashboard.tags.post-tag', [
            'tags' => $this->tags,
            'totalTags' => $this->totalTags,
        ]);
    }
}
