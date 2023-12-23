
<?php
session_start();

if(!isset($_SESSION['level'])){
    header("Location: https://sabrinaazizaulia.com/generous canteen/frontend/login.php");
}
if($_SESSION['level'] != 1){
    echo "<script>showAlert('Wops! Anda bukan admin, silahkan login sebagai admin terlebih dahulu!')</script>";
    header("Location: https://sabrinaazizaulia.com/generous canteen/api/logout.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="../assets/css/popup.css" rel="stylesheet">
    <link href="../assets/css/admin/selling-detail.css" rel="stylesheet">
    <link href="https://fontawesome.com/icons/trash-can?f=classic&s=regular" rel="stylesheet">
    <script src="https://kit.fontawesome.com/867fcd6c21.js" crossorigin="anonymous"></script>
</head>
<body>

    <header class="header-container">

        <a class="logo-container" href="inde.php">
            <img class="logo" src="../assets/img/logo-header.png" alt="Logo Generous Canteen">
        </a>
        <div id="greeting" class="greeting">
            <h1 class="title">
                Selling Detail
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
                <div class="filter-container">
                    <p class="filter-lable">Date: </p>
                    <input class="filter" id="myDate" type="date"  onchange="getItemData()">
                </div>
                <button class="button" id="Back" onclick="getBack()">Back</button>
            </div>
            <div class="table-container">
                <table class="table-items">
                    <thead class="table-header">
                        <tr>
                            <th>Id</th>
                            <th>Item Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="table-body">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bottom-container">
            <div class="cash-container">
                <p class="bottom-lable">Cash:</p>
                <p class="bottom-value" id="TotalSell">from selling recap</p>
            </div>
            <div class="income-container">
                <p class="bottom-lable">Income:</p>
                <p class="bottom-value" id="TotalPrice">Total Price</p>
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
    <script src="../assets/js/admin/selling-detail.js"></script>
    <script src="../assets/js/popup.js"></script>
</body>
</html>