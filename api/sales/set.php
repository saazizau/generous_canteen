<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");


if(isset($_REQUEST['date']) & isset($_REQUEST['price']) & isset($_SESSION['id'])){
    $date = $_REQUEST['date'];
    $price = $_REQUEST['price'];
    $salesId = isAny($conn, $date);
    if($salesId >= 0){
        $query = "UPDATE sales_report SET price = '$price' WHERE id_sales=$salesId";
        $conn->query($query);
        $response = array('status' => 'success', 'message' => 'Berhasil Memperbarui Data Penjualan');
    } else {
        $salesId = getSalesID($conn, $date);
        $idUser = $_SESSION['id'];
        $query = "INSERT INTO sales_report (id_sales, date, price, id_officer) VALUES ('$salesId', '$date', $price, $idUser)";
        $conn->query($query);
        $response = array('status' => 'success', 'message' => 'Berhasil Menyimpan Data Penjualan');
    }
    
} else {
    $response = array('status' => 'error', 'message' => 'Parameter tidak dipenuhi');
}

echo json_encode($response);

function isAny($conn, $date){
    $query = "SELECT * FROM sales_report WHERE date='$date'";
    $result = $conn->query($query);

    if (($result->num_rows) > 0){
        $row = $result->fetch_assoc();
        return ((int)$row['id_sales']);
    } else {
        return -1;
    }
}

function getSalesID($conn, $date){
    $query = "SELECT id_sales FROM sales_report ORDER BY id_sales DESC";
    $result = $conn->query($query);

    if(($result->num_rows) > 0){
        $row = $result->fetch_assoc();
        return ((int)$row['id_sales']+1);
    } else {
        return 0;
    }
}
?>