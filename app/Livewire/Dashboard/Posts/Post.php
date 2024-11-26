<?php

namespace App\Livewire\Dashboard\Posts;

use Livewire\Component;
use App\Models\Post as ModelsPost;
use Illuminate\Support\Facades\Auth;

class Post extends Component
{

    public $search = '';
    public $limit = 5;
    public $totalPosts;

    // delete
    public $postId;
    public $postTitle;

    // detail post
    public $selectedPost = null;

   
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

    public function showPostDetail($id)
    {
        $this->selectedPost = ModelsPost::find($id); // Ambil objek Post berdasarkan ID, atau null jika tidak ditemukan
        if ($this->selectedPost) {
            $this->dispatch('show-detail-modal'); // Panggil event untuk membuka modal
        }
    }

    public function confirmDelete($id, $title)
    {
        $this->postId = $id;
        $this->postTitle = $title;
        $this->dispatch('show-delete-modal');
    }

    // Method Delete
    public function delete()
    {
        $post = ModelsPost::findOrFail($this->postId);
        $imagePath = $post->image;

        // Hapus file gambar jika ada
        if (file_exists(public_path('storage/' . $imagePath))) {
            unlink(public_path('storage/' . $imagePath));
        }

        // Hapus data 
        $post->delete();

        $this->dispatch('hide-delete-modal'); 
        $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
    }

    public function render()
    {

        $user = Auth::user();

        // Cek apakah pengguna adalah Admin atau Editor
        if ($user->roles->contains('name', 'Admin') || $user->roles->contains('name', 'Editor')) {
            // Jika Admin atau Editor, tampilkan semua postingan berdasarkan pencarian
            $posts = ModelsPost::with(['user', 'categories','tags'])
                ->where('title', 'like', '%' . $this->search . '%')
                ->latest()
                ->take($this->limit)
                ->get();
        } else {
            // Jika bukan Admin atau Editor, tampilkan hanya postingan milik user tersebut
            $posts = ModelsPost::with(['user', 'categories','tags'])
                ->where('user_id', $user->id) // Filter berdasarkan user_id
                ->where('title', 'like', '%' . $this->search . '%')
                ->latest()
                ->take($this->limit)
                ->get();
        }
        return view('livewire.dashboard.posts.post',[
            'posts' => $posts,
            'totalPosts' => $this->totalPosts
        ]);
    }
}
