<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");


$itemId = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
$itemName = isset($_REQUEST['name']) ? $_REQUEST['name'] : NULL;
$itemPrice = isset($_REQUEST['price']) ? $_REQUEST['price'] : NULL;
$itemPurchase = isset($_REQUEST['purchase']) ? $_REQUEST['purchase'] : NULL;
$itemQty = isset($_REQUEST['qty']) ? $_REQUEST['qty'] : NULL;
$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : NULL;
$idUser = isset($_SESSION['id']) ? $_SESSION['id'] : NULL;

$response = array(
    "status" => 'Undefined',
    "track" => [],
    "massage" => 'Parameter Not ALL Setted'
);

// Mengecek apakah semua variabel sudah diisi
if(isset($idUser) && isset($itemId) && isset($itemName) && isset($itemPrice) && isset($itemPurchase) && isset($itemQty) && isset($date)){
    $response['track'] = array_merge($response['track'], array("All Paramaters Setted"));
    
    $supplyID = array(getSupplyId($conn, $date)[0],getSupplyId($conn, $date)[1]);

    if(insertItem($conn, $itemId, $itemName, $itemQty, $itemPrice, $itemPurchase)){
        $response['track'] = array_merge($response['track'], array("Succeed insert item $itemName to database"));
        if($supplyID[0]){
            $response['track'] = array_merge($response['track'], array("Entered Update Supply"));
            if(updateSupply($conn, $supplyID[1], $itemPurchase, $itemQty)){

                $response['track'] = array_merge($response['track'], array("Succeed update suppply with $supplyID[1] to database"));
                $response['massage'] = insertSupplyDetail($conn, $supplyID[1], $itemId, $itemPurchase, $itemQty, $idUser) ? "Berhasil Menyimpan Data" : "Gagal Menyimpan Data Supply Detail";
                $response['status'] = "success";
                
            } else {
                $response['massage'] = "Gagal Update Supply";
                $response['status'] = "error";
            }
        } else {
            if(insertSupply($conn, $supplyID[1], $date, $itemPurchase, $idUser, $itemQty)){
            
                $response['track'] = array_merge($response['track'], array("Succeed insert $supplyID[1] to database"));
                $response['massage'] = insertSupplyDetail($conn, $supplyID[1], $itemId, $itemPurchase, $itemQty, $idUser) ? "Berhasil Menyimpan Data" : "Gagal Menyimpan Data Supply Detail";
                $response['status'] = "success";
            
            } else {
                $response['massage'] = "Gagal Insert Supply";
                $response['status'] = "error";
            } 
        } 
    } else {
        $response['massage'] = "Gagal Insert Item";
        $response['status'] = "error";;
    }  
} else {
    $response['massage'] = "Parameter Not Completed";
    $response['status'] = "error";; 
}

echo json_encode($response);


// Insert Item
function insertItem($conn, $itemId, $itemName, $itemQty, $itemPrice, $itemPurchase){
    $query = "INSERT INTO items (id, name, qty, price, purchase) VALUES ('$itemId', '$itemName', '$itemQty', '$itemPrice', '$itemPurchase')";
    return (($conn->query($query)) === TRUE);    
}

// Insert Supply
function insertSupply($conn, $supplyId, $date, $price, $idUser, $itemQty){
    $query = "INSERT INTO supply_report (id_supply, date, purchase, id_supplier) VALUES ('$supplyId', '$date', ($price*$itemQty), $idUser)";
    return (($conn->query($query)) === TRUE);
}

// Update Supply
function updateSupply($conn, $supplyId, $itemPrice, $itemQty){
    $query = "UPDATE supply_report SET purchase = (purchase + ($itemPrice * $itemQty)) WHERE id_supply = '$supplyId'";
    return (($conn->query($query)) === TRUE);
}

// Insert Supply Detail
function insertSupplyDetail($conn, $supplyId, $itemId, $itemPrice, $itemQty, $idUser){
    $detailId = getDetailId($conn, $supplyId);
    $query = "INSERT INTO supply_report_details (id_supply_details, id_supply, id_items, purchase, number, id_supplier) VALUES ('$detailId', '$supplyId','$itemId',$itemPrice,$itemQty,$idUser)";
    return (($conn->query($query)) === TRUE);
}

// Get Supply ID
function getSupplyId($conn, $date){
    $query = "SELECT id_supply FROM supply_report WHERE date='$date'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return array(TRUE, $row['id_supply']);
    } else {
        $query = "SELECT id_supply FROM supply_report ORDER BY id_supply DESC";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return array(FALSE, $row['id_supply']+1);
        }
    }
}

// Get Supply Detail Id
function getDetailId($conn, $id_supply){
    $query = "SELECT id_supply_details FROM supply_report_details ORDER BY id_supply_details DESC";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id_supply_details']+1;
    } else {
        return 0;
    }

}

//Get Qty Difference
function getQtyDif($conn, $itemId, $itemQty){
    $query = "SELECT qty FROM items WHERE id='$itemId'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return ($itemQty - $row['qty']);
    }
}
?>