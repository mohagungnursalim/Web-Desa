<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'posts';

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori Postingan
    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'pivot_post_category', 'post_id', 'category_id')->withTimestamps();
    }

    // Relasi ke Tag Postingan
    public function tags()
    {
        return $this->belongsToMany(PostTag::class, 'pivot_post_tag', 'post_id', 'tag_id')->withTimestamps();
    }
}
