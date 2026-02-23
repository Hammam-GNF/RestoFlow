<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'table_id',
        'opened_by',
        'closed_by',
        'status',
        'total_price',
        'opened_at',
        'closed_at',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
