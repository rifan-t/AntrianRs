<?php

$host = 'localhost';  // Change this if using a remote database
$dbname = 'dbAntrianrs';
$username = 'root';   // Replace with your MySQL username
$password = '';       // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Handle errors
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>