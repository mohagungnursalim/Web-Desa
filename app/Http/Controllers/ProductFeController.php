<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductFeController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        if (!$product) {
            toast('Oops..product tidak tersedia,sudah dihapus atau bermasalah!','error');
            return redirect()->back();
        }

        return view('frontend.produk-detail', compact('product'));
    }
}
