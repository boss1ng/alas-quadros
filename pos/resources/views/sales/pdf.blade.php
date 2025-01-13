<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .total-sales {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Sales Report - {{ $filter === '-' ? 'All' : ucfirst($filter) }} Data</h1>
    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Menu</th>
                <th>Quantity</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->customer_name }}</td>
                <td>
                    @foreach(json_decode($order->orders) as $item)
                    {{ $menus->firstWhere('id', $item->menu_id)->name ?? 'Menu not found' }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach(json_decode($order->orders) as $item)
                    {{ $item->quantity }}<br>
                    @endforeach
                </td>
                <td>PHP {{ number_format($order->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total-sales">TOTAL SALES</td>
                <td colspan="2" class="total-sales">PHP {{ number_format($totalSales, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
