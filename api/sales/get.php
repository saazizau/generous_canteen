<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if(isset($_REQUEST['date'])){
    $date = $_REQUEST['date'];
    $query = "SELECT * FROM sales_report
    INNER JOIN sales_report_details ON sales_report.id_sales=sales_report_details.id_sales
    INNER JOIN items ON sales_report_details.id_items=items.id
    WHERE sales_report.date='$date'";

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