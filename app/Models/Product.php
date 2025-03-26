<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name', 'slug', 'short_description', 'long_description', 'views', 'price', 'sale_price', 'quantity', 'quanlity', 'negotiable', 'tax', 'approved',
        'seo_title', 'seo_keyword', 'seo_description', 'is_featured', 'sku', 'prebooking', 'commisions', 'brand_id', 'super_store_status', 'status'
    ];

    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function ScopeActive($query)
    {
        return $query->where('status', true);
    }
}
