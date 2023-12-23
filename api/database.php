<?php 
	define('HOST', '103.145.226.150');
	define('USER', 'sabrinaa_aa');
	define('PASS', 'Hesoyam364');
	define('DB', 'sabrinaa_KWUMCC');

	$conn = new mysqli(HOST, USER, PASS, DB);

    if($conn->connect_error){
        die ("Connection failed... " . $conn->connect_error);
    }
?>