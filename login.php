<?php
include_once 'config.php';

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

<body class="bg-zinc-200 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm">
        <h1 class="text-2xl font-bold text-[#00bbff] mb-6 text-center">Login</h1>
        <?php if ($error_message): ?> <!-- Use $error_message instead of $loginError -->
            <p class="text-red-500 mb-4"><?= htmlspecialchars($error_message) ?></p> <!-- Display error message -->
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label class="block mb-2">Username</label>
            <input type="text" name="username" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
            <label class="block mb-2">Password</label>
            <input type="password" name="password" class="w-full p-2 mb-4 border border-gray-300 rounded" required>
            <button type="submit" class="w-full bg-[#00bbff] text-white p-2 rounded hover:bg-[#3bcaff]">Login</button>
        </form>
        <p class="mt-4 text-center">Don't have an account? <a href="signup.php" class="text-[#00bbff]">Sign up here</a></p>
    </div>
</body>

</html>