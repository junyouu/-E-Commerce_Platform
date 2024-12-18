<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E6;
            font-family: 'Helvetica Neue', Arial, sans-serif;
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

        .product-item {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            background-color: #fff;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            height: 100%; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-item img {
            border-radius: 10px;
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .product-item p {
            margin: 0;
            font-size: 14px;
            text-align: center;
            flex-grow: 1; 
        }

        .product-item p.price {
            font-weight: bold;
            color: #f39c12;
            margin-top: 10px;
            font-size: 16px;
        }

        .product-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .content-wrapper {
            background-color: #fff;
            border-radius: 15px 15px 0 0; 
            padding: 20px;
            margin: 20px auto;
            max-width: 1200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-height: calc(100vh - 80px); 
        }
        .row {
            display: flex;
            
            gap: 15px; 
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none; 
            color: inherit;
        }

        a:hover {
            color: inherit;
            text-decoration: none; 
        }

        .no-results {
            text-align: center;
            color: red;
            font-weight: bold;
            font-size: 1.5rem;
        }

        h2 {
            color: #FF5722; 
            margin-bottom: 20px;
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

    <div class="container">
        <div class="content-wrapper">
            <br>
            <h2>Search Result</h2>
            <div class="row">
                @foreach ($results as $result)
                    <div class="col-md-3">
                        <a href="{{route('customer.view_product', ['product_id' => $result->product_id])}}">
                            <div class="product-item">
                                <img src="{{$result->image_url}}" alt="{{$result->product_name}}">
                                <div class="card-body">
                                    <p>{{$result->product_name}}</p>
                                    <p class="price">{{$result->price}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                @if($results->count() == 0)
                    <p class="card-text">No relevant result found.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>