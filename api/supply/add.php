<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$id_supplier = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
$price = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
$qty = isset($_REQUEST['qty']) ? $_REQUEST['qty'] : '';




?>