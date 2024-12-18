<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#FFF5E6;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar-custom {
            background-color: #f39c12;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }

        .navbar-custom .nav-link:hover {
            color: #333;
            text-decoration: none; 
        }

        .navbar-custom .form-control {
            border-radius: 25px;
            width: 500px; 
        }

        .navbar-custom .btn-outline-light {
            border-radius: 25px;
        }

        .icon-bar a {
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .icon-bar a:hover {
            background-color: #e08e0b;
            color: white;
            text-decoration: none; 
        }

        .content {
            margin-top: 60px;
            padding: 20px;
        }

        .content h1{
            color: #fd7c17 ;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
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
            border-bottom: 2px solid #ddd;
        }

        th {
            background-color: #FF8C00;
            opacity: 70%;
            color: white; 
            font: bold;
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

        .red-button {
            background-color: #ff4d4d;
        }

        .red-button:hover {
            background-color: #e60000;
        }

        .green-button {
            background-color: #4caf50;
        }

        .green-button:hover {
            background-color: #388e3c;
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
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('customer.index') }}">
                <img src="{{ asset('storage/images/logo.png') }}" alt="logo" width="50" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex mx-auto">
                    <form method="post" action="{{route('customer.search')}}" class="d-flex">
                        @csrf
                        <input class="form-control me-2" type="search" name="search query" placeholder="Search" aria-label="Search" required>
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
                <div class="d-flex icon-bar ms-auto">
                    <a href="{{route('customer.shopping_cart')}}" class="nav-link">Shopping Cart</a>
                    <a href="{{route('customer.order_page')}}" class="nav-link">Orders</a>
                    <a href="{{route('customer.customer_chat_list')}}" class="nav-link">Chat</a>
                    <a href="{{route('customer.show_profile')}}" class="nav-link">My Profile</a>
                    <a href="{{route('user.logout')}}" class="nav-link">Log Out</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="content">
        <h1>Order Page</h1>
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
                        <td><button class="red-button">Received</button></td>
                    @elseif($order->order_status == 'Shipped')
                        <td><button class="green-button" 
                            onclick="window.location.href='{{ route('customer.update_order_status', ['order_id' => $order->order_id]) }}'">Received</button></td>
                    @else
                        <td><button class="gray-button">Received</button></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>