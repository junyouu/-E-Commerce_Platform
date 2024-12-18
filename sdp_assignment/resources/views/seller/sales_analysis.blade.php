<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
            max-width: 1200px;
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
        .card-body {
            text-align: center; 
            display: flex;
            flex-direction: column;
            justify-content: center; 
            height: 100%; 
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
        h1, h2 {
            color: var(--orange-primary);
            font-weight: 600;
        }
        .chart-container {
            position: relative;
            height: 400px;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem; 
        }
        .stats-item {
            flex: 1 1 23%; 
            min-width: 220px; 
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
        <h1 class="text-center mb-4">Sales Analysis</h1>
        
        <div class="stats-container mb-4">
            <div class="stats-item">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Visitors</h5>
                        <p class="card-text">{{$sales['visitors']}}</p>
                    </div>
                </div>
            </div>
            <div class="stats-item">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Conversion Rate</h5>
                        <p class="card-text">{{$sales['conversion_rate']}} %</p>
                    </div>
                </div>
            </div>
            <div class="stats-item">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text">{{$sales['total_orders']}}</p>
                    </div>
                </div>
            </div>
            <div class="stats-item">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sales Per Order</h5>
                        <p class="card-text">RM {{$sales['sales_per_order']}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="card-text">RM {{$sales['total_revenue']}}</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-center mb-4">Revenue Breakdown</h2>
        <div class="row">
            <div class="col-md-12 chart-container">
                <canvas id="myDonutChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const product_name = @json($product_name);  
        const revenue = @json($revenue);  
        new Chart(document.getElementById("myDonutChart"), {
            type: "doughnut",
            data: {
                labels: product_name,
                datasets: [{
                    data: revenue,
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#E2E2E2'
                    ],
                    borderColor: "transparent"
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 65,
            }
        });
    </script>
</body>
</html>

