<?php
require_once '../lib/koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_patient'])) {
    $patient_name = $_POST['patient_name'] ?? '';

    if ($patient_name) {
        $stmt = $pdo->prepare("SELECT MAX(nomor_antrian) AS max_antrian FROM antrian");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nomor_antrian = $row['max_antrian'] + 1; 
        $stmt = $pdo->prepare("INSERT INTO antrian (nama, nomor_antrian) VALUES (:patient_name, :nomor_antrian)");
        $stmt->execute(['patient_name' => $patient_name, 'nomor_antrian' => $nomor_antrian]);

        $message = "Pasien berhasil ditambahkan ke antrian dengan nomor antrian $nomor_antrian.";
        $message_class = "text-green-500";
        header("Location: ../index.php");
        exit();
    } else {
        $message = "Nama pasien tidak boleh kosong.";
        $message_class = "text-red-500";
    }
}
?>