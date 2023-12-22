<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");


$itemId = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;

$query = "SELECT purchase FROM items";

$result = $conn->query($query);

if(($result->num_rows) > 0){
    $row = $result->fetch_assoc();
    echo json_encode($row);
}

?>