<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Seller Manage Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFF5E6;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #FF8C00;
            color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar img {
            height: 40px;
        }

        .navbar .title {
            margin: 0;
            font-size: 24px;
            color: #fff;
        }

        .main-content {
            margin-top: 80px; 
            padding: 20px;
        }

        h1 {
            color: #fd7c17 ;
            text-align: center;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius:5px;
            border: 3px solid #FF8C00;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #FF8C00;
            opacity: 70%;
            color: white; 
            font:bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button {
            border: none;
            padding: 10px 15px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .orange-button {
            background-color: #ff6600;
        }

        .orange-button:hover {
            background-color: #e65c00;
        }

        .gray-button {
            background-color: #888;
        }

        .gray-button:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
    
    <div class="navbar">
        <a href="{{route('seller.index')}}">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo">
        </a>
    </div>
    <div class="main-content">
        <h1>Seller Manage Order</h1>
        <table>
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Variation</th>
                <th>Quantity</th>
                <th>Paid (RM)</th>
                <th>Order Date</th>
                <th>Order Status</th>
                <th>Received</th>
            </tr>
            @foreach ($orders as $index => $order)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$order->product_name}}</td>
                    <td>{{$order->variation_name}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>{{$order->total_price}}</td>
                    <td>{{$order->date}}</td>
                    <td>{{$order->order_status}}</td>
                    @if($order->order_status == 'Preparing')
                        <td>
                            <button class="orange-button" 
                                onclick="window.location.href='{{ route('seller.update_shipped_order_status', ['order_id' => $order->order_id]) }}'">
                                Shipped
                            </button>
                        </td>
                    @else
                        <td><button class="gray-button">Shipped</button></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>