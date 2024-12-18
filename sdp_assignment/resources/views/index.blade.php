<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#FFF5E6;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; 
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .logo {
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 100%;
            height: 60px;
            width: 50px;
        }
        .form-container {
            background-color: white;
            border: 1.5px solid #FF8C00;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin: 0 0 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #FF8C00;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        input[type="submit"]:hover {
            background-color: #ff6f00;
        }
        a {
            display: inline;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .login-redirect {
            text-align: center;
            margin-top: 10px;
        }
        .login-redirect span {
            display: block;
            margin-bottom: 10px;
        }
        ul {
            padding: 0;
            list-style-type: none;
            color: red;
        }
        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ asset('storage/images/logo.png') }}" alt="Orange Logo">
    </div>
    <div class="form-container">
        <h1>Register</h1>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <form method="post" action="{{ route('user.register') }}">
            @csrf
            @method('post')
            <label for="username">Username: </label>
            <input type="text" id="username" name="username">
            <label for="password">Password: </label>
            <input type="password" id="password" name="password">
            <label for="role">Role: </label>
            <select id="role" name="role">
                <option value="customer">Customer</option>
                <option value="seller">Seller</option>
            </select>
            <input type="submit" value="Register">
        </form>
        <div class="login-redirect">
            <span>Already have an account?</span>
            <a href="{{ route('user.show_login_form') }}">Login here</a>
        </div>
    </div>
</body>
</html>

