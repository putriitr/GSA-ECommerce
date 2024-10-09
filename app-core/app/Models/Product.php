<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 't_product';

    protected $fillable = ['nama', 'stok', 'category_id', 'slug', 'deskripsi'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
