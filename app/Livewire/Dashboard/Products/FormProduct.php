<?php

namespace App\Livewire\Dashboard\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCategory;
use RealRashid\SweetAlert\Facades\Alert;

class FormProduct extends Component
{
    use WithFileUploads;

    public $title, $image = [],$imagePaths = [], $price, $description, $categories = [], $wa_number, $product_category = [];
    // protected $listener = ['store' => 'render']; //auto update data ketika setelah tambah data
  
    public function mount()
    {
        // Load initial categories
        $this->categories = ProductCategory::select(['name','id'])->get();
    }

    // validation
    protected $rules = [
        'title' => 'required|string|max:150',
        'image' => 'required|array|min:1|max:5',
        'image.*' => 'required|image|max:5120',
        'product_category' => 'required|array',
        'wa_number' => 'required|digits_between:10,14',
        'price' => 'required|numeric|max:999999999',
        'description' => 'required|string',
    ];

    // Reset Form 
    public function resetForm()
    {
        $this->reset(['title', 'image', 'product_category', 'wa_number', 'price', 'description']);
    }

 
    public function store()
    {
        $this->validate();

        // Validasi gambar
        foreach ($this->image as $img) {
            $imagePaths [] = $img->store('product-images', 'public');
        }

        sleep(1);
        // Create new product
        $product = Product::create([
            'title' => $this->title,
            'image' => json_encode($imagePaths),
            'wa_number' => $this->wa_number,
            'price' => $this->price,
            'description' => $this->description,
        ]);

        // $this->description = '';
        // $this->dispatch('resetEditor');
        // Attach categories
        $product->categories()->sync($this->product_category);

        toast('Produk berhasil ditambahkan!','success');

        return redirect()->to('/dashboard/produk');

    }

    // render component
    public function render()
    {
        return view('livewire.dashboard.products.form-product');
    }

}
