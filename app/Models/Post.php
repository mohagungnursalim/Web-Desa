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

     // Accessor untuk memformat deskripsi dengan embed YouTube
     public function getFormattedDescriptionAttribute()
     {
         // Gunakan regex untuk mendeteksi URL dalam tag <oembed>
         return preg_replace_callback(
             '/<oembed url="(.*?)"><\/oembed>/i',
             function ($matches) {
                 $url = $matches[1];
 
                 // Cek jika URL adalah YouTube
                 if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
                     // Ubah URL menjadi format embed YouTube
                     $youtubeId = preg_replace('/.*(?:\/|v=)([^&]+).*/', '$1', $url);
                     return '<iframe width="100%" height="380" src="https://www.youtube.com/embed/' . $youtubeId . '" frameborder="0" allowfullscreen></iframe>';
                 }
                 return $matches[0]; // Jika bukan YouTube, biarkan apa adanya
             },
             $this->description
         );
     }

     
}
