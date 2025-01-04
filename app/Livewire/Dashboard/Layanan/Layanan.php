<?php

namespace App\Livewire\Dashboard\Layanan;

use App\Models\Layanan as ModelsLayanan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Layanan extends Component
{
    public $search = '';
    public $limit = 7;
    public $totalLayanans;
    public $layanans;
    public $layanan_id;
    public $isModalOpen = false;

    // Properti Form Add
    public $title, $description, $slug;

    // Properti Edit Form
    public $layananTitle, $layananDescription, $layananSlug;

    // Delete
    public $layananId;

    public function mount()
    {
        $this->totalLayanans = ModelsLayanan::count();
        $this->layanans = collect();
    }

    public function updatingSearch()
    {
        $this->limit = 7;
    }

    public function updatedSearch()
    {
        usleep(500000); // Tambahkan jeda pencarian (ms)
        $this->loadInitialLayanans(); // Muat data sesuai pencarian
    }

    public function loadInitialLayanans()
    {
        $this->layanans = ModelsLayanan::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->oldest()
            ->take($this->limit)
            ->get();
    }

    public function loadMore()
    {
        $this->limit += 7;
        $this->loadInitialLayanans();
    }

    // Validasi rules
    protected $rules = [
        'title' => 'required|string|max:100',
        'description' => 'required|string',
    ];

    // Reset form
    public function resetForm()
    {
        $this->reset(['title', 'description', 'slug']);
    }

    public function store()
    {
        $this->validate();
    
        // Generate slug dari title
        $this->slug = Str::slug($this->title);
    
        // Buat record baru
        $newLayanan = ModelsLayanan::create([
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
        ]);
    
        $this->layanans->prepend($newLayanan);
        $this->totalLayanans++;
    
        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('closeAddLayananModal');
        $this->dispatch('addedSuccess');
        $this->resetForm();
    }
    

    public function openUpdateModal($id)
    {
        try {
            $layanan = ModelsLayanan::find($id);
            $this->layanan_id = $id;
            $this->layananTitle = $layanan->title;
            $this->layananDescription = $layanan->description;
    

            $this->dispatch('openEditLayananModal');
        } catch (ModelNotFoundException $e) {
            $this->dispatch('show-error');
        }
    }

    public function update()
    {
        $this->validate([
            'layananTitle' => 'required|string|max:100',
            'layananDescription' => 'required|string',
        ]);
    
        // Generate slug dari layananTitle
        $this->layananSlug = Str::slug($this->layananTitle);
    
        $layanan = ModelsLayanan::findOrFail($this->layanan_id);
        $layanan->title = $this->layananTitle;
        $layanan->description = $this->layananDescription;
        $layanan->slug = $this->layananSlug;
        $layanan->save();
    
        $this->dispatch('layananUpdated');
        $this->dispatch('closeUpdatedModal');
    }

    public function confirmDelete($id, $title)
    {
        try {
            // Coba cari data terlebih dahulu
             ModelsLayanan::findOrFail($id);
    
            // Jika ditemukan, set properti untuk modal
            $this->layananId = $id;
            $this->layananTitle = $title;
    
            // Tampilkan modal konfirmasi
            $this->dispatch('show-delete-modal');
        } catch (ModelNotFoundException $e) {
            // Jika data tidak ditemukan, kirimkan event error
            $this->dispatch('show-error');
        }
    }
    

    public function delete()
    {
        $layanan = ModelsLayanan::findOrFail($this->layananId);
        $layanan->delete();

        $this->layanans = $this->layanans->filter(fn($item) => $item->id !== $this->layananId);
        $this->totalLayanans--;

        $this->dispatch('hide-delete-modal');
        $this->dispatch('deleteSuccess');
    }

    public function render()
    {
        return view('livewire.dashboard.layanan.layanan', [
            'layanans' => $this->layanans,
            'totalLayanans' => $this->totalLayanans
        ]);
    }
}

