<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi many-to-many dengan Product_Category
    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'pivot_product_category')->withTimestamps();
    }
}
