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
    public function collection()
    {
        // return $this->belongsTo(Collection::class, 'collection_shopify_id', 'shopify_id'); // 'collection_shopify_id' is the foreign key, 'shopify_id' is the primary key.
        // return $this->belongsTo(Collection::class, 'collection_id'); //last one
        return $this->belongsToMany(Collection::class, 'collection_product', 'product_id', 'collection_id');
    }
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_product', 'product_id', 'collection_id');
    }
    public $timestamps = false;
}
