<?php

namespace App\Livewire\Dashboard\Posts;

use Livewire\Component;
use App\Models\Post as ModelsPost;


class Post extends Component
{

    public $search = '';
    public $limit = 5;
    public $totalPosts;

   
    public function mount()
    {
        $this->totalPosts = ModelsPost::count();
    }

    public function updatingSearch()
    {
        usleep(500000);
        $this->limit = 5;
    }

    public function loadMore()
    {
        usleep(500000);
        $this->limit += 5;
    }

    // Method Delete
    public function delete($id)
    {
        $post = ModelsPost::findOrFail($id);
        $imagePath = $post->image;

        // Hapus file gambar jika ada
        if (file_exists(public_path('storage/' . $imagePath))) {
            unlink(public_path('storage/' . $imagePath));
        }

        // Hapus data 
        $post->delete();

        // Kirim event ke JavaScript dengan ID modal sebagai string
        $this->dispatch('hideModalDelete', 'modalDelete' . $id);  // Pastikan modal ID sebagai string
        $this->dispatch('deleteSuccess');
    }

    public function render()
    {
        $posts = ModelsPost::with(['user', 'categories'])->where('title', 'like', '%' . $this->search . '%')
        ->latest()->take($this->limit)->get();
        return view('livewire.dashboard.posts.post',[
            'posts' => $posts,
            'totalPosts' => $this->totalPosts
        ]);
    }
}
