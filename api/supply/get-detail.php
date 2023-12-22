<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if(isset($_REQUEST['date'])){
    $date = $_REQUEST['date'];
    $query = "SELECT * FROM supply_report
    INNER JOIN supply_report_details ON supply_report.id_supply=supply_report_details.id_supply
    INNER JOIN items ON supply_report_details.id_items=items.id
    WHERE supply_report.date='$date'";

    $result = $conn->query($query);
    $data = [];
    if(($result->num_rows) > 0){
        while($row = $result->fetch_assoc()){
            array_push($data, $row);
        }
        
    }  
    echo json_encode($data); 
}














?>