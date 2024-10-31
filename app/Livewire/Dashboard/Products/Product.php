<?php

namespace App\Livewire\Dashboard\Products;


use Livewire\Component;
use App\Models\Product as ModelProduct;

class Product extends Component
{
    public $search = '';
    public $limit = 8; // Limit produk yang akan ditampilkan pertama kali
    public $totalProducts; // Total produk di database
    public $product_id;

    // delete
    public $productId;
    public $productTitle;
    
    public function mount() 
    {
        // Menghitung total produk pada saat komponen pertama kali di-mount
        $this->totalProducts = ModelProduct::count();

    }

    public function updatingSearch()
    {
        // Mereset halaman dan limit jika pencarian berubah
        $this->limit = 8;
    }

    public function loadMore()
    {
        usleep(500000);
        $this->limit += 8;
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

            $this->dispatch('hide-delete-modal'); 
            $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
           
        } else {

            toast('Oops..produk tidak tersedia!','error');
            return redirect('/dashboard/produk');
        }
    }




    public function render()
    {
        // Ambil produk berdasarkan pencarian dan jumlah limit
        $products = ModelProduct::with('categories')->where('title', 'like', '%' . $this->search . '%')
                           ->latest()
                           ->take($this->limit)
                           ->get();

        return view('livewire.dashboard.products.product', [
            'products' => $products,
            'totalProducts' => $this->totalProducts
        ]);
    }
}
