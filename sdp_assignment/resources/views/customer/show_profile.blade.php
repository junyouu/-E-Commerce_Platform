<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    background-color: #FFF5E6; 
    font-family: 'Helvetica Neue', Arial, sans-serif;
}

.profile-container {
    margin-top: 30px;
    background-color: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    max-width: 600px; 
    margin-left: auto;
    margin-right: auto;
    border: 1px solid #ddd;
}

.profile-container h1 {
    font-weight: bold;
    color: #333;
    margin-bottom: 30px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f39c12;
}

.btn-edit, .btn-submit {
    background-color: #f39c12;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-edit:hover, .btn-submit:hover {
    background-color: #e08e0b;
}

.edit-form {
    margin-top: 30px;
    border-top: 1px solid #f39c12;
    padding-top: 20px;
}

.navbar-custom {
    background-color: #f39c12;
}

.navbar-custom .navbar-brand,
.navbar-custom .nav-link {
    color: white;
}

.navbar-custom .nav-link:hover {
    color: #333;
}

.navbar-custom .form-control {
    border-radius: 25px;
    width: 300px; 
}

.navbar-custom .btn-outline-light {
    border-radius: 25px;
}

.icon-bar a {
    color: white;
    padding: 8px 15px;
    border-radius: 25px;
    transition: background-color 0.3s ease;
}

.icon-bar a:hover {
    background-color: #e08e0b;
    color: white;
}

@media (max-width: 768px) {
    .navbar-custom .form-control {
        width: 200px;
    }

    .navbar-custom .icon-bar {
        flex-direction: column;
        align-items: flex-start;
    }

    .profile-container {
        padding: 15px;
        max-width: 100%; 
    }

    .btn-edit, .btn-submit {
        width: 100%; 
        margin-bottom: 10px;
    }
}

@media (max-width: 576px) {
    .navbar-custom .form-control {
        width: 150px; 
    }

    .profile-container {
        padding: 10px;
    }
}

    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('customer.index') }}">
                <img src="{{ asset('storage/images/logo.png') }}" alt="logo" width="50" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex mx-auto">
                    <form method="post" action="{{route('customer.search')}}" class="d-flex">
                        @csrf
                        <input class="form-control me-2" type="search" name="search query" placeholder="Search" aria-label="Search" required>
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
                <div class="d-flex icon-bar ms-auto">
                    <a href="{{route('customer.shopping_cart')}}" class="nav-link">Shopping Cart</a>
                    <a href="{{route('customer.customer_chat_list')}}" class="nav-link">Chat</a>
                    <a href="{{route('customer.show_profile')}}" class="nav-link">My Profile</a>
                   
                </div>
            </div>
        </div>
    </nav>

    <div class="container profile-container">
        <h1>Your Profile</h1>

      
        <div id="viewProfileSection">
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Phone Number:</strong> {{ $customer->phone_number }}</p>
            <p><strong>Age:</strong> {{ $customer->age }}</p>


            <button class="btn-edit" id="editProfileBtn">Edit Profile</button>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('editProfileBtn').addEventListener('click', function () {
            window.location.href = "{{route('customer.update_profile_form', ['customer_id' => $customer->customer_id])}}";
        });
    </script>
</body>

</html>