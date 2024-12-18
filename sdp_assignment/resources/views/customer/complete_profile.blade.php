<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Complete Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E6; 
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #FF5722; 
            display: flex;
            flex-direction: column;
            min-height: 400px; 
        }

        h1 {
            color: #FF5722; 
            text-align: center;
            margin-bottom: 30px;
        }

        .alert {
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-label {
            color: #333;
        }

        .btn-submit {
            background-color: #FF5722; 
            color: #ffffff;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%; 
            margin-top: auto; 
        }

        .btn-submit:hover {
            background-color: #e64a19;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Complete Your Profile</h1>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{route('customer.complete_profile')}}" enctype="multipart/form-data">
            @csrf
            @method('post')
            
            <div class="form-group">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="Enter your phone number">
            </div>

            <div class="form-group">
                <label for="date_of_birth" class="form-label">Date of Birth:</label>
                <input type="date" name="date_of_birth" class="form-control" id="date_of_birth">
            </div>

            <button type="submit" class="btn btn-submit">Complete</button>
        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>