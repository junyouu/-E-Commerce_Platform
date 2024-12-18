<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Variations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --orange-primary: #FF7F50;
            --orange-secondary: #FFA07A;
            --orange-light: #FFE4B5;
        }
        body {
            background-color: #FFF5E6;;
        }
        .centered-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--orange-primary);
        }
        .card {
            border-color: var(--orange-secondary);
        }
        .table-dark {
            background-color: var(--orange-primary);
        }
        .btn-primary {
            background-color: var(--orange-primary);
            border-color: var(--orange-primary);
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="centered-title">Variations</h1>
        
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

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                @foreach($attributes as $attribute)
                                    <th>{{$attribute->attribute_name}}</th>
                                @endforeach
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($variations as $variation)
                                <tr>
                                    <td>{{$variation->attribute1}}</td>
                                    @if($variation->attribute2 != '-')
                                        <td>{{$variation->attribute2}}</td>
                                    @endif
                                    <form method="post" action="{{route('seller.update_variation', ['variation_id' => $variation->variation_id])}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" class="form-control" name="price" value="{{$variation->price}}">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" name="stock" value="{{$variation->stock}}">
                                        </td>
                                        <td>
                                            <div class="mb-2">
                                                @if($variation->image_url)
                                                    <small class="text-muted">Current image exists</small>
                                                @endif
                                            </div>
                                            <input type="file" class="form-control form-control-sm" name="image">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <a href="{{route('seller.index')}}" class="btn btn-secondary">Finish</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>