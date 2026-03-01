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
                'status' => 'draft',
                'opened_at' => now(),
                'total_price' => 0,
            ]);

            return $order;
        });
    }

    public function submitOrder(int $orderId)
    {
        return DB::transaction(function () use ($orderId) {

            $order = Order::lockForUpdate()
                ->with('table', 'orderItems')
                ->findOrFail($orderId);

            if ($order->status !== 'draft') {
                abort(400, 'Order cannot be submitted');
            }

            if ($order->orderItems()->count() === 0) {
                abort(400, 'Cannot submit empty order');
            }

            if ($order->table->status !== 'available') {
                abort(400, 'Table is not available');
            }

            $order->update([
                'status' => 'submitted'
            ]);

            $order->table->update([
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

            if ($order->status !== 'submitted') {
                abort(400, 'Only submitted orders can be closed');
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