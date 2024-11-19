<?php
require_once 'lib/koneksi.php';
session_start();
if(empty($_SESSION['user_id'])){
    include 'login.php';
}else{
   
    $stmt = $pdo->prepare("SELECT * FROM antrian ORDER BY nomor_antrian asc");
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
$data_antrian = $stmt->rowCount();  // Corrected from num_row()

$stmt_waiting = $pdo->prepare("SELECT COUNT(*) FROM antrian WHERE status = 'menunggu'");
$stmt_waiting->execute();
$waiting = $stmt_waiting->fetchColumn();

$stmt_finished = $pdo->prepare("SELECT COUNT(*) FROM antrian WHERE status = 'selesai'");
$stmt_finished->execute();
$finished = $stmt_finished->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Antrian (Queue)</title>
    <script src="https://cdn.tailwindcss.com"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

</head>
<body class="bg-gray-100">


<div class="max-w-4xl mx-auto p-6 mt-10 bg-white shadow-md rounded-lg">
        <h2 class="text-3xl font-semibold mb-4">Manage Antrian</h2>

      

        <!-- Add new patient form -->
        <form method="POST" action="modul/tambah_antrian.php">
            <div class="flex mb-4">
                <input type="text" name="patient_name" placeholder="Enter patient name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <button type="submit" name="add_patient" class="ml-2 bg-indigo-600 text-white py-3 px-6 rounded-md">Add Patient</button>
            </div>
        </form>

        <div class="flex">
        <h3 class="ml-2 font-bold bg-blue-600 text-white py-2 px-3 rounded-md uppercase">
            Total Antrian <br>
            <span><?= $data_antrian?></span>
        </h3>
        <h3 class="ml-2 font-bold bg-blue-600 text-white py-2 px-3 rounded-md uppercase">
            Antrian Selesai <br>
            <span><?= $finished?></span>
        </h3>
        <h3 class="ml-2 font-bold bg-blue-600 text-white py-2 px-3 rounded-md uppercase">
            Antrian Menunggu <br>
            <span><?= $waiting?></span>
        </h3>
        <a href="modul/hapus_antrian.php" 
           class="ml-auto bg-red-600 text-white py-2 px-3 text-center rounded-md uppercase"
           onclick="yakiin(event)">
            Hapus Semua Data Antrian
        </a>

        </div>
        <!-- Display current queue with DataTables -->
        <h3 class="text-xl font-semibold mb-4">Current Waiting Queue</h3>
        
        <!-- DataTable for displaying patients -->
        <table id="patientsTable" class="display w-full">
            <thead>
                <tr class="border-b">
                    <th class="py-2 text-left">Patient Name</th>
                    <th class="py-2 text-left">Status</th>
                    <th class="py-2 text-left">Nomor Antrian</th>
                    <th class="py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr class="border-b">
                        <td class="py-2"><?php echo htmlspecialchars($patient['nama']); ?></td>
                        <td class="py-2"><?php echo htmlspecialchars($patient['status']); ?></td>
                        <td class="py-2"><?php echo htmlspecialchars($patient['nomor_antrian']); ?></td>
                        <td class="py-2">
                            <?php if ($patient['status'] === 'menunggu'): ?>
                                <a href="modul/update_antrian.php?id=<?php echo $patient['id']; ?>" class="text-green-600 hover:text-green-800">Tandai Selesai</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    
    <script>
// Fungsi Konfirmasi Penghapusan
function yakiin(event) {
    // Mencegah link melakukan aksi default
    event.preventDefault();
    
    // Menampilkan konfirmasi
    const confirmed = confirm('Apakah Anda yakin ingin menghapus semua data antrian?');
    
    // Jika dikonfirmasi, lanjutkan aksi (misalnya mengirim form atau AJAX request)
    if (confirmed) {
        // Gantikan ini dengan aksi yang sesuai, misalnya AJAX untuk menghapus data
        alert('Semua data antrian telah dihapus!');
        // Jika menggunakan form, Anda bisa redirect atau submit form di sini
        window.location.href = 'modul/hapus_antrian.php';
    }
}
</script>
</body>
</html>
<?php }?>