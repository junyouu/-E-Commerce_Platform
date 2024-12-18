<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Voucher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --orange-primary: #FF7F50;
            --orange-secondary: #FFA07A;
            --orange-light: #FFE4B5;
        }
        body {
            background-color: #FFF5E6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            padding-top: 100px;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #FF8C00;
            color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar img {
            height: 40px;
        }
        .form-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(255, 127, 80, 0.2);
            padding: 40px;
        }
        h1 {
            color: var(--orange-primary);
            font-weight: bold;
        }
        .form-label {
            color: var(--orange-primary);
            font-weight: 600;
        }
        .form-control, .form-select {
            border-color: var(--orange-secondary);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 0.25rem rgba(255, 127, 80, 0.25);
        }
        .btn-primary {
            background-color: var(--orange-primary);
            border-color: var(--orange-primary);
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--orange-secondary);
            border-color: var(--orange-secondary);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{route('seller.index')}}">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo">
        </a>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 form-container">
                <h1 class="text-center mb-4">Create Voucher</h1>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form method="post" action="{{route('seller.create_voucher')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="voucher_description" class="form-label">Voucher Description:</label>
                        <input type="text" class="form-control" name="voucher_description" required>
                    </div>
                    <div class="mb-3">
                        <label for="discount_type" class="form-label">Discount Type:</label>
                        <select class="form-select" name="discount_type" required>
                            <option value="percentage">Percentage</option>
                            <option value="fixed_amount">Fixed Amount</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="discount_value" class="form-label">Discount Value:</label>
                        <input type="number" class="form-control" name="discount_value" min="1" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="usage_limit" class="form-label">Usage Limit:</label>
                        <input type="number" class="form-control" name="usage_limit" min="1" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Create Voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>