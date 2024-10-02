<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            toast('Oops..produk tidak tersedia!','error');
            return redirect()->back();
        }

        return view('dashboard.products.edit-product', compact('product'));
    }
}
