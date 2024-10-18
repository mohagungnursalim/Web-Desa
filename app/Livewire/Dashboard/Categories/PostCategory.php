<?php

namespace App\Livewire\Dashboard\Categories;

use App\Models\PostCategory as ModelsPostCategory;
use Livewire\WithFileUploads;
use Livewire\Component;

class PostCategory extends Component
{
    use WithFileUploads;

    public $search = '';
    public $limit = 5;
    public $totalCategories;
    public $category_id;
    public $hasMore = true;
    public $isModalOpen = false;

    // properti Form Add
    public $name, $image, $color;

    // properti Edit Form
    public $categoryName, $imageUpdate, $colorUpdate;

    public function mount()
    {
        $this->totalCategories = ModelsPostCategory::count();
    }

    public function updatingSearch()
    {
        $this->limit = 5;
        $this->hasMore = true; 
    }

    public function loadMore()
    {
        usleep(500000);
        $this->limit += 5;
    }

    // validasi rules
    protected $rules = [
        'name' => 'required|string|max:30',
        'image' => 'required|image|max:5120',
        'color' => 'required'
    ];

    //reset form
    public function resetForm()
    {
        $this->reset(['name', 'image', 'color']);
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    public function store()
    {
        $this->validate();

        $imagePath = $this->image->store('post-category', 'public');
        
        sleep(1);
        ModelsPostCategory::create([
            'name' => $this->name,
            'image' => $imagePath,
            'color' => $this->color
        ]);

        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('closeAddCategoryModal');
        $this->dispatch('addedSuccess');       
        $this->resetForm(); 
    }

    public function openUpdateModal($id)
    {
        $category = ModelsPostCategory::find($id);
        $this->category_id = $id;
        $this->categoryName = $category->name; // Mengambil nama kategori
        $this->imageUpdate = $category->image; // Mengambil gambar lama
        $this->colorUpdate = $category->color; // Mengambil warna lama
    
        $this->dispatch('openEditCategoryModal');
    }
    

    public function update()
    {
        // Validasi input
        $this->validate([
            'categoryName' => 'required|string|max:30',
            'image' => 'nullable|image|max:5120', // image bisa optional
            'colorUpdate' => 'required'
        ]);

        $category = ModelsPostCategory::findOrFail($this->category_id);
        $oldImagePath = $category->image;

        // Jika ada gambar baru, simpan gambar dan hapus gambar lama jika ada
        if ($this->image) {
            $newImagePath = $this->image->store('post-category', 'public');

            // Hapus gambar lama jika ada
            if (file_exists(public_path('storage/' . $oldImagePath))) {
                unlink(public_path('storage/' . $oldImagePath));
            }

            // Update path gambar
            $category->image = $newImagePath;
        }

        // Update data lainnya
        $category->name = $this->categoryName;
        $category->color = $this->colorUpdate;

        sleep(1);
        $category->save();

        // Kirim event ke frontend untuk menutup modal
        $this->resetForm();
        $this->dispatch('categoryUpdated');
        $this->dispatch('closeUpdatedModal'); // Tutup modal setelah update
    }


    public function delete($id)
    {
        $category = ModelsPostCategory::findOrFail($id);
        $imagePath = $category->image;

        // Hapus file gambar jika ada
        if (file_exists(public_path('storage/' . $imagePath))) {
            unlink(public_path('storage/' . $imagePath));
        }

        // Hapus data kategori
        $category->delete();

        // Kirim event ke JavaScript dengan ID modal sebagai string
        $this->dispatch('hideModalDelete', 'modalDelete' . $id);  // Pastikan modal ID sebagai string
        $this->dispatch('deleteSuccess');
    }

 

    public function render()
    {
        $categories = ModelsPostCategory::where('name', 'like', '%' . $this->search . '%')->latest()
            ->take($this->limit)->get();
        return view('livewire.dashboard.categories.post-category', [
            'categories' => $categories,
            'totalCategories' => $this->totalCategories
        ]);
    }
}
