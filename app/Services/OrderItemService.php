<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Food;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderItemService
{
    public function addItem(int $orderId, int $foodId, int $quantity)
    {
        return DB::transaction(function () use ($orderId, $foodId, $quantity) {

            $order = Order::lockForUpdate()->findOrFail($orderId);

            if ($order->status !== 'open') {
                abort(400, 'Order is not open');
            }

            $food = Food::findOrFail($foodId);

            $subtotal = $food->price * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $food->id,
                'quantity' => $quantity,
                'price' => $food->price,
                'subtotal' => $subtotal,
            ]);

            $order->total_price += $subtotal;
            $order->save();

            return $order;
        });
    }

    public function updateItem(int $orderId, int $itemId, int $quantity)
    {
        return DB::transaction(function () use ($orderId, $itemId, $quantity) {

            $order = Order::lockForUpdate()
                ->with('orderItems')
                ->findOrFail($orderId);

            if ($order->status !== 'open') {
                abort(400, 'Order is not open');
            }

            $item = $order->orderItems()
                ->where('id', $itemId)
                ->firstOrFail();

            $item->quantity = $quantity;
            $item->subtotal = $item->price * $quantity;
            $item->save();

            $order->total_price = $order->orderItems()->sum('subtotal');
            $order->save();

            return $order;
        });
    }

    public function deleteItem(int $orderId, int $itemId)
    {
        return DB::transaction(function () use ($orderId, $itemId) {

            $order = Order::lockForUpdate()
                ->with('orderItems')
                ->findOrFail($orderId);

            if ($order->status !== 'open') {
                abort(400, 'Order is not open');
            }

            $item = $order->orderItems()
                ->where('id', $itemId)
                ->firstOrFail();

            $item->delete();

            $order->total_price = $order->orderItems()->sum('subtotal');
            $order->save();

            return $order;
        });
    }
}