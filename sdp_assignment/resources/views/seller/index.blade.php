<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Seller Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E6;
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

        .card {
            background-color: #FFFFFF;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,.15);
        }
        .card-title {
            color: #FF8C00;
            font-weight: bold;
        }
        .card-text {
            color: #333333; 
        }
        .btn-primary {
            background-color: #FF8C00;
            border-color: #FF8C00;
            color: #FFFFFF;
        }
        .btn-primary:hover {
            background-color: #E67300;
            border-color: #E67300;
        }
        .profile-card img {
            border: 4px solid #FF8C00;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 0 auto;
            display: block;
            margin-top: 20px;
        }
        .action-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #FF8C00;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .centered-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .action-cards {
            width: 100%;
        }
        .bg-custom-color {
            background-color: #FF8C00;
        }
        .list-group-item {
            background-color: #FFF5E6;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #FF8C00;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('seller.index') }}">
                <img src="{{ asset('storage/images/logo.png') }}" alt="logo" width="50" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="d-flex icon-bar ms-auto">
                    <a href="{{route('user.logout')}}" class="nav-link">Log Out</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="centered-content">
            <div class="profile-card mb-4">
                <div class="card">
                    <img src="{{$seller->image_url}}" class="card-img-top" alt="Seller Profile Pic">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{$seller->shop_name}}</h5>
                        <p class="card-text">{{$seller->shop_description}}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="fas fa-envelope me-2"></i>{{$seller->email}}</li>
                        <li class="list-group-item"><i class="fas fa-phone me-2"></i>{{$seller->phone_number}}</li>
                    </ul>
                </div>
            </div>
            <div class="action-cards">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-upload action-icon"></i>
                                <h5 class="card-title">Upload Product</h5>
                                <p class="card-text">Add new products to your inventory.</p>
                                <a href="{{route('seller.show_upload_product_form')}}" class="btn btn-primary">Go to Upload</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-ticket-alt action-icon"></i>
                                <h5 class="card-title">Create Voucher</h5>
                                <p class="card-text">Create promotional vouchers for your customers.</p>
                                <a href="{{route('seller.create_voucher_form')}}" class="btn btn-primary">Create Voucher</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-tasks action-icon"></i>
                                <h5 class="card-title">Manage Orders</h5>
                                <p class="card-text">View and manage your customer orders.</p>
                                <a href="{{route('seller.manage_order_page')}}" class="btn btn-primary">View Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-chart-line action-icon"></i>
                                <h5 class="card-title">Sales Analysis</h5>
                                <p class="card-text">Analyze your sales performance and trends.</p>
                                <a href="{{route('seller.sales_analysis')}}" class="btn btn-primary">View Analytics</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-comments action-icon"></i>
                                <h5 class="card-title">Chat Conversation</h5>
                                <p class="card-text">Have conversations with your customers.</p>
                                <a href="{{route('seller.seller_chat_list')}}" class="btn btn-primary">Chat with Customers</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-sign-out-alt action-icon"></i>
                                <h5 class="card-title">Log Out</h5>
                                <p class="card-text">Sign out from your seller account.</p>
                                <a href="{{route('user.logout')}}" class="btn btn-primary">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>