<?php
include_once './utils/config.php';

$error_message = ''; // Initialize the error message variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and execute the SQL query
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Login successful, set a cookie and redirect to the portal
            setcookie("user_id", $row["id"], time() + (86400 * 30), "/"); // Cookie expires in 30 days\
            setcookie("user_role",  $row['role'], time() + (86400 * 30), "/");

            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid username or password."; // Set the error message
        }
    } else {
        $error_message = "Invalid username or password."; // Set the error message
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-white to-[#00bbff] flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-xl shadow-2xl w-full max-w-md">
        <h1 class="text-3xl font-bold text-[#00bbff] mb-1 text-center">Welcome Back</h1>
        <p class="text-sm text-gray-600 mb-8 text-center">Please login to your account</p>

        <?php if ($error_message): ?>
            <p class="text-red-500 mb-4 text-center"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-6">
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-600">Username</label>
                <input type="text" name="username" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-[#00bbff] focus:border-[#00bbff]" placeholder="Enter your username" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-600">Password</label>
                <input type="password" name="password" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-[#00bbff] focus:border-[#00bbff]" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="w-full bg-[#00bbff] text-white py-3 rounded-lg font-semibold text-lg hover:bg-[#3bcaff] transition-colors duration-300">Login</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">Don't have an account?
            <a href="signup.php" class="text-[#00bbff] font-semibold hover:underline">Sign up here</a>
        </p>
    </div>
</body>

</html>