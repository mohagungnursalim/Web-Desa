<?php

namespace App\Livewire\Frontend\Home;

use App\Models\Post;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $posts = Post::select(['title', 'description','image','slug'])->latest()->take(3)->get();

        return view('livewire.frontend.home.home',[
            'posts' => $posts
        ]);
    }
}
