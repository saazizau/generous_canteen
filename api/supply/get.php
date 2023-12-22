<?php
include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$query = "SELECT * FROM supply_report INNER JOIN users ON supply_report.id_supplier=users.id";
$result = $conn->query($query);

$data = [];
if(($result->num_rows) > 0){
    while($row = $result->fetch_assoc()){
        array_push($data, $row);
    }
}
echo json_encode($data);
?>