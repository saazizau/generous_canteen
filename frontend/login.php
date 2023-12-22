<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="assets/css/login.css" rel="stylesheet">
</head>
<body>
    <header class="header-container">
        <a class="logo-container" href="index.php">
            <img src="assets/img/logo-header.png" alt="Logo Generous Canteen">
        </a>
        <div id="greeting" class="greeting">
        </div>
    </header>
    <main>
        <form class="main-container" method="get">

            <div class="username-container">
                <label class="label" for="username">Username:</label>
                <input class="input" type="text" id="username" name="username" placeholder="Type Here">
            </div>

            <div class="password-container">
                <label class="label" for="password">Password:</label>
                <input class="input" type="password" id="password" name="password" placeholder="Type Here">
            </div>
    
            <button id="button-login" class="button-login" onclick="getLogin()">Login</button>
        </form>
        <h2 class="massage" id="massage"></h2>


    </main>
    <script src="assets/js/login.js"></script>
</body>
</html>