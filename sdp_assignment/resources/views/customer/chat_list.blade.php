<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Chat List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E6;
            color: #4A4A4A;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .page-title {
            color: #FF8C00;
            margin-bottom: 1.5rem;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }
        .chat-list-container {
            width: 100%;
            max-width: 600px;
            background-color: #FFFFFF;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .chat-item {
            background-color: #FFF9F0;
            border-left: 5px solid #FF8C00;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        .chat-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .chat-name {
            color: #FF8C00;
        }
        .chat-message {
            color: #6C757D;
        }
        .chat-time {
            font-size: 0.8rem;
            color: #ADB5BD;
        }
    </style>
</head>
<body>
    <div class="chat-list-container">
        <h1 class="page-title">Customer Chat List</h1>
        <div class="list-group">
            @foreach ($chat_list as $list_item)
                <a href="{{route('customer.chat_with_seller', ['seller_id' => $list_item->seller_id])}}" class="list-group-item list-group-item-action chat-item p-3">
                    <div class="d-flex w-100 justify-content-between">
                        <h4 class="mb-1 chat-name">{{$list_item->shop_name}}</h4>
                        <small class="chat-time">{{$list_item->created_at->format('Y-m-d H:i')}}</small>
                    </div>
                    <p class="mb-1 chat-message">{{Str::limit($list_item->message_text, 50)}}</p>
                </a>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
