<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFF5E6;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar-custom {
            background-color: #FF8C00;
        }

        .navbar-custom .navbar-brand {
            color: #fff;
            font-size: 1.5rem;
        }

        .navbar-custom .nav-link {
            color: #fff;
            margin-left: 15px;
        }

        .navbar-custom .nav-link:hover {
            color: #e65c00;
        }

        .navbar-custom img {
            height: 40px;
        }

        .main-content {
            margin-top: 25px;
            padding: 20px;
            background-color: #fff;
            border-radius:10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
            border: 3px solid #f9f9f9;
        }

        .btn-custom {
            background-color: #FF8C00;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #e65c00;
            color: #fff;
        }

        .btn-logout {
            background-color: #fff;
            color: #FF8C00;
            border: 1px solid #ff6600;
            border-radius: 10px;
            padding: 5px 10px;
        }

        .btn-logout:hover {
            background-color: #f4f4f4;
            color: #e65c00;
        }

        .alert-success {
            margin-top: 20px;
        }

        .header {
            font-family: 'Poppins', sans-serif;
            margin-top: 115px;
            text-align: center;
            font-size: 32px;
            color: #fd7c17 ;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('admin.index')}}">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a class="btn btn-custom me-2" href="{{route('admin.show_seller_request')}}">Seller Request</a>
                    <a class="btn btn-logout" href="{{route('user.logout')}}">Log Out</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="header"><b>🗣  Admin Main Page</b></div>

    <div class="main-content">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Customer</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Seller</button>
            </li>
        </ul>
        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Suspend</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $index => $customer)
                            <tr>
                                <th scope="row">{{$index+1}}</th>
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->phone_number}}</td>
                                <td>
                                    <button class="btn btn-custom" 
                                        onclick="window.location.href='{{route('admin.suspend_user', ['user_id' => $customer->user_id])}}'">
                                        Suspend
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Shop Description</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Suspend</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sellers as $index => $seller)
                            <tr>
                                <th scope="row">{{$index+1}}</th>
                                <td>{{$seller->shop_name}}</td>
                                <td>{{$seller->shop_description}}</td>
                                <td>{{$seller->email}}</td>
                                <td>{{$seller->phone_number}}</td>
                                <td>
                                    <button class="btn btn-custom" 
                                        onclick="window.location.href='{{route('admin.suspend_user', ['user_id' => $seller->user_id])}}'">
                                        Suspend
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>