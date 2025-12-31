<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'passenger_title',
        'passenger_first_name',
        'passenger_last_name',
        'passenger_email',
        'passenger_phone',
        'passenger_country',
        'passenger_address',
        'passenger_special_request',
        'payment_method',
        'payment_status',
        'subtotal',
        'discount',
        'vat',
        'service_tax',
        'tabby_fee',
        'total',
        'applied_coupons',
        'status',
        'reservation_reference',
        'reservation_data',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'vat' => 'decimal:2',
        'service_tax' => 'decimal:2',
        'tabby_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'applied_coupons' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        return 'AND-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
    }
}
