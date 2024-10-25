<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            toast('Oops..post tidak tersedia,sudah dihapus atau bermasalah!','error');
            return redirect()->back();
        }

        return view('dashboard.posts.edit-post', compact('post'));
    }
}
