<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddOrderItemRequest;
use App\Http\Requests\OpenOrderRequest;
use App\Services\OrderItemService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(OpenOrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->openOrder(
            $request->table_id,
            $request->user()->id
        );

        return response()->json([
            'message' => 'Order opened successfully',
            'order_id' => $order->id
        ], 201);
    }

    public function addItem($orderId, AddOrderItemRequest $request, OrderItemService $service)
    {
        $order = $service->addItem(
            $orderId,
            $request->food_id,
            $request->quantity
        );

        return response()->json([
            'message' => 'Item added successfully',
            'total_price' => $order->total_price
        ], 200);
    }
}
