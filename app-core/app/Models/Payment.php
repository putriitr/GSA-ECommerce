<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 't_ord_payments';


    protected $fillable = [
        'order_id',
        'status',
        'payment_proof',
        'is_viewed',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
