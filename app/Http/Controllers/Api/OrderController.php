<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddOrderItemRequest;
use App\Http\Requests\CloseOrderRequest;
use App\Http\Requests\OpenOrderRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderItemService;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['table', 'orderItems']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        $order = Order::with([
            'table',
            'orderItems.food'
        ])->findOrFail($id);

        return new OrderResource($order);
    }

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

        $order->load(['orderItems.food', 'table']);

        return new OrderResource($order);
    }

    public function updateItem($orderId, $itemId, UpdateOrderItemRequest $request, OrderItemService $service)
    {
        $order = $service->updateItem(
            $orderId,
            $itemId,
            $request->quantity
        );

        $order->load(['orderItems.food', 'table']);

        return new OrderResource($order);
    }

    public function deleteItem($orderId, $itemId, OrderItemService $service)
    {
        $order = $service->deleteItem($orderId, $itemId);

        $order->load(['orderItems.food', 'table']);

        return new OrderResource($order);
    }

    public function close($orderId, CloseOrderRequest $request, OrderService $service)
    {
        $order = $service->closeOrder(
            $orderId,
            $request->user()->id
        );

        $order->load(['orderItems.food', 'table']);

        return new OrderResource($order);
    }

    public function receipt($id)
    {
        $order = Order::with([
            'table',
            'orderItems.food'
        ])->findOrFail($id);

        if ($order->status !== 'closed') {
            abort(400, 'Order must be closed before generating receipt');
        }
        
        $pdf = Pdf::loadView('receipt', compact('order'));

        return $pdf->download("receipt-order-{$order->id}.pdf");
    }
}
