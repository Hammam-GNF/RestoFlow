<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border-bottom: 1px solid #ddd; padding: 6px; text-align: left; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

<h2>Restaurant Receipt</h2>

<p>
    Order ID: {{ $order->id }} <br>
    Table: {{ $order->table->number }} <br>
    Opened At: {{ $order->opened_at }} <br>
    Closed At: {{ $order->closed_at }}
</p>

<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
            <th class="text-right">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems as $item)
        <tr>
            <td>{{ $item->food->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp.{{ number_format($item->price, 0) }}</td>
            <td class="text-right">{{ number_format($item->subtotal, 0) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 class="text-right">
    Total: Rp.{{ number_format($order->total_price, 0) }}
</h3>

</body>
</html>