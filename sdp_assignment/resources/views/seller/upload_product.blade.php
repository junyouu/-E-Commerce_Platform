<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
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
        :root {
            --orange-primary: #FF7F50;
            --orange-secondary: #FFA07A;
            --orange-light: #FFE4B5;
            --orange-dark: #E65100;
            --bg-color: #FFF9F5;
        }
        body {
            background-color: var(--bg-color);
            color: #333;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(255,127,80,0.1);
            background-color: #FFF;
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 10px 30px rgba(255,127,80,0.3);
        }
        .card-title {
            color: var(--orange-primary);
            font-weight: 600;
        }
        .btn-primary {
            background-color: var(--orange-primary);
            border-color: var(--orange-secondary);
        }
        .btn-primary:hover {
            background-color: var(--orange-secondary);
            border-color: var(--orange-secondary);
        }
        .btn-secondary {
            background-color: var(--orange-secondary);
            border-color: var(--orange-secondary);
        }
        .btn-secondary:hover {
            background-color: var(--orange-primary);
            border-color: var(--orange-primary);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--orange-secondary);
            box-shadow: 0 0 0 0.25rem rgba(255,127,80,0.25);
        }
        h1 {
            color: var(--orange-primary);
            font-weight: 600;
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
    <div class="container">
        <h1 class="text-center mb-4">Upload Product</h1>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('request_success'))
            <div class="alert alert-success">
                {{ session('request_success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Upload New Product</h5>
                <form method="post" action="{{route('seller.upload_product')}}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_description" class="form-label">Product Description</label>
                        <textarea class="form-control" id="product_description" name="product_description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="product_category" class="form-label">Category</label>
                        <select class="form-select" id="product_category" name="category_id" required>
                            <option value="">Please Select</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="subCategoryContainer"></div>
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="product_image" name="product_image" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Request New Product Label</h5>
                <form method="post" action="{{route('seller.request_new_product_label')}}">
                    @csrf
                    @method('post')
                    <input type="hidden" name="seller_id" value="{{Session::get('seller_id')}}">
                    <div class="mb-3">
                        <label for="request_category" class="form-label">Category</label>
                        <select class="form-select" id="request_category" name="category_id" required>
                            <option value="">Please Select</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="label_name" class="form-label">New Product Label</label>
                        <input type="text" class="form-control" id="label_name" name="label_name" required>
                    </div>
                    <button type="submit" class="btn btn-secondary">Submit Request</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#product_category').on('change', function() {
                var category = $(this).val();
                if (category) {
                    $.ajax({
                        url: '{{ route('seller.get_product_label') }}',
                        type: 'GET',
                        data: { category: category },
                        success: function(response) {
                            $('#subCategoryContainer').html(response.html);
                        }
                    });
                } 
            });
        });
    </script>
</body>
</html>