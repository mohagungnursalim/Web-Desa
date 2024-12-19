<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\Post as ModelsPost;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Str;


class FormPost extends Component
{
    use WithFileUploads;

    // Store
    public $title,$post_category = [], $post_tag = [],$slug,$description,$excerpt,$user_id,$image,$status,$published_at;

    public $tags = [], $categories = [];

    public function mount()
    {
        // Load initial categories
        $this->categories = PostCategory::select(['name','id'])->latest()->get();
        // Load initial tags
        $this->tags = PostTag::select(['name','id'])->latest()->get();
    }

    // validation
    protected $rules = [
        'image' => 'required|image|max:5120',
        'title' => 'required|max:150',
        'post_category' => 'required|array',
        'post_tag' => 'required|array',
        'description' => 'required',
        'published_at' => 'nullable'
];

    // Reset Form 
    public function resetForm()
    {
        $this->reset([
            'image',
            'title',
            'post_category',
            'description',
            'published_at'
        ]);
    }


    public function saveAsDraft()
    {
        // Validasi form
        $this->validate();

        // Buat slug berdasarkan title
        $this->slug = Str::slug($this->title) . '-' . Str::random(4);

        // Tetapkan user_id dari Auth
        $this->user_id = Auth::user()->id;

        // Store Path
        $imagePath = $this->image->store('post-images', 'public');

        sleep(1);
        // Buat instance Post dan simpan ke database sebagai Draft
        $post = ModelsPost::create([
            'image' => $imagePath,
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'excerpt' => Str::limit(strip_tags($this->description), 50, '...'),
            'status' => 'draft', // Set status sebagai draft
            'published_at' => null // Tidak ada tanggal publikasi
        ]);

        // Gunakan relasi untuk mengatur kategori & tag pada post yang baru dibuat
        $post->categories()->sync($this->post_category);
        $post->tags()->sync($this->post_tag);

        toast('Postingan berhasil disimpan sebagai Draft!','success');

        return redirect()->to('/dashboard/postingan');
    }

    public function publish()
    {
        // Validasi form
        $this->validate();

        // Buat slug berdasarkan title
        $this->slug = Str::slug($this->title) . '-' . Str::random(4);

        // Tetapkan user_id dari Auth
        $this->user_id = Auth::user()->id;

        // Store Path
        $imagePath = $this->image->store('post-images', 'public');

        sleep(1);
        // Buat instance Post dan simpan ke database sebagai Published
        $post = ModelsPost::create([
            'image' => $imagePath,
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'excerpt' => Str::limit(strip_tags($this->description), 50, '...'),
            'status' => 'published', // Set status sebagai published
            'published_at' => now() // Tanggal publikasi saat ini
        ]);

        // Gunakan relasi untuk mengatur kategori & tag pada post yang baru dibuat
        $post->categories()->sync($this->post_category);
        $post->tags()->sync($this->post_tag);

        toast('Postingan berhasil dipublikasikan!','success');

        return redirect()->to('/dashboard/postingan');
    }


    // render component
    public function render()
    {
        return view('livewire.dashboard.posts.form-post');
    }

}