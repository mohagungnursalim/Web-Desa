<?php

namespace App\Livewire\Frontend\Home;

use App\Models\Post;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $posts = Post::select(['title', 'description','image','slug'])->latest()->take(5)->get();
        $products = Product::select(['title','price','image','description','wa_number'])->latest()->take(6)->get();
        return view('livewire.frontend.home.home',[
            'posts' => $posts,
            'products' => $products
        ]);
    }
}
