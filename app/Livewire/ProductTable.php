<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductTable extends Component
{
    public $search = '';
    public $limit = 10; // Batas produk yang akan ditampilkan pertama kali
    public $totalProducts; // Total produk di database

    public function mount() 
    {
        // Menghitung total produk pada saat komponen pertama kali di-mount
        $this->totalProducts = Product::count();
    }

    public function updatingSearch()
    {
        // Mereset halaman dan limit jika pencarian berubah
        $this->limit = 10;
        
    }

    public function loadMore()
    {
        // Tambah jumlah produk yang ditampilkan setiap kali tombol Load More diklik
        $this->limit += 10;

        sleep(1);
    }

    public function render()
    {
        // Ambil produk berdasarkan pencarian dan jumlah limit
        $products = Product::where('name', 'like', '%' . $this->search . '%')
                           ->latest()
                           ->take($this->limit)
                           ->get();

        return view('livewire.product-table', [
            'products' => $products,
            'totalProducts' => $this->totalProducts
        ]);
    }
}
