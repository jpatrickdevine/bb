<?php # _includes/mysqli-connect.php

// This file sets up the database connection

// Define db config as constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'bistrobistro');
define('DB_USER', 'bb');
define('DB_PASS', '');

// Establish connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection and establish encoding
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
} else {
    $mysqli->set_charset('utf8');
}
?>