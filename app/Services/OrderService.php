<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Table;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function openOrder(int $tableId, int $userId)
    {
        return DB::transaction(function () use ($tableId, $userId) {

            $table = Table::lockForUpdate()->findOrFail($tableId);

            if ($table->status !== 'available') {
                abort(400, 'Table is not available');
            }

            $order = Order::create([
                'table_id' => $table->id,
                'opened_by' => $userId,
                'status' => 'open',
                'opened_at' => now(),
                'total_price' => 0,
            ]);

            $table->update([
                'status' => 'occupied'
            ]);

            return $order;
        });
    }

    public function closeOrder(int $orderId, int $userId)
    {
        return DB::transaction(function () use ($orderId, $userId) {

            $order = Order::lockForUpdate()
                ->with('table')
                ->findOrFail($orderId);

            if ($order->status !== 'open') {
                abort(400, 'Order already closed');
            }

            $order->update([
                'status' => 'closed',
                'closed_by' => $userId,
                'closed_at' => now(),
            ]);

            $order->table->update([
                'status' => 'available'
            ]);

            return $order;
        });
    }
}