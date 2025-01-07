<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopify_id',
        'title',
        'description',
        'handle',
        'status',
        'max_variant_compare',
        'min_variant_compare',
        'collection_id'
    ];
    //all the collections that the product belongs to
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_product', 'product_id', 'collection_id');
    }
    public $timestamps = false;
}
