<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerHome extends Model
{
    use HasFactory;

    protected $table = 't_banner_home';

    protected $fillable = ['image', 'title', 'description', 'link', 'order', 'active'];

}
