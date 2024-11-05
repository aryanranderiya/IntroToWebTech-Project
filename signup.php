<?php
include_once 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to include the role
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'student')";

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

<body class="bg-gradient-to-b from-white to-[#00bbff] flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-xl shadow-2xl w-full max-w-md">
        <h1 class="text-3xl font-bold text-[#00bbff] mb-1 text-center">Create an Account</h1>
        <p class="text-sm text-gray-600 mb-8 text-center">Sign up for a new account</p>

        <?php if (isset($error_message)): ?>
            <p class="text-red-500 mb-4 text-center"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form action="signup.php" method="POST" class="space-y-6">
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-600">Username</label>
                <input type="text" name="username" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-[#00bbff] focus:border-[#00bbff]" placeholder="Enter your username" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-600">Email</label>
                <input type="email" name="email" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-[#00bbff] focus:border-[#00bbff]" placeholder="Enter your email" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-600">Password</label>
                <input type="password" name="password" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-[#00bbff] focus:border-[#00bbff]" placeholder="Create a password" required>
            </div>
            <button type="submit" class="w-full bg-[#00bbff] text-white py-3 rounded-lg font-semibold text-lg hover:bg-[#3bcaff] transition-colors duration-300">Sign Up</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">Already have an account?
            <a href="login.php" class="text-[#00bbff] font-semibold hover:underline">Login here</a>
        </p>
    </div>

</body>

</html>