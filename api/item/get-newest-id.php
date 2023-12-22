<?php
include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$query = "SELECT id FROM items ORDER BY id DESC";
$result = $conn->query($query);

if(($result->num_rows) > 0){
    $data = $result->fetch_assoc();
    echo json_encode(array('status'=>'success','itemId'=>($data['id']+1)));
}

?>