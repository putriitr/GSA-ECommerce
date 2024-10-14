<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 't_orders';


    protected $fillable = [
        'user_id',
        'total',
        'status',
        'is_negotiated',
        'tracking_number',
        'shipping_service_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function negotiation()
    {
        return $this->hasOne(Negotiation::class);
    }

    public function shippingService()
    {
        return $this->belongsTo(ShippingService::class, 'shipping_service_id');
    }
}
