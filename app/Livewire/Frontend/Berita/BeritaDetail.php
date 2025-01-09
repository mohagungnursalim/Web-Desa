<?php

namespace App\Livewire\Frontend\Berita;

use App\Models\Post;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class BeritaDetail extends Component
{
    public $post;

    public function mount($slug)
    {
        $post = Post::without(['user', 'categories', 'tags'])->where('status', 'published')->where('slug', $slug)->first();

        if (!$post) {
            abort(404);
        }

        // Increment total views
        $post->increment('views');

        // Handle unique views using JSON
        $ipAddress = Request::ip();
        $uniqueIps = $post->unique_views ? json_decode($post->unique_views, true) : [];

        if (!in_array($ipAddress, $uniqueIps)) {
            // Add the IP address to the JSON column
            $uniqueIps[] = $ipAddress;

            // Update the `unique_views` column
            $post->unique_views = json_encode($uniqueIps);
            $post->save();
        }

        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.frontend.berita.berita-detail', [
            'uniqueCount' => $this->getUniqueViewsCount(),
        ]);
    }

    private function getUniqueViewsCount()
    {
        return $this->post->unique_views
            ? count(json_decode($this->post->unique_views, true))
            : 0;
    }
}
