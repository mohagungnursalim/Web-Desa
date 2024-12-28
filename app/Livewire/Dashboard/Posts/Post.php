<?php

namespace App\Livewire\Dashboard\Posts;

use Livewire\Component;
use App\Models\Post as ModelsPost;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class Post extends Component
{
    public $search = '';
    public $limit = 5;
    public $totalPosts;
    public $posts;

    // delete
    public $postId;
    public $postTitle;

    // detail post
    public $selectedPost = null;

   
    public function mount()
    {
        $this->totalPosts = ModelsPost::count();
        $this->posts = collect();
    }

    public function updatingSearch()
    {
        $this->limit = 5;
    }

    public function updatedSearch()
    {
        usleep(500000);
        $this->loadInitialPosts();
    }

    public function loadInitialPosts()
    {
        // Query untuk mencari post berdasarkan judul, excerpt, kategori, atau tag
        $query = ModelsPost::where(function ($query) {
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

        $user = Auth::user();

        // Jika user bukan Admin atau Editor, maka hanya menampilkan post yang dimilikinya
        if (!$user->roles->contains('name', 'Admin') && !$user->roles->contains('name', 'Editor')) {
            $query->where('user_id', $user->id);
        }

        // Simpan hasil query ke dalam property posts
        $this->posts = $query->get();
    }
    

    public function loadMore()
    {
        $this->limit += 5;  // Tambahkan limit sebanyak 5
        $this->loadInitialPosts(); // Load ulang post
    }

    public function showPostDetail($id)
    {
        try {
            $this->selectedPost = ModelsPost::findOrFail($id); // Ambil objek Post berdasarkan ID, atau null jika tidak ditemukan
            if ($this->selectedPost) {
                $this->dispatch('show-detail-modal'); // Panggil event untuk membuka modal
            }
        } catch (ModelNotFoundException $e) {
            $this->dispatch('error'); // Panggil event untuk menampilkan pesan error
        }
    }

    public function confirmDelete($id, $title)
    {
        try {

            ModelsPost::findOrFail($id); // Cek apakah post dengan ID tersebut ada
            
            $this->postId = $id;
            $this->postTitle = $title;
            $this->dispatch('show-delete-modal'); // Panggil event untuk membuka modal konfirmasi
        } catch (ModelNotFoundException $e) {
            $this->dispatch('error'); // Panggil event untuk menampilkan pesan error
        }
    
    }

    // Method Delete
    public function delete()
    {
        $post = ModelsPost::findOrFail($this->postId);
        $imagePath = $post->image;

        // Hapus file gambar jika ada
        if (file_exists(public_path('storage/' . $imagePath))) {
            unlink(public_path('storage/' . $imagePath)); // Hapus file gambar
        }

        // Hapus data 
        $post->delete();

        $this->posts = $this->posts->filter(fn($item) => $item->id !== $this->postId);
        $this->totalPosts--;
        $this->dispatch('hide-delete-modal'); 
        $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses
    }

    public function render()
    {
        return view('livewire.dashboard.posts.post',[
            'posts' => $this->posts,
            'totalPosts' => $this->totalPosts
        ]);
    }
}