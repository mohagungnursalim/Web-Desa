<?php

namespace App\Livewire\Frontend\Berita;

use App\Models\Post;
use Livewire\Component;

class Berita extends Component
{
    public $search = '';
    public $limit = 6;
    public $totalPosts;
    public $posts;
    public $postsCount;


   
    public function mount()
    {
        $this->totalPosts = Post::count();
        $this->posts = collect();
    }

    public function updatingSearch()
    {
        $this->limit = 6;
    }

    public function updatedSearch()
    {
        $this->loadInitialPosts();
    }

    public function loadInitialPosts()
    {
        // Query untuk mencari post berdasarkan judul, excerpt, kategori, atau tag
        $query = Post::where(function ($query) {
            $query->where('title', 'like', "%{$this->search}%")
                ->orWhere('excerpt', 'like', "%{$this->search}%")
                ->orWhereHas('categories', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                })
                ->orWhereHas('tags', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
        })
        ->latest()
        ->take($this->limit);

        // Simpan hasil query ke dalam property posts
        $this->posts = $query->get();
    }
    

    public function loadMore()
    {
        $this->limit += 6;  // Tambahkan limit sebanyak 6
        $this->loadInitialPosts(); // Load ulang post
    }

    public function render()
    {
        // Hitung sisa data yang belum dimuat
        $remainingPosts = $this->totalPosts - $this->posts->count();
        return view('livewire.frontend.berita.berita', compact('remainingPosts'));
    }
}
