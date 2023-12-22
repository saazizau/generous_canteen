<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");


if(isset($_REQUEST['date']) & isset($_SESSION['id'])){
    $date = $_REQUEST['date'];
    echo json_encode(array('status' => 'success', 'price' => getPrice($conn, $date)));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Parameter tidak dipenuhi'));
}

function getPrice($conn, $date){
    $query = "SELECT * FROM sales_report WHERE date='$date'";
    $result = $conn->query($query);
    if(($result->num_rows) > 0){
        $row = $result->fetch_assoc();
        return ((int)$row['price']);
    } else {
        return -1;
    }
}
