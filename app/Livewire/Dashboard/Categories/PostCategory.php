<?php

namespace App\Livewire\Dashboard\Categories;

use App\Models\PostCategory as ModelsPostCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\WithFileUploads;
use Livewire\Component;

class PostCategory extends Component
{
    use WithFileUploads;

    public $search = '';
    public $limit = 7;
    public $totalCategories;
    public $categories;
    public $category_id;
    public $isModalOpen = false;

    // properti Form Add
    public $name, $image;

    // properti Edit Form
    public $categoryName, $imageUpdate;

    // delete
    public $postCategoryId;
    public $postCategoryName;

    public function mount()
    {
        $this->totalCategories = ModelsPostCategory::count();
        $this->categories = collect();
    }

    public function updatingSearch()
    {
        $this->limit = 7;
    }

    public function updatedSearch()
    {
        usleep(500000); //Tambahkan jeda pencarian (ms)
        $this->loadInitialCategories(); //Muat data sesuai pencarian
    }

    public function loadInitialCategories()
    {
        $this->categories = ModelsPostCategory::where('name','like', '%' . $this->search . '%')->latest()->take($this->limit)->get();
    }
    public function loadMore()
    {
        $this->limit += 7;
        $this->loadInitialCategories();
    }

    // validasi rules
    protected $rules = [
        'name' => 'required|string|max:30',
        'image' => 'required|image|max:5120',
    ];

    //reset form
    public function resetForm()
    {
        $this->reset(['name', 'image']);
    }


    public function store()
    {
        $this->validate();

        $imagePath = $this->image->store('post-category', 'public');
        
        $newCategory = ModelsPostCategory::create([
            'name' => $this->name,
            'image' => $imagePath,
        ]);

        $this->categories->prepend($newCategory);
        $this->totalCategories++;

        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('closeAddCategoryModal');
        $this->dispatch('addedSuccess');       
        $this->resetForm(); 
    }

    public function openUpdateModal($id)
    {
        try {
            // Cari kategori berdasarkan ID, gunakan findOrFail agar otomatis menangkap error jika ID tidak ditemukan
            $category = ModelsPostCategory::findOrFail($id);
    
            // Jika ditemukan, set properti dan buka modal
            $this->category_id = $id;
            $this->categoryName = $category->name; // Mengambil nama kategori
            $this->imageUpdate = $category->image; // Mengambil gambar lama
    
            $this->dispatch('openEditCategoryModal'); // Panggil event untuk membuka modal edit
    
        } catch (ModelNotFoundException $e) {
            // Tangkap error lainnya
            $this->dispatch('error');
        }
    }
    
    

    public function update()
    {
        // Validasi input
        $this->validate([
            'categoryName' => 'required|string|max:30',
            'image' => 'nullable|image|max:5120', // image bisa optional
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

       
        $category->save();

        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('categoryUpdated');
        $this->dispatch('closeUpdatedModal'); // Tutup modal setelah update
    }

    public function confirmDelete($id, $name)
    {
       try {
            ModelsPostCategory::findOrFail($id);
            
            $this->postCategoryId = $id;
            $this->postCategoryName = $name;
            $this->dispatch('show-delete-modal');
       } catch (ModelNotFoundException $e) {
            $this->dispatch('error');
       }
    }

    public function delete()
    {
        $category = ModelsPostCategory::findOrFail($this->postCategoryId);
        $imagePath = $category->image;

        // Hapus file gambar jika ada
        if (file_exists(public_path('storage/' . $imagePath))) {
            unlink(public_path('storage/' . $imagePath));
        }
    
        // Hapus data kategori
        $category->delete();

        $this->categories = $this->categories->filter(fn($item) => $item->id !== $this->postCategoryId);
        $this->totalCategories--;

        $this->dispatch('hide-delete-modal'); 
        $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
    }

 

    public function render()
    {

        return view('livewire.dashboard.categories.post-category', [
            'categories' => $this->categories,
            'totalCategories' => $this->totalCategories
        ]);
    }
}
