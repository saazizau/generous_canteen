<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generous Canteen</title>
    <link href="assets/css/home.css" rel="stylesheet">
</head>
<body>
    <main class="main-container">

        <a href="index.php" class="logo-container">
            <img src="assets/img/logo.png" alt="Logo Generous Canteen">
        </a>

        <div class="title-container">
            <h1 class="title">Generous Canteen</h1>
            <p class="description">A Self-Paid Canteen</p>
        </div>

        <div class="button-container">
            <a class="button" id="Admin" onclick="adminLogin()" href="login.php">Admin</a>
            <a class="button" id="Officer" onclick="officerLogin()" href="login.php">Officer</a>
        </div>        
    </main>

    <footer class="footer-container">
        <h2>About us</h2>
        <p>It is necessary to monitor stock and income so that the self-paid canteen owner can take the best steps to overcome the problems that occur and optimize the function of the canteen with the help of this application.</p>
    </footer>
    <script src="assets/js/index.js"></script>
</body>
</html>