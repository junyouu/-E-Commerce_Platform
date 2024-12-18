<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Handle Seller Request</title>
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius:5px;
            border: 3px solid #FF8C00;
            display: flex;
            gap: 20px;
            flex-wrap: nowrap;
            justify-content: space-between;
        }

        .table-container {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            border-radius: 8px;
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

        a.btn-custom {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #ff6600;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            font-weight: bold;
        }

        a.btn-custom:hover {
            background-color: #e65c00;
        }

        .header {
            margin-top: 115px;
            text-align: center;
            font-size: 32px;
            font-family: 'Poppins', sans-serif;
            color: #fd7c17 ;
        }

        .add-category-form {
            width: 300px;
            background-color: #fff;
            border: 3px solid #FF8C00;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .add-category-form label, 
        .add-category-form input {
            display: block;
            margin: 10px 0;
        }

        .add-category-form input[type="text"] {
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
            padding: 10px;
        }

        .add-category-form input[type="submit"] {
            background-color: #FF8C00;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }

        .add-category-form input[type="submit"]:hover {
            background-color: #e65c00;
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

        </div>
    </nav>

    <div class="header"><b>Handle Seller Request</b></div>

    <div class="main-content">
        <div class="table-container">
            <table>
                <tr>
                    <th>Request ID</th>
                    <th>Seller Name</th>
                    <th>Category</th>
                    <th>Label Name</th>
                    <th>Status</th>
                    <th>Approve</th>
                    <th>Reject</th>
                </tr>
                @foreach($requests as $request)
                <tr>
                    <td>{{$request->request_id}}</td>
                    <td>{{$request->seller_name}}</td>
                    <td>{{$request->category}}</td>
                    <td>{{$request->label_name}}</td>
                    <td>{{$request->status}}</td>
                    <td><a class="btn btn-custom" href="{{route('admin.approve_seller_request', ['request_id' => $request->request_id])}}">Approve</a></td>
                    <td><a class="btn btn-custom" href="{{route('admin.reject_seller_request', ['request_id' => $request->request_id])}}">Reject</a></td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="add-category-form">
            <h2>Add Category</h2>
            <form method="post" action="{{route('admin.add_category')}}" enctype="multipart/form-data">
                @csrf
                @method('post')
                <label for="category_name">Category Name: </label>
                <input type="text" name="category_name" id="category_name" required>
                <input type="submit" value="Add" class="btn btn-custom">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>