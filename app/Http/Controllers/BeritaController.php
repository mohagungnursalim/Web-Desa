<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function show($slug)
    {
        $post = Post::select('slug')->where('slug', $slug)->first();

        if (!$post) {
            toast('Oops..post tidak tersedia,sudah dihapus atau bermasalah!','error');
            return redirect()->back();
        }

        return view('frontend.berita-detail', compact('post'));
    }
}
