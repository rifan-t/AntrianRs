<?php
require_once '../lib/koneksi.php';
try {
    $stmt = $pdo->prepare("TRUNCATE TABLE antrian");
    $stmt->execute();

    header('Location: ../index.php');
    exit;
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>