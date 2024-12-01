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
        $this->limit = 7; // Set ulang limit ke nilai awal
    }

    public function updatedSearch()
    {
        usleep(500000); //menampilkan data pencarian 500ms
        $this->loadInitialTags(); // Muat data baru setelah pencarian di-update
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
        $newTags = ModelsPostTag::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->skip($this->tags->count()) // Lewati data yang sudah ada
            ->take($this->limit) // Tambahkan data baru sesuai limit
            ->get();

        $this->tags = $this->tags->merge($newTags); // Gabungkan data baru dengan data lama

        // Update totalTags jika pencarian mengubah total data
        $this->totalTags = ModelsPostTag::where('name', 'like', '%' . $this->search . '%')->count();

        $this->limit += 7;
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
