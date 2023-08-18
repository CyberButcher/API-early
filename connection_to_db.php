<?php
$user = "";
$pass = "";
$host = "";
$db_name = "";

// Connect to the database
try {
    $conn = new PDO("mysql:host=$host;charset=utf8mb4;dbname=$db_name", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(array("error" => $e->getMessage()));
    exit;
}