<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");


$id_supply = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;

$query = "DELETE FROM supply_report_details WHERE id_supply=$id_supply";
if(($conn->query($query)) === TRUE){
    $query = "DELETE FROM supply_report WHERE id_supply=$id_supply";
    if(($conn->query($query)) === TRUE){
        echo json_encode(array('massage' => "Berhasil Menghapus Data dengan Id $id_supply"));
    }
} else {
    echo json_encode(array('massage' => "Gagal Menghapus Data dengan Id $id_supply"));
}
?>
