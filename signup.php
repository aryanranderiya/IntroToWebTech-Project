<?php
include_once 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-200 flex items-center justify-center min-h-screen">
    <div class="p-8 rounded-2xl shadow-xl w-full max-w-sm bg-white">
        <h1 class="text-2xl font-bold text-[#00bbff] mb-6 text-center">Sign Up</h1>
        <?php if (isset($error_message)) { ?>
            <p class="text-red-500 mb-4"><?= htmlspecialchars($error_message) ?></p>
        <?php } ?>
        <form action="signup.php" method="POST" class="w-full">
            <label class="block mb-2">Username</label>
            <input type="text" name="username" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
            <label class="block mb-2">Email</label>
            <input type="email" name="email" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
            <label class="block mb-2">Password</label>
            <input type="password" name="password" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
            <button type="submit" class="w-full bg-[#00bbff] text-white p-2 rounded hover:bg-blue-700">Sign Up</button>
        </form>
        <p class="mt-4 text-center">Already have an account? <a href="login.php" class="text-[#00bbff]">Login here</a></p>
    </div>
</body>
</html>