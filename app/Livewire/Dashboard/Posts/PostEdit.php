<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\Post as ModelsPost;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Str;

class PostEdit extends Component
{
    use WithFileUploads;

    public $title;
    public $categories = [];
    public $post_category = [];
    public $tags = [];
    public $post_tag = [];
    public $slug;
    public $description;
    public $excerpt;
    public $user_id;
    public $image;
    public $status;
    public $published_at;
    public $selected_category = [];
    public $selected_tag = [];
    public $existing_image; // Gambar lama

    public function mount($slug)
    {
        $post = ModelsPost::where('slug', $slug)->first();
        if (!$post) {
            abort(404);
        }

        $this->existing_image = $post->image;
        $this->title = $post->title;

        $this->selected_category = is_array($post['categories'])
            ? array_column($post['categories'], 'id')
            : $post->categories->pluck('id')->toArray();

        $this->selected_tag = is_array($post['tags'])
            ? array_column($post['tags'], 'id')
            : $post->tags->pluck('id')->toArray();

        $this->categories = PostCategory::select(['name', 'id'])->latest()->get();
        $this->tags = PostTag::select(['name', 'id'])->latest()->get();
        $this->description = $post->description;
        $this->published_at = $post->published_at;
    }

    protected $rules = [
        'title' => 'required|max:150',
        'selected_category' => 'required|array',
        'selected_tag' => 'required|array',
        'description' => 'required',
        'published_at' => 'nullable',
    ];

    public function update()
    {
        $this->validate();

        $post = ModelsPost::where('slug', $this->slug)->first();

        $this->slug = $post->title !== $this->title
            ? Str::slug($this->title) . '-' . Str::random(4)
            : $post->slug;

        $this->user_id = Auth::id();

        if ($this->image && !is_array($this->image)) {
            if ($post->image && file_exists(public_path('storage/' . $post->image))) {
                unlink(public_path('storage/' . $post->image));
            }

            $post->image = $this->image->store('post-images', 'public');
        }

        sleep(1);

        $post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'excerpt' => Str::limit(strip_tags($this->description), 50, '...'),
            'published_at' => null,
            'status' => 'draft',
        ]);

        $post->categories()->sync($this->selected_category);
        $post->tags()->sync($this->selected_tag);

        toast('Postingan berhasil diperbarui!', 'success');

        return redirect()->to('/dashboard/postingan');
    }

    public function publish_update()
    {
        $this->validate();

        $post = ModelsPost::where('slug', $this->slug)->first();

        $this->slug = $post->title !== $this->title
            ? Str::slug($this->title) . '-' . Str::random(4)
            : $post->slug;

        $this->user_id = Auth::id();

        if ($this->image && !is_array($this->image)) {
            if ($post->image && file_exists(public_path('storage/' . $post->image))) {
                unlink(public_path('storage/' . $post->image));
            }

            $post->image = $this->image->store('post-images', 'public');
        }

        sleep(1);

        $post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'excerpt' => Str::limit(strip_tags($this->description), 50, '...'),
            'published_at' => now(),
            'status' => 'published',
        ]);

        $post->categories()->sync($this->selected_category);
        $post->tags()->sync($this->selected_tag);

        toast('Postingan berhasil diterbitkan!', 'success');

        return redirect()->to('/dashboard/postingan');
    }

    public function archive_post()
    {
        $this->validate();

        $post = ModelsPost::where('slug', $this->slug)->first();

        $this->user_id = Auth::id();

        if ($this->image && !is_array($this->image)) {
            if ($post->image && file_exists(public_path('storage/' . $post->image))) {
                unlink(public_path('storage/' . $post->image));
            }

            $post->image = $this->image->store('post-images', 'public');
        }

        sleep(1);

        $post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'excerpt' => Str::limit(strip_tags($this->description), 50, '...'),
            'published_at' => $this->published_at,
            'status' => 'archived',
        ]);

        $post->categories()->sync($this->selected_category);
        $post->tags()->sync($this->selected_tag);

        toast('Postingan berhasil diarsipkan!', 'success');

        return redirect()->to('/dashboard/postingan');
    }

    public function render()
    {
        return view('livewire.dashboard.posts.post-edit');
    }
}
