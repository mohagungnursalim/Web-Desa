<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Product;
use Livewire\Component;

class ProductDetail extends Component
{
    public $product;

    public function mount($id)
    {
        $product = Product::findOrFail($id);

        if (!$product) {
            toast('Oops..product tidak tersedia,sudah dihapus atau bermasalah!','error');
            return redirect()->back();
        }

        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.frontend.product.product-detail');
    }
}
