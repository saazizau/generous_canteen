<?php 
	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASS', '');
	define('DB', 'sabrinaa_KWUMCC');

	$conn = new mysqli(HOST, USER, PASS, DB);

    if($conn->connect_error){
        die ("Connection failed... " . $conn->connect_error);
    }
?>