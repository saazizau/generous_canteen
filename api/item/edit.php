<?php
session_start();

include "../database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$xx = "set";

$itemId = isset($_REQUEST['id']) ? $_REQUEST['id'] : NULL;
$itemName = isset($_REQUEST['name']) ? $_REQUEST['name'] : NULL;
$itemPrice = isset($_REQUEST['price']) ? $_REQUEST['price'] : NULL;
$itemPurchase = isset($_REQUEST['purchase']) ? $_REQUEST['purchase'] : NULL;
$itemQty = isset($_REQUEST['qty']) ? $_REQUEST['qty'] : NULL;
$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : NULL;
$idUser = isset($_SESSION['id']) ? $_SESSION['id'] : NULL;

$date2 = new DateTime($date);
$date1 = new DateTime(date('Y-m-d'));

// Calculate the difference between the two dates
$interval = $date1->diff($date2);

// Check if the difference is positive or negative
$cekDate = !$interval->invert;

$response = array(
    "status" => 'Undefined',
    "track" => [],
    "massage" => 'Parameter Not ALL Setted'
);

// Mengecek apakah semua variabel sudah diisi
if(isset($idUser) && isset($itemId) && isset($itemName) && isset($itemPrice) && isset($itemPurchase) && isset($itemQty) && isset($date)){
    $response['track'] = array_merge($response['track'], array("All Paramaters Setted"));
    $qtyDif = getQtyDif($conn, $itemId, $itemQty, $cekDate);

    $supplyID = array(getSupplyId($conn, $date)[0],getSupplyId($conn, $date)[1]);
    
    $salesID = array(getSalesId($conn, $date)[0],getSalesId($conn, $date)[1]);
    if(updateItem($conn, $itemId, $itemName, $itemQty, $itemPrice, $itemPurchase)){
        $response['track'] = array_merge($response['track'], array("Succeed Update item $itemName to database"));
        if(($qtyDif > 0)){
            $response['track'] = array_merge($response['track'], array("Entered Supply Section"));
            if($supplyID[0]){
                $response['track'] = array_merge($response['track'], array("Entered Update Supply"));
                if(updateSupply($conn, $supplyID[1], $itemPurchase, $qtyDif)){
    
                    $response['track'] = array_merge($response['track'], array("Succeed update suppply with $supplyID[1] to database"));
                    $response['massage'] = insertSupplyDetail($conn, $supplyID[1], $itemId, $itemPurchase, $qtyDif, $idUser) ? "Berhasil Menyimpan Data" : "Gagal Menyimpan Data Supply Detail";
                    $response['status'] = "success";
                    
                } else {
                    $response['massage'] = "Gagal Update Supply";
                    $response['status'] = "error";
                }
            } else {
                if(insertSupply($conn, $supplyID[1], $date, $itemPurchase, $idUser, $qtyDif)){
                
                    $response['track'] = array_merge($response['track'], array("Succeed insert $supplyID[1] to database"));
                    $response['massage'] = insertSupplyDetail($conn, $supplyID[1], $itemId, $itemPurchase, $qtyDif, $idUser) ? "Berhasil Menyimpan Data" : "Gagal Menyimpan Data Supply Detail";
                    $response['status'] = "success";
                
                } else {
                    $response['massage'] = "Gagal Insert Supply";
                    $response['status'] = "error";
                } 
            } 
        } else if(($qtyDif < 0)) {
            $qtyDif = $qtyDif*(-1);
            $response['track'] = array_merge($response['track'], array("Entered Sales Section"));
            if($salesID[0]){
                $response['track'] = array_merge($response['track'], array("Entered Update Sales"));
                if(updateSales($conn, $salesID[1], $itemPrice, $qtyDif)){
    
                    $response['track'] = array_merge($response['track'], array("Succeed update sales with $salesID[1] to database"));
                    $response['massage'] = insertSalesDetail($conn, $salesID[1], $itemId, $itemPrice, $qtyDif, $itemQty, $idUser) ? "Berhasil Menyimpan Data" : "Gagal Menyimpan Data Sales Detail";
                    $response['status'] = "success";
                    
                } else {
                    $response['massage'] = "Gagal Update Sales";
                    $response['status'] = "error";
                }
            } else {
                if(insertSales($conn, $salesID[1], $date, $itemPrice, $idUser, $qtyDif)){
                
                    $response['track'] = array_merge($response['track'], array("Succeed insert $salesID[1] to database"));
                    $response['massage'] = insertSalesDetail($conn, $salesID[1], $itemId, $itemPrice, $qtyDif, $itemQty, $idUser) ? "Berhasil Menyimpan Data" : "Gagal Menyimpan Data Sales Detail";
                    $response['status'] = "success";
                
                } else {
                    $response['massage'] = "Gagal Insert Sales";
                    $response['status'] = "error";
                } 
            }
        } else {
            $response['massage'] = "Berhasil Menyimpan Perubahan Data";
            $response['status'] = "success";             
        }        
    } else {
        $response['massage'] = "Gagal Insert Item";
        $response['status'] = "error";;
    }  
} else {
    $response['massage'] = "Parameter Not Completed";
    $response['status'] = "error"; 
}

