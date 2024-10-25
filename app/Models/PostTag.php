<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $table = 'tags';

    // Relasi many-to-many dengan Postingan
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'pivot_post_tag');
    }

}
