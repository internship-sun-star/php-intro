<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/requester.js"></script>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(320deg, #eb92be, #ffef78, #63c9b4);
            font-family: "Raleway", sans-serif;
            height: 100vh;
        }

        .center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .center button {
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 600;
            color: #222;
            background: #f5f5f5;
            border: none;
            outline: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 380px;
            padding: 20px 30px;
            background: #fff;
            box-shadow: 2px 2px 5px 5px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }

        .container .form h2 {
            text-align: center;
            color: #222;
            margin: 10px 0px 20px;
            font-size: 25px;
        }

        .container .form .form-element {
            margin: 15px 0px;
        }

        .container .form .form-element label {
            font-size: 15px;
            color: #222;
        }

        .container .form .form-element input[type="text"],
        .container .form .form-element input[type="password"] {
            margin-top: 15px;
            display: block;
            width: 100%;
            padding: 10px;
            outline: none;
            border: 1px solid #aaa;
            border-radius: 5px;
        }

        .container .form .form-element input[type="checkbox"] {
            margin-right: 5px;
        }

        .container .form .form-element button {
            width: 100%;
            height: 40px;
            border: none;
            outline: none;
            font-size: 16px;
            background: #222;
            color: #f5f5f5;
            border-radius: 10px;
            cursor: pointer;
        }

        .container .form .form-element button:hover {
            background: #555;
        }


    </style>
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="form">
            <h2>Login</h2>
            <div class="form-element">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" required>
            </div>
            <div class="form-element">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>
            <div class="form-element">
                <label for="remember">Remember Me</label>
                <input type="checkbox" name="remember" id="remember">
            </div>
            <div class="form-element">
                <button id="login-btn" type="button">Sign in</button>
            </div>
        </div>
    </div>
    
    <script src="./js/login.js"></script>
</body>

</html>