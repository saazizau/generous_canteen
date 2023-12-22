<!--
<?php
session_start();

if(!isset($_SESSION['level'])){
    header("Location: http://localhost/generous canteen/frontend/login.php");
}
if($_SESSION['level'] != 2){
    echo "<script>showAlert('Wops! Anda bukan admin, silahkan login sebagai admin terlebih dahulu!')</script>";
    header("Location: http://localhost/generous canteen/api/logout.php");
}

?>
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer</title>
    <link href="../assets/css/popup.css" rel="stylesheet">
    <link href="../assets/css/officer/index.css" rel="stylesheet">
    <link href="https://fontawesome.com/icons/trash-can?f=classic&s=regular" rel="stylesheet">
    <script src="https://kit.fontawesome.com/867fcd6c21.js" crossorigin="anonymous"></script>
</head>
<body>

    <header class="header-container">

        <a class="logo-container" href="index.php">
            <img class="logo" src="../assets/img/logo-header.png" alt="Logo Generous Canteen">
        </a>
        <div id="greeting" class="greeting">
            <h1 class="title">
                Selling Recap
            </h1>
        </div>
        <span class="left-item"> Hi, <?php echo $_SESSION['name'] ?></span>
        <a class="logout-container" onclick="getLogout()">
            <img class="logout" src="../assets/img/logout.png">
        </a>

    </header>

    <main>

        <div class="main-container">
            <div class="top-container">
                <span class="cash-lable">Cash:</span>
                <input class="cash-input" id="Cash-input" placeholder="Type Here">
                <button class="button" id="Save" onclick="setCash()">Save</button>
            </div>
            <div class="table-container">
                <table class="table-items">
                    <thead class="table-header">
                        <tr>
                            <th>Id</th>
                            <th>Item Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th colspan="1"></th>
                        </tr>
                    </thead>
    
                    <tbody id="table-body" class="table-body">
                    </tbody>
                </table>
            </div>

        </div>

        <div id="alertPopup">
            <h2 class="popup-title" id="Title">Alert!</h2>
            <p class="popup-message" id="Message">Isi pop-up disini...</p>
            <button class="popup-button" onclick="handleAlert(true)">Tutup</button>
          </div>
        <div id="overlay" onclick="hideAlert()"></div>

        <div id="confirmPopup">
            <h2 class="popup-title" id="TitleC">Konfirmasi</h2>
            <p class="popup-message" id="MessageC">Isi pop-up disini...</p>
            <div class="popup-button-container">
                <button class="popup-button" onclick="handleConfirm(true)">Oke</button>
                <button class="popup-button" onclick="handleConfirm(false)">Batal</button>
            </div>
        </div>

    </main>
    <script src="../assets/js/officer/index.js"></script>
    <script src="../assets/js/popup.js"></script>
</body>
</html>