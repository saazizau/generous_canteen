
<?php
session_start();

if(!isset($_SESSION['level'])){
    header("Location: http://localhost/generous canteen/frontend/login.php");
}
if($_SESSION['level'] != 1){
    echo "<script>showAlert('Wops! Anda bukan admin, silahkan login sebagai admin terlebih dahulu!')</script>";
    header("Location: http://localhost/generous canteen/api/logout.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="../assets/css/popup.css" rel="stylesheet">
    <link href="../assets/css/admin/edit-stock.css" rel="stylesheet">
</head>
<body>
    <header class="header-container">
        <a class="logo-container" href="index.php">
            <img class="logo" src="../assets/img/logo-header.png" alt="Logo Generous Canteen">
        </a>
        <div id="greeting" class="greeting">
            <h1 class="title">Edit Stock</h1>
        </div>
        <span class="left-item"> Hi, <?php echo $_SESSION['name'] ?></span>
        <a class="logout-container" onclick="getLogout()">
            <img class="logout" src="../assets/img/logout.png">
        </a>
    </header>
    <main>
        <div class="main-container">
            <form class="form-container">

                <div class="input-container">
                    <label class="label" for="name">Item Name</label>
                    <input class="input" type="text" id="name" name="name" placeholder="Previous Item Name">
                </div>

                <div class="input-container">
                    <label class="label" for="price">Unit Price</label>
                    <input class="input" type="text" id="price" name="price" placeholder="Previous Item Price">
                </div>

                <div class="input-container">
                    <label class="label" for="qty">Quantiy</label>
                    <input class="input" type="text" id="qty" name="qty" placeholder="Previous Quantiy">
                </div>

                <div class="input-container">
                    <label class="label" for="id">Item Id</label>
                    <input class="input" type="text" id="id" name="id" placeholder="Auto" readonly>
                </div>

                <div class="input-container">
                    <label class="label" for="date">Date</label>
                    <input class="input" type="date" name="myDate" id="myDate" placeholder="Auto">
                </div>
                    
            </form>
            <div class="button-container">
                <button class="button" id="Update" onclick="getUpdate()" >Update</button>
                <button class="button" id="Back" onclick="getBack()" >Back</button>
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
    <script src="../assets/js/admin/edit-stock.js"></script>
    <script src="../assets/js/popup.js"></script>
</body>
</html>