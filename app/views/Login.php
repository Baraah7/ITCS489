<!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../public/css/Login.css">
    </head>
    
    <body>
        <main>
            <div class="page">
                <p class="title">Bagdad library</p>
                <label class="label" for="username">Username</label>
                <input class="input" type="text" id="username" placeholder="Username" required>
                <label class="label" for="password">Password</label>
                <input class="input" type="password" id="password" placeholder="Password" required>
                <button class="button" id="loginButton">Login</button>
                <p class="error" id="errorMessage"></p>
            </div>
        </main>
        <script src="../../public/js/Login.js"></script>
    </body>
</html>
