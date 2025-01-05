<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function show($slug)
    {
        $profil = About::where('slug', $slug)->first();

        if (!$profil) {
            toast('Oops..data tidak tersedia!','error');
            return redirect()->back();
        }

        return view('frontend.profil', compact('profil'));
    }
}
