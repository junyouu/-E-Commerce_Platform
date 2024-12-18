<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Add to Cart</h1>
    <form method="post" action="{{route('customer.get_variation_details', ['product_id' => $product_id])}}">
        @csrf
        @foreach ($attribute_names as $index => $name)
            <h2>{{ $name }}</h2>
            @foreach ($attribute_values_list[$index] as $value)
                <input type="radio" name="attribute_{{ $index + 1}}" value="{{ $value->attribute_value_id }}">
                <label for="attribute_{{ $index + 1}}">{{ $value->attribute_value }}</label>
                <br>
            @endforeach
        @endforeach
        
        <button type="submit">Add to Cart</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">
            @if(session('variation'))
                @php
                    $variation = session('variation');
                @endphp
                <form method="post" action="{{route('customer.add_to_cart')}}">
                    @csrf
                    <input type="text" name="variation_id" value="{{ $variation->variation_id }}" hidden>
                    <label for="">Price: </label>
                    <input type="text" name="price" value="{{ $variation->price }}" readonly>
                    <br>
                    <label for="">Stock: </label>
                    <input type="text" name="stock" value="{{ $variation->stock }}" readonly>
                    <br>
                    <label for="">Quantity: </label>
                    <input type="number" name="quantity" min="1" max="{{ $variation->stock }}" required>
                    <br>
                    <img src="{{ $variation->image_url }}" alt="">
                    <input type="submit" value="Confirm">
                </form>
                <a href="{{route('customer.add_to_cart_form', ['product_id' => $product_id])}}">Cancel</a>
            @endif
        </div>
    @endif

</body>
</html>