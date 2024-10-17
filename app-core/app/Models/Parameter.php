<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;
    protected $table = 't_parameter';

    protected $fillable = [
        'logo',
        'logo_tambahan',
        'nomor_wa',
        'email',
        'slogan_welcome',
        'alamat',
        'nama_ecommerce',
        'email_pengaduan_kementrian',
        'website_kementerian',
    ];
}
