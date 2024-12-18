<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Check Out Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E6; 
            color: #333;
        }

        h1 {
            color: #FF5722; 
        }

        .cart-item {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #FF5722; 
        }

        .cart-item img {
            border-radius: 10px;
            width: 250px; 
            height: 250px;
            object-fit: cover;
        }

        .cart-item .details {
            padding-left: 20px;
            flex: 1;
        }

        .cart-item .details h3 {
            color: #111111;
        }

        .cart-item .details p {
            color: #FF5722; 
        }

        .alert {
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .total-price {
            font-size: 1.5rem;
            color: #101010;
            margin-top: 20px;
            text-align: right;
        }

        .total-price span {
            color: #FF5722; 
        }

        .voucher-section {
            margin-top: 20px;
            border: 2px solid #343a40; 
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 30px; 
        }

        .voucher-section h4 {
            color: #FF5722; 
        }

        .voucher-section p {
            color: #200606;
            font-weight: bold;
        }

        .voucher-section input[type="radio"] {
            margin-right: 10px;
        }

        .checkout-form {
            margin-top: 20px;
            text-align: right;
        }

        .checkout-form input[type="submit"] {
            background-color: #FF5722; 
            color: #f9f8f3;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s, transform 0.2s;
        }

        .checkout-form input[type="submit"]:hover {
            background-color: #e64a19;
            transform: scale(1.05);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-wrapper {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-wrapper">
            <h1 class="text-center">Check Out Page</h1>
            @foreach($carts as $cart)
                <div class="cart-item d-flex align-items-start">
                    <img src="{{$cart->image_url}}" alt="Product Image">
                    <div class="details">
                        <h3>{{$cart->product_name}}</h3>
                        <p>Variation: {{$cart->variation_name}}</p>
                        <p>Quantity: {{$cart->quantity}}</p>
                        <p>RM{{ number_format($cart->price, 2) }} each</p>

                        @if(session('success') && $cart->default_price != $cart->price)
                            <div class="alert alert-success">
                                <p>Voucher applied successfully</p>
                            </div>
                        @endif

                        @if(session('success') && $cart->default_price == $cart->price && $cart->voucher->isNotEmpty())
                            <div class="alert alert-error">
                                <p>Voucher is not applied.</p>
                            </div>
                        @endif

                        <form method="post" action="{{route('customer.voucher_application')}}">
                            @csrf
                            @foreach($carts as $cartt)
                                <input type="hidden" name="all_cart_ids[]" value="{{ $cartt->cart_id }}">
                                <input type="hidden" name="all_prices[]" value="{{ $cartt->price}}">
                            @endforeach

                            @if ($cart->voucher->isNotEmpty())
                                <div class="voucher-section">
                                    @foreach ($cart->voucher as $voucher)
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="voucher_id" value="{{$voucher->voucher_id}}">
                                            <label class="form-check-label">
                                                <h4>{{$voucher->voucher_description}}</h4>
                                                <p>{{$voucher->start_date}} until {{$voucher->end_date}}</p>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>No vouchers available for this cart.</p>
                            @endif

                            <input type="text" name="cart_id" value="{{$cart->cart_id}}" hidden>
                            <input type="submit" value="Select" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="total-price">
                Total Price: <span>RM{{number_format(session('total_price'), 2)}}</span>
            </div>

            <div class="checkout-form">
                <form method="post" action="{{route('customer.check_out')}}">
                    @csrf
                    @foreach($carts as $cartt)
                        <input type="hidden" name="all_cart_ids[]" value="{{ $cartt->cart_id }}">
                        <input type="hidden" name="all_prices[]" value="{{ $cartt->price}}">
                    @endforeach
                    <input type="submit" value="Check Out">
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


