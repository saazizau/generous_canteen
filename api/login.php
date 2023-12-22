<?php
session_start();

include "database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$request_method = $_SERVER["REQUEST_METHOD"];

$username = isset($_GET['username']) ? $_GET['username'] : '';
$password = isset($_GET['password']) ? $_GET['password'] : '';
$level = isset($_GET['level']) ? $_GET['level'] : '';

// Query untuk memeriksa keberadaan username dan password dalam tabel pengguna
$query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND level=$level";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Login berhasil
    $data = $result->fetch_assoc();
    $username = $data['username'];
    $level = $data['level'];
    $nama = $data['name'];
    $id = $data['id'];

    $_SESSION['username'] = $username;
    $_SESSION['level'] = $level;
    $_SESSION['name'] = $nama;
    $_SESSION['id'] = $id;


    
    $response = array('status' => 'success', 'message'=>'Login successful', 'username' => $username, 'level'=>$level);
} else {
    // Login gagal
    $response = array('status' => 'error', 'message'=>'Invalid username or password', 'username' => NULL, 'level'=>NULL);
}

echo json_encode($response);
?>
