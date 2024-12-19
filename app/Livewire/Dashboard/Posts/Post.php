<?php

namespace App\Livewire\Dashboard\Posts;

use Livewire\Component;
use App\Models\Post as ModelsPost;
use Illuminate\Support\Facades\Auth;

class Post extends Component
{
    public $search = '';
    public $limit = 5;
    public $total_posts;
    public $posts;

    // delete
    public $post_id;
    public $post_title;

    // detail post
    public $selected_post = null;

    public function mount()
    {
        $this->total_posts = ModelsPost::count();
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
        $user = Auth::user();

        // Check if the user is Admin or Editor
        if ($user->roles->contains('name', 'Admin') || $user->roles->contains('name', 'Editor')) {
            // Show all posts based on search for Admin or Editor
            $this->posts = ModelsPost::with(['user', 'categories', 'tags'])
                ->where('title', 'like', '%' . $this->search . '%')
                ->latest()
                ->take($this->limit)
                ->get();
        } else {
            // Show only the user's posts if not Admin or Editor
            $this->posts = ModelsPost::with(['user', 'categories', 'tags'])
                ->where('user_id', $user->id)
                ->where('title', 'like', '%' . $this->search . '%')
                ->latest()
                ->take($this->limit)
                ->get();
        }
    }

    public function loadMore()
    {
        $this->limit += 5;
        $this->loadInitialPosts();
    }

    public function showPostDetail($id)
    {
        $this->selected_post = ModelsPost::find($id);
        if ($this->selected_post) {
            $this->dispatch('show-detail-modal');
        }
    }

    public function confirmDelete($id, $title)
    {
        $this->post_id = $id;
        $this->post_title = $title;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $post = ModelsPost::findOrFail($this->post_id);
        $image_path = $post->image;

        // Delete image file if it exists
        if (file_exists(public_path('storage/' . $image_path))) {
            unlink(public_path('storage/' . $image_path));
        }

        // Delete post
        $post->delete();

        $this->posts = $this->posts->filter(fn($item) => $item->id !== $this->post_id);
        $this->total_posts--;
        $this->dispatch('hide-delete-modal');
        $this->dispatch('delete-success');
    }

    public function render()
    {
        return view('livewire.dashboard.posts.post', [
            'posts' => $this->posts,
            'total_posts' => $this->total_posts
        ]);
    }
}
