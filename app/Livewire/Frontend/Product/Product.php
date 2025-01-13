<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Product as ModelsProduct;
use Livewire\Component;

class Product extends Component
{
    public $search = '';
    public $limit = 6;
    public $totalProducts;
    public $products;
    public $productsCount;

    
    public function mount()
    {
        $this->totalProducts = ModelsProduct::count();
        $this->products = collect();
    }

    public function updatingSearch()
    {
        $this->limit = 6;
    }

    public function updatedSearch()
    {
        $this->loadInitialProducts();
    }

    public function loadInitialProducts()
    {
        // Query untuk mencari produk berdasarkan judul, excerpt, kategori, atau tag
        $query = ModelsProduct::where(function ($query) {
                $query->where('title', 'like', "%{$this->search}%");
                    // ->orWhere('excerpt', 'like', "%{$this->search}%");
            })
            ->latest()
            ->take($this->limit);
    
        // Simpan hasil query ke dalam property products
        $this->products = $query->get();
    }
    

    public function loadMore()
    {
        $this->limit += 6;  // Tambahkan limit sebanyak 6
        $this->loadInitialProducts(); // Load ulang product
    }
    

    public function render()
    {
        $remainingProducts = $this->totalProducts - $this->products->count();
        return view('livewire.frontend.product.product', compact('remainingProducts'));
    }
}
