<?php

namespace App\Livewire\Dashboard\Products;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductEdit extends Component
{
    use WithFileUploads;

    public $product;
    public $product_id, $title, $image, $price, $description, $wa_number, $product_category = [];
    public $categories = [];
    public $selectedId = []; // untuk kategori yang dipilih
    public $existingImages = [];

    // Validasi input
    protected $rules = [
        'title' => 'required|string|max:150',
        'selectedId' => 'required|array',
        'wa_number' => 'required|digits_between:10,14',
        'price' => 'required|numeric|max:999999999',
        'description' => 'required|string',
    ];
    // Validasi image
    protected $imageRules = ['nullable', 'image', 'max:5120'];

    public function mount($id)
    {
        $product = Product::findOrFail($id);
        $this->product = $product; // Tambahkan baris ini
        $this->product_id = $product->id;
        $this->existingImages = json_decode($product->image,true);
        $this->title = $product->title;
        $this->wa_number = $product->wa_number;
        $this->price = $product->price;
        $this->description = $product->description;
           // Memastikan categories adalah koleksi Eloquent sebelum pluck
        if (is_array($product['categories'])) {
            // Jika categories berbentuk array, kita ambil id secara manual
            $this->selectedId = array_map(function($category) {
                return $category['id'];
            }, $product['categories']);
        } else {
            // Jika categories adalah koleksi Eloquent, kita bisa langsung menggunakan pluck
            $this->selectedId = $product->categories->pluck('id')->toArray();
        }
        // Parsing data ke view edit
        $this->categories = ProductCategory::select(['name','id'])->get();
    }

    public function update()
    {
        // Validasi input
        $this->validate();

        // Validasi gambar secara terpisah jika ada gambar baru
        if ($this->image instanceof \Illuminate\Http\UploadedFile) {
            $this->validate(['image' => $this->imageRules]);
        }
        // Update produk yang ada
        $product = Product::find($this->product_id);
        $product->title = $this->title;
        $product->wa_number = $this->wa_number;
        $product->price = $this->price;
        $product->description = $this->description;
        
         
        if (!empty($this->image) && is_array($this->image)) {
            // Menghapus gambar lama jika ada
            if ($product->image) {
                $oldImages = json_decode($product->image, true);
                foreach ($oldImages as $oldImage) {
                    $oldImagePath = public_path('storage/' . $oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }
        
            // Menyimpan gambar baru
            foreach ($this->image as $img) {
                if ($img instanceof \Illuminate\Http\UploadedFile) {
                    $imagePaths[] = $img->store('product-images', 'public');
                }
            }
        
            if (!empty($imagePaths)) {
                $product->image = json_encode($imagePaths);
            }
        } else {
            // Jika tidak ada gambar baru yang di-upload, tetap gunakan gambar lama
            $product->image = $product->image;
        }
        

        sleep(1);
        // Simpan perubahan produk
        $product->save();

        // Update kategori yang dipilih
        $product->categories()->sync($this->selectedId);

        // Menampilkan notifikasi berhasil menggunakan toast
        toast('Produk berhasil diperbarui!', 'success');

        // Redirect ke halaman dashboard produk
        return redirect()->to('/dashboard/produk');
    }

    public function render()
    {
        // Menampilkan view dengan daftar kategori
        return view('livewire.dashboard.products.product-edit');
    }
}
