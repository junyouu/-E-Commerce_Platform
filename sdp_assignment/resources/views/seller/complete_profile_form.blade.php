<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Seller Complete Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        :root {
            --primary-orange: #FF7F50;
            --secondary-orange: #FFA07A;
            --dark-orange: #FF4500;
        }
        body {
            background-color: #FFF5EE;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(255, 127, 80, 0.2);
            border: 1px solid var(--secondary-orange);
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: var(--dark-orange);
        }
        .btn-primary {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        .btn-primary:hover {
            background-color: var(--dark-orange);
            border-color: var(--dark-orange);
        }
        .form-control:focus {
            border-color: var(--secondary-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 127, 80, 0.25);
        }
        .form-label {
            color: var(--dark-orange);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h1 class="text-center">Seller Complete Profile</h1>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('seller.complete_profile')}}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="mb-3">
                            <label for="shop_name" class="form-label">Shop Name</label>
                            <input type="text" class="form-control" name="shop_name" id="shop_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="shop_description" class="form-label">Shop Description</label>
                            <textarea class="form-control" name="shop_description" id="shop_description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" id="image" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Complete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>