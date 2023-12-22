<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");


$itemId = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;

$query = "DELETE FROM items WHERE id=$itemId";
if(($conn->query($query)) === TRUE){
    echo json_encode(array('massage' => "Berhasil Menghapus Data dengan Id $itemId"));
} else {
    echo json_encode(array('massage' => "Gagal Menghapus Data dengan Id $itemId"));
}
?>
