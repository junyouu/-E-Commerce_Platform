<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
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
        .chat-container {
            width: 100%;
            max-width: 800px;
            background-color: #FFFFFF;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
            padding: 2rem;
        }
        .chat-header {
            background-color: #FF9800;
            color: white;
            padding: 1rem;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .messages {
            height: 400px;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }
        .message {
            border-radius: 10px;
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
            max-width: 75%;
            word-wrap: break-word;
        }
        .right-message {
            background-color: #FFE0B2;
            align-self: flex-end;
            text-align: right;
        }
        .left-message {
            background-color: #E3F2FD;
            align-self: flex-start;
            text-align: left;
        }
        .message-form {
            padding: 1rem;
            background-color: #FFF3E0;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        .btn-orange {
            background-color: #FF9800;
            border-color: #FF9800;
            color: white;
        }
        .btn-orange:hover {
            background-color: #F57C00;
            border-color: #F57C00;
            color: white;
        }
        .btn-light {
            background-color: #fff;
            color: #FF9800;
            border: 1px solid #FF9800;
            transition: all 0.3s ease;
        }
        .btn-light:hover {
            background-color: #FF9800;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Customer Side Conversation</h1>
                    <h2 class="h5 mb-0">{{$seller->shop_name}}</h2>
                </div>
                <a href="{{ route('customer.index') }}" class="btn btn-light">Back to Main Page</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger m-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="messages" id="chat-messages">
            @foreach ($messages as $message)
                @if ($message->sender == 'seller')
                    <div class="message left-message">
                        <p class="mb-0">{{$message->message_text}}</p>
                    </div>
                @else
                    <div class="message right-message">
                        <p class="mb-0">{{$message->message_text}}</p>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="message-form">
            <form id="message-form">
                <div class="input-group">
                    <input type="text" id="message" name="message" class="form-control" placeholder="Enter Message">
                    <button type="submit" class="btn btn-orange">Send</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var customer_id = "{{ session('customer_id') }}";
        // Initialize Pusher
        Pusher.logToConsole = true;
        var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: 'ap1'
        });

        var channel_name = 'chat.' + {{$seller->seller_id}} + '_' + customer_id; 
        var channel = pusher.subscribe(channel_name);

        channel.bind('chat', function(data) {
            console.log('Received data:', data);
            // Append the message received from Pusher to the chat box
            $('#chat-messages').append('<div class="message left-message"><p class="mb-0">' + data.message.message_text + '</p></div>');
            $(document).scrollTop($(document).height());
        });

        // Broadcast messages
        $('#message-form').submit(function(event) {
            event.preventDefault();

            var messageInput = $('#message').val().trim();

            $.ajax({
                url: "{{ route('customer.send_message', ['seller_id' => $seller->seller_id]) }}",
                method: 'POST',
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    message: messageInput,
                },
                success: function(res) {
                    $('#chat-messages').append('<div class="message right-message"><p class="mb-0">' + res.message + '</p></div>');
                    $('#message').val('');
                    $(document).scrollTop($(document).height());
                }
            });
        });

        // Refresh the page every 5 seconds if the input field is empty
        setInterval(function() {
            if ($('#message').val().trim() === '') {
                location.reload();
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
</body>
</html>
