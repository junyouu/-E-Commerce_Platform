<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Variation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #FF7F50;
            --secondary-orange: #FFA07A;
            --dark-orange: #FF4500;
            --light-orange: #FFE4B5;
        }
        body {
            background-color: #FFF5EE;
            padding: 20px;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(255, 127, 80, 0.2);
        }
        .attribute-table {
            margin-bottom: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(255, 127, 80, 0.1);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(255, 127, 80, 0.2);
        }
        .card-header {
            background-color: var(--primary-orange);
            color: #ffffff;
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background-color: var(--dark-orange);
            border-color: var(--dark-orange);
        }
        .btn-primary:hover {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        .btn-secondary {
            background-color: var(--secondary-orange);
            border-color: var(--secondary-orange);
            color: #ffffff;
        }
        .btn-secondary:hover {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        .btn-primary, .btn-secondary {
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-control {
            border-radius: 20px;
            border-color: var(--light-orange);
        }
        .form-control:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 127, 80, 0.25);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background-color: var(--light-orange);
        }
        h1, .lead {
            color: var(--dark-orange);
        }
    </style>
</head>
<body>
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="mb-4 text-center"><i class="fas fa-plus-circle me-2"></i>Add Variation</h1>
        <p class="lead text-center mb-5">{{$product->product_name}}</p>

        @foreach ($attributes as $attribute)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Attribute: {{ $attribute->attribute_name }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover attribute-table">
                        <thead>
                            <tr>
                                <th>Option</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attribute->values as $value)
                                <tr>
                                    <td><i class="fas fa-circle me-2"></i>Option {{ $loop->iteration }}</td>
                                    <td>{{ $value->attribute_value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <form method="post" action="{{route('seller.add_attribute')}}" class="mb-4">
            @csrf
            @method('post')
            <input type="hidden" name="product_id" value="{{$product->product_id}}">
            <div class="mb-3">
                <label for="attribute_name" class="form-label"><i class="fas fa-pencil-alt me-2"></i>Attribute Name:</label>
                <input type="text" name="attribute_name" id="attribute_name" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-list me-2"></i>Options:</label>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <input type="text" name="attribute_value_1" class="form-control" placeholder="Option 1" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <input type="text" name="attribute_value_2" class="form-control" placeholder="Option 2 (Optional)">
                    </div>
                    <div class="col-md-4 mb-2">
                        <input type="text" name="attribute_value_3" class="form-control" placeholder="Option 3 (Optional)">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check me-2"></i>Submit</button>
        </form>

        <a href="{{route('seller.generate_variation', ['product_id' => $product->product_id])}}" class="btn btn-secondary"><i class="fas fa-arrow-right me-2"></i>Next Step</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>