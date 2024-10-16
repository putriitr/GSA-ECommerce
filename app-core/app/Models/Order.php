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
        'approved_at',
        'payment_verified_at',
        'packing_at',
        'shipped_at',
        'completed_at',
        'cancelled_at',
        'cancelled_by_system_at',
        'is_viewed',    
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'approved_at' => 'datetime',
        'payment_verified_at' => 'datetime',
        'packing_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'cancelled_by_system_at' => 'datetime',
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

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, OrderItem::class, 'order_id', 'product_id', 'id', 'product_id');
    }
}
