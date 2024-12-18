<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-commerce Homepage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f8f8;
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

        .promo-section {
            background-color: #f39c12;
            padding: 20px 0;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .promo-carousel {
            border-radius: 50px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .carousel-item img {
            height: 300px;
            object-fit: cover;
            width: 100%;
            border-radius: 50px; 
        }

        .category-boxes {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 20px 0;
            margin-bottom: 20px;
        }

        .category-box {
            background-color: #fff;
            width: 60px;
            height: 60px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease-in-out;
            text-align: center;
        }

        .category-box:hover {
            transform: scale(1.05);
        }

        .category-box img {
            max-width: 50%;
            max-height: 50%;
        }

        .category-name {
            margin-top: 5px;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            text-align: center;
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

        .row {
            display: flex;
            
            gap: 0px; 
        }

        h1, h2 {
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

  
    <div class="promo-section">
        <div class="container">
           
            <div id="promoCarousel" class="carousel slide promo-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/images/carousel1.jpeg') }}" class="d-block w-100" alt="Promotion 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/images/carousel2.png') }}" class="d-block w-100" alt="Promotion 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/images/carousel3.png') }}" class="d-block w-100" alt="Promotion 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
            </div>

   
            <div class="category-boxes">
             
                @foreach ($categories as $category)
                    <a href="{{route('customer.category_page', ['category_id' => $category->category_id])}}">
                        <div class="text-center">
                            <div class="category-box">
                                <img src="{{ asset('storage/images/category_icon.png') }}" alt="{{$category->category_name}}">
                            </div>
                            <p class="category-name">{{$category->category_name}}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

  
    <div class="container">

        <h2>Top Seller</h2>
        <div class="row">
            @foreach ($top_seller_products as $product)
                <div class="col-md-3">
                    <a href="{{route('customer.view_product', ['product_id' => $product->product_id])}}">
                        <div class="product-item">
                            <img src="{{$product->image_url}}" alt="{{$product->product_name}}">
                            <p>{{$product->product_name}}</p>
                            <p class="price"> {{$product->price}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <h2>For You</h2>
        <div class="row">
            @foreach ($recommended_products as $product)
                <div class="col-md-3">
                    <a href="{{route('customer.view_product', ['product_id' => $product->product_id])}}">
                        <div class="product-item">
                            <img src="{{$product->image_url}}" alt="{{$product->product_name}}">
                            <p>{{$product->product_name}}</p>
                            <p class="price"> {{$product->price}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <h2>Recently Viewed</h2>
        <div class="row">
            @foreach ($recently_view_products as $product)
                <div class="col-md-3">
                    <a href="{{route('customer.view_product', ['product_id' => $product->product_id])}}">
                        <div class="product-item">
                            <img src="{{$product->image_url}}" alt="{{$product->product_name}}">
                            <p>{{$product->product_name}}</p>
                            <p class="price"> {{$product->price}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
