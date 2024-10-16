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
    public $isUpdateModalOpen = false;
    
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


    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
        
    }

    public function store()
    {
        $this->validate();

        sleep(1);

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
        $this->isUpdateModalOpen = true;
    }

    // Tambahkan method untuk menutup modal update
    public function closeUpdateModal()
    {
        $this->isUpdateModalOpen = false;
    }

    // Tambahkan method untuk update kategori
    public function update()
    {
        $this->validate([
            'categoryName' => 'required|string|max:30',
        ]);

        sleep(1);
        ModelsProductCategory::find($this->category_id)->update([
            'name' => $this->categoryName,
        ]);

        $this->closeUpdateModal();
        $this->dispatch('categoryUpdated');
    }
    
    

    public function delete($id)
    {
        $this->category_id = $id;
        // Cari category berdasarkan ID
        $category = ModelsProductCategory::find($id);

        // Cek jika category ditemukan
        if ($category) {

            sleep(1);
            $category->delete();
            
            // Kirim event ke JavaScript dengan ID modal sebagai string
            $this->dispatch('hideModalDelete', 'modalDelete' . $id);  // Pastikan modal ID sebagai string
            $this->dispatch('deleteSuccess');
           
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
