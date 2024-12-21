<?php

namespace App\Livewire\Dashboard\Products;


use Livewire\Component;
use App\Models\Product as ModelProduct;

class Product extends Component
{
    public $search = '';
    public $limit = 8; // Limit produk yang akan ditampilkan pertama kali
    public $totalProducts; // Total produk di database
    public $products;
    public $product_id;

    // delete
    public $productId;
    public $productTitle;
    
    public function mount() 
    {
        // Menghitung total produk pada saat komponen pertama kali di-mount
        $this->totalProducts = ModelProduct::count();
        $this->products = collect();

    }

    public function updatingSearch()
    {
        // Mereset halaman dan limit jika pencarian berubah
        $this->limit = 8;
    }

    public function updatedSearch()
    {
        usleep(500000);
        $this->loadInitialProducts();
    }

    public function loadInitialProducts()
    {
        $query = ModelProduct::with(['categories:id,name'])
            ->where(function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                    ->orWhereHas('categories', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    });
            });

            $this->products = $query->take($this->limit)->get();  // Ambil hasil query
    }

    public function loadMore()
    {
        $this->limit += 8;
        $this->loadInitialProducts();
    }

    public function confirmDelete($id, $title)
    {
        $this->productId = $id;
        $this->productTitle = $title;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
       
        // Cari produk berdasarkan ID
        $product = ModelProduct::find($this->productId);

        // Cek jika produk ditemukan
        if ($product) {

            // Lokasi gambar
            $imagePaths = json_decode($product->image, true);

            // Hapus semua gambar yang terkait dengan product ini
            if ($imagePaths && is_array($imagePaths)) {
                foreach ($imagePaths as $imagePath) {
                    $filePath = storage_path('app/public/' . $imagePath);
                    
                    // Cek jika file gambar ada dan hapus
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            $product->categories()->detach();
            $product->delete();

            $this->products = $this->products->filter(fn($item) => $item->id !== $this->productId);
            $this->totalProducts--;

            $this->dispatch('hide-delete-modal'); 
            $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
           
        } else {

            toast('Oops..produk tidak tersedia!','error');
            return redirect('/dashboard/produk');
        }
    }




    public function render()
    {
        return view('livewire.dashboard.products.product', [
            'products' => $this->products,
            'totalProducts' => $this->totalProducts
        ]);
    }
}
