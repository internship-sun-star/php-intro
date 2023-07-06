<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/requester.js"></script>
    <title>Login</title>
</head>

<body>
    <form>
        <div>
            <label for="username">Username</label>
            <input id="username" name="username" type="text" value="xanhzp" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" value="123456" required>
        </div>
    </form>
    <div>
        <label for="remember">Remember Me</label>
        <input type="checkbox" name="remember" id="remember">
    </div>
    <div>
        <button type="button">Login</button>
    </div>
    <script src="./js/login.js"></script>
</body>

</html>