echo json_encode($response);


// Insert Item
function insertItem($conn, $itemId, $itemName, $itemQty, $itemPrice, $itemPurchase){
    $query = "INSERT INTO items (id, name, qty, price, purchase) VALUES ('$itemId', '$itemName', '$itemQty', '$itemPrice', $itemPurchase)";
    return (($conn->query($query)) === TRUE);    
}

// Update Item 
function updateItem($conn, $itemId, $itemName, $itemQty, $itemPrice){
    $query = "UPDATE items SET name='$itemName', qty='$itemQty', price='$itemPrice' WHERE id='$itemId'";
    return (($conn->query($query)) === TRUE);    
}

// Insert Sales
function insertSales($conn, $salesId, $date, $price, $idUser, $itemQty){
    $query = "INSERT INTO sales_report (id_sales, date, price, id_officer) VALUES ('$salesId', '$date', ($price*$itemQty), $idUser)";
    return (($conn->query($query)) === TRUE);
}

// Update Sales
function updateSales($conn, $salesId, $itemPrice, $itemQty){
    $query = "UPDATE sales_report SET price = (price + ($itemPrice * $itemQty)) WHERE id_sales = '$salesId'";
    return (($conn->query($query)) === TRUE);
}

// Insert Sales Detail
function insertSalesDetail($conn, $salesId, $itemId, $itemPrice, $qtyDif, $itemQty,$idUser){
    $detailId = getSalesDetailId($conn, $salesId);
    $query = "INSERT INTO sales_report_details (id_sales_details, id_sales, id_items, item_sold ,number) VALUES ('$detailId', '$salesId','$itemId', $qtyDif, $itemQty)";
    return (($conn->query($query)) === TRUE);
}

// Get Sales ID
function getSalesId($conn, $date){
    $query = "SELECT id_sales FROM sales_report WHERE date='$date'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return array(TRUE, $row['id_sales']);
    } else {
        $query = "SELECT id_sales FROM sales_report ORDER BY id_sales DESC";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return array(FALSE, $row['id_sales']+1);
        }
    }
}

// Get Sales Detail Id
function getSalesDetailId($conn, $id_sales){
    $query = "SELECT id_sales_details FROM sales_report_details ORDER BY id_sales_details DESC";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id_sales_details']+1;
    } else {
        return 0;
    }

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
function getQtyDif($conn, $itemId, $itemQty, $cekDate){
    $query = "SELECT qty FROM items WHERE id='$itemId'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $result = $cekDate ? ((int)$itemQty - (int)$row['qty']) : ((int)$row['qty'] - (int)$itemQty);
        return $result;
    }
}
?>