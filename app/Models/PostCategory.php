<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'categories';
    
    // Relasi many-to-many dengan Postingan
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'pivot_post_category');
    }
}
