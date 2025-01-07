<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'collection_shopify_id',
        'title',
        'description',
        'handle',
    ];
    public function products()
    {
        // return $this->hasMany(Product::class, 'collection_shopify_id', 'shopify_id');
        // return $this->hasMany(Product::class, 'collection_id');//last one 3/1/2024
        return $this->belongsToMany(Product::class, 'collection_product', 'collection_id', 'product_id');
    }
    public $timestamps = false;
}
