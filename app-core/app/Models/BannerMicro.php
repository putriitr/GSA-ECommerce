<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerMicro extends Model
{
    use HasFactory;
    protected $table = 't_banner_micro';

    protected $fillable = ['image', 'link', 'active', 'page'];

}
