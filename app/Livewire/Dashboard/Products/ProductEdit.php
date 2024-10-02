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
        $this->image = $product->image;
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
        
         
       // Mengelola penggantian gambar jika ada file baru
        if ($this->image instanceof \Illuminate\Http\UploadedFile) {
            // Jika ada gambar lama, hapus
            if ($product->image) {
                $oldImagePath = public_path('storage/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            // Simpan gambar baru
            $product->image = $this->image->store('products', 'public');
        }
        // Jika tidak ada gambar baru yang diupload, biarkan gambar lama


        usleep(500000);
        // Simpan perubahan produk
        $product->save();
        // Update kategori yang dipilih
        // $product->categories()->sync($this->selectedId);
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
