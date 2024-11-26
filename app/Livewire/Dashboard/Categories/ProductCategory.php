<?php

namespace App\Livewire\Dashboard\Categories;

use App\Models\ProductCategory as ModelsProductCategory;
use Livewire\Component;

class ProductCategory extends Component
{

    public $search = '';
    public $limit = 7;
    public $totalCategories;
    public $category_id;
    public $isModalOpen = false;
    public $name;
   
    // Properti untuk menyimpan id kategori yang akan diupdate
    public $categoryName;
    public $categoryId;
    
    public function mount()
    {
        $this->totalCategories = ModelsProductCategory::count();
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

    // validation
    protected $rules = [
        'name' => 'required|string|max:30'
    ];

    // Reset Form 
    public function resetForm()
    {
        $this->reset(['name']);
    }    


    public function store()
    {
        $this->validate();

        // Create new product
        ModelsProductCategory::create([
            'name' => $this->name
        ]);

        // Reset form setelah menyimpan
        $this->resetForm();
        // Kirim event ke frontend untuk menutup modal
        $this->dispatch('closeAddCategoryModal');
        $this->dispatch('addedSuccess');
    }

    // Tambahkan method untuk membuka modal update
    public function openUpdateModal($id)
    {
        $this->category_id = $id;
        $this->categoryName = ModelsProductCategory::find($id)->name;
        
        $this->dispatch('openEditCategoryModal');
    }


    // Tambahkan method untuk update kategori
    public function update()
    {
        $this->validate([
            'categoryName' => 'required|string|max:30',
        ]);

        ModelsProductCategory::find($this->category_id)->update([
            'name' => $this->categoryName,
        ]);

        $this->dispatch('categoryUpdated');
        $this->dispatch('closeUpdatedModal'); // Tutup modal setelah update
    }
    
    
    public function confirmDelete($id, $name)
    {
        $this->categoryId = $id;
        $this->categoryName = $name;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        // Cari category berdasarkan ID
        $category = ModelsProductCategory::find($this->categoryId);

        // Cek jika category ditemukan
        if ($category) {

            
            $category->delete();
            
            $this->dispatch('hide-delete-modal'); 
            $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
           
        } else {

            toast('Oops..kategori tidak tersedia!','error');
            return redirect('/dashboard/kategori-produk');
        }
    }

    public function render()
    {
        $categories = ModelsProductCategory::where('name', 'like', '%' . $this->search . '%')->latest()
        ->take($this->limit)
        ->get();
        return view('livewire.dashboard.categories.product-category',[
            'categories' => $categories,
            'totalCategories' => $this->totalCategories
        ]);
    }


}
