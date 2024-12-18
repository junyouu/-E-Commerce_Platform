<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E6;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }
        .navbar-custom {
            background-color: #f39c12;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030; 
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }
        .navbar-custom .nav-link:hover {
            color: #333;
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
        }
        .cart-container {
            max-width: 900px;
            margin: 80px auto 20px auto; 
            padding: 20px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .cart-header {
            display: flex;
            align-items: center;
            padding: 10px 0;
        }

        .cart-header img {
            max-width: 50px;
            margin-right: 10px;
        }

        .cart-header h1 {
            font-size: 28px;
            color: #FFA500;
            margin: 0;
            flex-grow: 1;
        }

        .cart-header h4 {
            font-size: 18px;
            color: #333;
            margin-left: auto;
            margin-right: 10px;
        }

        .cart-items {
            margin-top: 10px;
        }

        .cart-item {
            position: relative;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            background-color: white;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 40px 15px 15px 15px; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .cart-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 30px;
            background-color: #FFA500;
            border-radius: 10px 10px 0 0;
            z-index: 1;
        }

        .cart-item-checkbox {
            position: absolute;
            top: 5px;
            left: 5px;
            z-index: 2;
        }

        .cart-item-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #FFA500;
            border-radius: 5px;
            cursor: pointer;
        }

        .cart-item-image {
            max-width: 120px;
            max-height: 120px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 15px;
            z-index: 3; 
        }

        .cart-item-details {
            flex-grow: 1;
            z-index: 3; 
        }

        .cart-item-details h5 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .cart-item-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .cart-item-price {
            font-size: 18px;
            color: #FFA500;
            font-weight: bold;
            text-align: right;
            z-index: 3; 
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            margin-left: 10px;
            z-index: 3; 
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .quantity-selector input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 0;
        }

        .remove-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 3; 
        }

        .remove-btn:hover {
            background-color: #c0392b;
        }

        .checkout-btn {
            background-color: #FFA500;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            display: block;
            margin-left: auto;
            margin-right: 0;
            transition: background-color 0.3s ease;
        }

        .checkout-btn:hover {
            background-color: #e08e0b;
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
                    <a href="{{route('customer.customer_chat_list')}}" class="nav-link">Chat</a>
                    <a href="{{route('customer.show_profile')}}" class="nav-link">My Profile</a>
               
                </div>
            </div>
        </div>
    </nav>

    
    <form method="post" action="{{route('customer.check_out_page')}}" id="checkoutForm">
        @csrf
        <div class="cart-container">
            <h1>Shopping Cart</h1>
            <h4>All Item</h4>

            <div class="cart-items">
                @foreach($carts as $cart)
                    <div class="cart-item">
                        <div class="cart-item-checkbox">
                            <input type="checkbox" name="cart_ids[]" value="{{$cart->cart_id}}">
                        </div>
                        <img src="{{$cart->image_url}}" alt="{{$cart->product_name}}" class="cart-item-image">
                        <div class="cart-item-details">
                            <h5>{{$cart->product_name}}</h5>
                            <p>{{$cart->variation_name}}</p>
                            <p>{{$cart->size}}</p>
                        </div>
                        <div class="cart-item-price">RM {{$cart->price}}</div>
                        <div class="cart-item-controls">
                            <div class="quantity-selector">
                                <input type="text" name="quantity[{{$cart->cart_id}}]" value="{{$cart->quantity}}">
                            </div>
                        </div>
                        <a href="{{route('customer.remove_from_cart', ['cart_id' => $cart->cart_id])}}" class="remove-btn">Remove</a>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="checkout-btn">Check Out</button>
        </div>
    </form>

  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(event) {
            const checkboxes = document.querySelectorAll('input[name="cart_ids[]"]');
            let checked = false;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checked = true;
                }
            });

            if (!checked) {
                event.preventDefault(); 
                alert('Please select at least one item to check out.');
            }
        });
    </script>
</body>
</html>