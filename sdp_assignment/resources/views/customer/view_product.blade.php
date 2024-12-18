<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E6;
            margin: 0;
            padding-top: 100px; 
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .background-image {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            flex-grow: 1;
            padding-bottom: 56px; 
        }

        .content-wrapper {
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; 
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

        .rating {
            display: flex;
            flex-direction: row;
            align-items: center;
            direction: rtl;
        }

        .rating input {
            display: none;
        }

        .rating label {
            color: #dcdcdc;
            font-size: 2rem;
            cursor: pointer;
        }

        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #ffc107;
        }

        .rating_star {
            font-size: 2rem;
        }

        .rating_star .filled-star {
            color: #ffc107; 
        }

        .rating_star .empty-star {
            color: #dcdcdc; 
        }

        .footer-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            padding: 10px;
            border-top: 1px solid #e7e7e7;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1050;
        }

        .footer-bar button {
            flex-grow: 1;
            margin: 0 5px;
            font-weight: bold;
        }

        .footer-bar .btn-primary {
            background-color: #f39c12;
            border-color: #f39c12;
        }

        .footer-bar .btn-primary a {
            color: white;
            text-decoration: none;
        }

        .footer-bar .btn-success {
            background-color: #f39c12;
            border-color: #f39c12;
        }

        .footer-bar .btn-success a {
            color: white;
            text-decoration: none;
        }

        .price {
            font-weight: bold;
            color: #f39c12; 
        }

        .product-item {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            background-color: #fff;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            color: black; 
        }

        .product-item a {
            text-decoration: none; 
            color: black; 
        }

        .product-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-item img {
            border-radius: 10px;
            max-width: 100%;
            height: auto;
        }

        .product-item p {
            margin: 0;
        }

        .product-attributes h5 {
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 1rem;
        }

        .attribute-options {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .attribute-label {
            display: inline-block;
            padding: 10px 20px;
            border: 1px solid #f39c12;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            font-weight: bold;
            color: #f39c12;
        }

        input[type="radio"] {
            display: none;
        }

        .attribute-label:hover,
        input[type="radio"]:checked + .attribute-label {
            background-color: #f39c12;
            color: #fff;
        }

        .quantity-selection {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .quantity-selection input {
            width: 60px;
            text-align: center;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .quantity-selection button {
            border: 1px solid #ccc;
            padding: 5px 10px;
            background-color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .quantity-selection button:hover {
            background-color: #f39c12;
            color: #fff;
        }

        .btn-primary {
            background-color: #f39c12;
            border-color: #f39c12;
        }

        .btn-primary:hover {
            background-color: #e08e0b;
            border-color: #e08e0b;
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

    <div class="background-image">
        <div class="content-wrapper">

            <div class="container my-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row">
              
                    <div class="col-md-4">
                        <div class="product-image-wrapper" data-bs-toggle="modal" data-bs-target="#imageModal">
                            <img src="{{$product->image_url}}" alt="Product Image" class="img-fluid rounded-3">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h3>{{$product->product_name}}</h3>
                        <p>{{$product->product_description}}</p>
                        <h4 class="price">
                            @if(session('variation'))
                                @php
                                    $variation = session('variation');
                                @endphp
                                <p>RM{{ $variation->price }}</p>
                                <p>Stock: {{ $variation->stock }}</p>
                            @else
                                <p>{{$product->price}}</p>
                                <p>Stock: {{ $product->stock }}</p>
                            @endif
                        </h4>
                        
                    
                        <form method="post" action="{{route('customer.get_variation_details', ['product_id' => $product->product_id])}}">
                            @csrf
                            <div class="product-attributes">
                                @foreach ($attribute_names as $index => $name)
                                    <h5>{{ $name }}</h5>
                                    <div class="attribute-options">
                                        @foreach ($attribute_values_list[$index] as $value)
                                            <input type="radio" id="attribute_{{ $index + 1 }}{{ $value->attribute_value_id }}" 
                                                name="attribute_{{ $index + 1 }}" 
                                                value="{{ $value->attribute_value_id }}" 
                                                {{ old('attribute_' . ($index + 1)) == $value->attribute_value_id ? 'checked' : '' }}>
                                            <label for="attribute_{{ $index + 1 }}{{ $value->attribute_value_id }}" class="attribute-label">{{ $value->attribute_value }}</label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            


                            
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                        <br>
                        <form method="post" action="{{route('customer.add_to_cart')}}">
                        <div class="quantity-selection">
                            <form method="post" action="{{route('customer.add_to_cart')}}" style="flex-grow: 1; margin-right: 5px;">
                            <h5>Quantity</h5>
                            <button type="button" class="btn btn-light" onclick="this.nextElementSibling.stepDown()">-</button>
                            <input type="number" name="quantity" min="1" max="{{ session('variation') ? $variation->stock : $product->stock}}" required>
                            <button type="button" class="btn btn-light" onclick="this.previousElementSibling.stepUp()">+</button>
                            @if(session('success'))
                            @if(session('variation'))
                                @php
                                    $variation = session('variation');
                                @endphp
                                @csrf
                                <input type="text" name="variation_id" value="{{ $variation->variation_id }}" hidden>
                                <br>
                            @endif
                         @endif
                                <input type="submit" value="Add to Cart" class="btn btn-primary" style="width: 100%; font-weight: bold;">
                            </form>
                        </div>
                      
                        </form>
                    </div>
                </div>

                
    
                @if(!$record_exist)
                <div class="container mt-5">
                    <h1>Rate Our Service</h1>
                    <form action="{{route('customer.add_review')}}" method="post">
                        @csrf
                        <div class="rating">
                            <input type="radio" id="star5" name="rating_star" value="5">
                            <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="rating_star" value="4">
                            <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="rating_star" value="3">
                            <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="rating_star" value="2">
                            <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1" name="rating_star" value="1" required>
                            <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                        </div>
                        <input type="text" name="review_text" class="form-control mt-2">
                        <input type="hidden" name="product_id" value="{{$product->product_id}}">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
                @endif

                <h2>Review</h2>
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div>
                            <p>{{$review->customer_name}}</p>
                            <div class="rating_star">
                                @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating_star ? 'filled-star' : 'empty-star' }}"></i>
                                @endfor
                            </div>
                            <p>{{$review->review_text}}</p>
                        </div>
                    @endforeach
                @else
                    <p>No reviews yet.</p>
                @endif
            </div>

          
            <div class="footer-bar">
    
                <button class="btn btn-success">
                    <a href="{{route('customer.chat_with_seller', ['seller_id' => $seller->seller_id])}}" class="text-white">Chat with Seller</a>
                </button>
            </div>

         
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                </div>
            </div>

            <h2>Shop Recommendation</h2>
            <div class="row">
                @foreach($shop_recommendations as $recommendation)
                <div class="col-md-3">
                    <a href="{{route('customer.view_product', ['product_id' => $recommendation->product_id])}}">
                        <div class="product-item">
                            <img src="{{$recommendation->image_url}}" alt="{{$recommendation->product_name}}">
                            <p>{{$recommendation->product_name}}</p>
                            <p><strong>Price:</strong> RM {{$recommendation->price}}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">

    document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
     
            console.log(User selected: ${this.name} with value ${this.value});
        });
    });
</script>
</body>

</html>