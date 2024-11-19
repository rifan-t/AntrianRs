<?php 
require_once '../lib/koneksi.php';
$patient_id = $_GET['id'] ?? null;

if ($patient_id) {
    $stmt = $pdo->prepare("UPDATE antrian SET status = 'Selesai' WHERE id = :id");
    $stmt->execute(['id' => $patient_id]);

    header('Location: ../index.php');  
    exit;
} else {
    echo "Invalid patient ID.";
}



?>