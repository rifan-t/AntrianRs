<?php
session_start();
include 'lib/koneksi.php';
$message = '';
$message_class = '';


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $password == $admin['password']) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username']; 
        header("Location: index.php");
        exit();
    } else {
        // Invalid login credentials
        $message = "Invalid username or password. Please try again.";
        $message_class = "text-red-500";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login Staff</h2>
        <form action="login.php" method="POST">
            <!-- Username Field -->
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium">Username</label>
                <input type="text" id="username" name="username" required class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input type="password" id="password" name="password" required class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                Login
            </button>
        </form>

     
    </div>

</body>
</html>
