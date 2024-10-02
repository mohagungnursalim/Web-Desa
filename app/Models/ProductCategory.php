<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'product_categories';

    // Relasi many-to-many dengan Product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'pivot_product_category');
    }
}
