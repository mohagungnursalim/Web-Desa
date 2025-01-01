<?php

namespace App\Livewire\Dashboard\About;

use App\Models\About as ModelsAbout;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class About extends Component
{
    public $search = '';
    public $limit = 7;
    public $totalAbouts;
    public $abouts;
    public $about_id;
    public $isModalOpen = false;

    // Properti Form Add
    public $title, $description, $slug;

    // Properti Edit Form
    public $aboutTitle, $aboutDescription, $aboutSlug;

    // Delete
    public $aboutId;

    public function mount()
    {
        $this->totalAbouts = ModelsAbout::count();
        $this->abouts = collect();
    }

    public function updatingSearch()
    {
        $this->limit = 7;
    }

    public function updatedSearch()
    {
        usleep(500000); // Tambahkan jeda pencarian (ms)
        $this->loadInitialAbouts(); // Muat data sesuai pencarian
    }

    public function loadInitialAbouts()
    {
        $this->abouts = ModelsAbout::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->oldest()
            ->take($this->limit)
            ->get();
    }

    public function loadMore()
    {
        $this->limit += 7;
        $this->loadInitialAbouts();
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
        $newAbout = ModelsAbout::create([
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
        ]);
    
        $this->abouts->prepend($newAbout);
        $this->totalAbouts++;
    
        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('closeAddAboutModal');
        $this->dispatch('addedSuccess');
        $this->resetForm();
    }
    

    public function openUpdateModal($id)
    {
        try {
            $about = ModelsAbout::find($id);
            $this->about_id = $id;
            $this->aboutTitle = $about->title;
            $this->aboutDescription = $about->description;
    

            $this->dispatch('openEditAboutModal');
        } catch (ModelNotFoundException $e) {
            $this->dispatch('show-error');
        }
    }

    public function update()
    {
        $this->validate([
            'aboutTitle' => 'required|string|max:100',
            'aboutDescription' => 'required|string',
        ]);
    
        // Generate slug dari aboutTitle
        $this->aboutSlug = Str::slug($this->aboutTitle);
    
        $about = ModelsAbout::findOrFail($this->about_id);
        $about->title = $this->aboutTitle;
        $about->description = $this->aboutDescription;
        $about->slug = $this->aboutSlug;
        $about->save();
    
        $this->dispatch('aboutUpdated');
        $this->dispatch('closeUpdatedModal');
    }

    public function confirmDelete($id, $title)
    {
        try {
            // Coba cari data terlebih dahulu
             ModelsAbout::findOrFail($id);
    
            // Jika ditemukan, set properti untuk modal
            $this->aboutId = $id;
            $this->aboutTitle = $title;
    
            // Tampilkan modal konfirmasi
            $this->dispatch('show-delete-modal');
        } catch (ModelNotFoundException $e) {
            // Jika data tidak ditemukan, kirimkan event error
            $this->dispatch('show-error');
        }
    }
    

    public function delete()
    {
        $about = ModelsAbout::findOrFail($this->aboutId);
        $about->delete();

        $this->abouts = $this->abouts->filter(fn($item) => $item->id !== $this->aboutId);
        $this->totalAbouts--;

        $this->dispatch('hide-delete-modal');
        $this->dispatch('deleteSuccess');
    }

    public function render()
    {
        return view('livewire.dashboard.about.about', [
            'abouts' => $this->abouts,
            'totalAbouts' => $this->totalAbouts
        ]);
    }
}
