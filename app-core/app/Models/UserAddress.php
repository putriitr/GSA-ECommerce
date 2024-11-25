<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = 't_u_addresses';

    protected $fillable = [
        'user_id',
        'label_alamat',
        'nama_penerima',
        'nomor_telepon',
        'provinsi',
        'kota_kabupaten',
        'kodepos',
        'kecamatan',
        'detail_alamat',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
