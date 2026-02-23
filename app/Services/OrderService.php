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
}