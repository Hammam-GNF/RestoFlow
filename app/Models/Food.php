<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $fillable = [
        'name',
        'price',
        'category',
        'is_available',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
