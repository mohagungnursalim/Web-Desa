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

    public $title, $categories = [], $post_category = [], $tags = [], $post_tag = [], $slug, $description, $excerpt, $user_id, $image, $status, $published_at;
    public $selectedCategory = [], $selectedTag = [];
    public $existingImage; //image lama

    public function mount($slug)
    {
        $post = ModelsPost::where('slug', $slug)->first();
        if (!$post) {
            abort(404); // Bisa juga gunakan toast dan redirect seperti di controller jika diperlukan
        }

        $this->existingImage = $post->image;
        $this->title = $post->title;

        // Memastikan categories adalah koleksi Eloquent sebelum pluck
        if (is_array($post['categories'])) {
            // Jika categories berbentuk array, kita ambil id secara manual
            $this->selectedCategory = array_map(function($category) {
                return $category['id'];
            }, $post['categories']);
        } else {
            // Jika categories adalah koleksi Eloquent, kita bisa langsung menggunakan pluck
            $this->selectedCategory = $post->categories->pluck('id')->toArray();
        }

        // Memastikan tags adalah koleksi Eloquent sebelum pluck
        if (is_array($post['tags'])) {
            // Jika tags berbentuk array, kita ambil id secara manual
            $this->selectedTag = array_map(function($tag) {
                return $tag['id'];
            }, $post['tags']);
        } else {
            // Jika tags adalah koleksi Eloquent, kita bisa langsung menggunakan pluck
            $this->selectedTag = $post->tags->pluck('id')->toArray();
        }

        // Parsing data ke view edit
        $this->categories = PostCategory::select(['name', 'id'])->latest()->get();
        $this->tags = PostTag::select(['name', 'id'])->latest()->get();
        $this->description = $post->description;
        $this->published_at = $post->published_at;
    }

    // validation
    protected $rules = [
        'image' => 'required|image|max:5120',
        'title' => 'required|max:150',
        'selectedCategory' => 'required|array',
        'selectedTag' => 'required|array',
        'description' => 'required',
        'published_at' => 'nullable'
    ];

    public function update()
    {
        $this->validate();
        
        // Cari post berdasarkan slug
        $post = ModelsPost::where('slug', $this->slug)->first();

        // Buat slug berdasarkan title jika title berubah
        if ($post->title !== $this->title) {
            $this->slug = Str::slug($this->title) . '-' . Str::random(4);
        } else {
            $this->slug = $post->slug;
        }

        // Tetapkan user_id dari Auth
        $this->user_id = Auth::user()->id;

        // Periksa apakah ada gambar baru yang diunggah dan pastikan itu adalah file
        if ($this->image && !is_array($this->image)) {
            // Hapus gambar lama jika ada
            if ($post->image) {
                // Hapus file gambar lama jika ada
                if (file_exists(public_path('storage/' . $post->image))) {
                    unlink(public_path('storage/' . $post->image));
                }
            }
            // Store path gambar baru
            $imagePath = $this->image->store('post-images', 'public');
            $post->image = $imagePath; // Tetapkan gambar baru jika diunggah
        }

        sleep(1);

        // Update data post
        $post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'excerpt' => Str::limit(strip_tags($this->description), 50, '...'),
            'published_at' => null,
            'status' => 'draft' // Tetapkan sebagai draft saat disimpan
        ]);

        // Gunakan relasi untuk mengatur kategori & tag pada post
        $post->categories()->sync($this->selectedCategory);
        $post->tags()->sync($this->selectedTag);

        toast('Postingan berhasil diperbarui!', 'success');

        return redirect()->to('/dashboard/postingan');
    }

    public function publishUpdate()
    {
        $this->validate();
        
        // Cari post berdasarkan slug
        $post = ModelsPost::where('slug', $this->slug)->first();

        // Buat slug berdasarkan title jika title berubah
        if ($post->title !== $this->title) {
            $this->slug = Str::slug($this->title) . '-' . Str::random(4);
        } else {
            $this->slug = $post->slug;
        }

        // Tetapkan user_id dari Auth
        $this->user_id = Auth::user()->id;

        // Periksa apakah ada gambar baru yang diunggah dan pastikan itu adalah file
        if ($this->image && !is_array($this->image)) {
            // Hapus gambar lama jika ada
            if ($post->image) {
                // Hapus file gambar lama jika ada
                if (file_exists(public_path('storage/' . $post->image))) {
                    unlink(public_path('storage/' . $post->image));
                }
            }
            // Store path gambar baru
            $imagePath = $this->image->store('post-images', 'public');
            $post->image = $imagePath; // Tetapkan gambar baru jika diunggah
        }

        sleep(1);

        // Update data post dan tetapkan sebagai published
        $post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'excerpt' => Str::limit(strip_tags($this->description), 50, '...'),
            'published_at' => now(), // Set published_at ke waktu saat ini
            'status' => 'published' // Ubah status menjadi published
        ]);

        // Gunakan relasi untuk mengatur kategori & tag pada post
        $post->categories()->sync($this->selectedCategory);
        $post->tags()->sync($this->selectedTag);

        toast('Postingan berhasil diterbitkan!', 'success');

        return redirect()->to('/dashboard/postingan');
    }

    public function archivePost()
    {
        $this->validate();
        
        // Cari post berdasarkan slug
        $post = ModelsPost::where('slug', $this->slug)->first();
    
        // Tetapkan user_id dari Auth
        $this->user_id = Auth::user()->id;
    
        // Periksa apakah ada gambar baru yang diunggah dan pastikan itu adalah file
        if ($this->image && !is_array($this->image)) {
            // Hapus gambar lama jika ada
            if ($post->image) {
                // Hapus file gambar lama jika ada
                if (file_exists(public_path('storage/' . $post->image))) {
                    unlink(public_path('storage/' . $post->image));
                }
            }
            // Store path gambar baru
            $imagePath = $this->image->store('post-images', 'public');
            $post->image = $imagePath; // Tetapkan gambar baru jika diunggah
        }
    
        sleep(1);
    
        // Update data post dan tetapkan sebagai archived
        $post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'excerpt' => Str::limit(strip_tags($this->description), 50, '...'),
            'published_at' => $this->published_at, // Tampilkan tanggal publish sebelumnya
            'status' => 'archived' // Ubah status menjadi archived
        ]);
    
        // Gunakan relasi untuk mengatur kategori & tag pada post
        $post->categories()->sync($this->selectedCategory);
        $post->tags()->sync($this->selectedTag);
    
        toast('Postingan berhasil diarsipkan!', 'success');
    
        return redirect()->to('/dashboard/postingan');
    }
    

    // render component
    public function render()
    {
        return view('livewire.dashboard.posts.post-edit');
    }
}
