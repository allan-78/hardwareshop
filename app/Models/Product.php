<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'brand_id',
        'image'
    ];

    // Add images relationship
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'brand_name' => $this->brand ? $this->brand->name : '',
            'category_name' => $this->category ? $this->category->name : '',
        ];
    }

    public function scopeFilterByPrice($query, $minPrice, $maxPrice)
    {
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    public function scopeFilterByCategory($query, $categories)
    {
        if ($categories) {
            $query->whereIn('category_id', (array)$categories);
        }
        return $query;
    }

    public function scopeFilterByBrand($query, $brands)
    {
        if ($brands) {
            $query->whereIn('brand_id', (array)$brands);
        }
        return $query;
    }
}