<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 't_product';

    protected $fillable = ['name', 'stock', 'category_id', 'slug', 'description','specification', 'price', 'discount_price','is_pre_order', 'is_negotiable','status_published'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function videos()
    {
        return $this->hasMany(ProductVideos::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'id')
                    ->where('status', 'delivered');
    }

    public function bigSales()
    {
        return $this->belongsToMany(BigSale::class, 't_bigsales_product', 'product_id', 'bigsale_id');
    }




}
