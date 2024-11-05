    <?php
    include_once 'config.php';

    // Initialize variables
    $username = '';
    $user_role = '';

    // Check if the user_id cookie is set
    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];

        // Prepare and execute the SQL query to get the username and role
        $stmt = mysqli_prepare($conn, "SELECT username, role FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = htmlspecialchars($row['username']); // Store the username safely
            $user_role = $row['role']; // Store the user role
        }

        mysqli_stmt_close($stmt);
    }
    ?>

    <nav class="bg-[#00bbff] p-4 border-1 border-b border-white">
        <div class="mx-auto flex justify-between items-center">
            <a class="text-white text-2xl font-bold hover:underline" href="index.php">University Portal</a>

            <?php if ($username): ?> <!-- Check if username is set -->
                <span class="text-gray-700">Welcome, <?= $username ?>!</span>
                <a href="logout.php" class="text-gray-200 hover:text-white flex items-center font-semibold">
                    <span class="material-icons mr-1">logout</span> Logout
                </a>
            <?php else: ?>
                <div class="flex space-x-4">
                    <a href="login.php" class="text-gray-200 hover:text-white flex items-center font-semibold">
                        <span class="material-icons mr-1">login</span> Login
                    </a>
                    <a href="signup.php" class="text-[#00bbff] hover:bg-gray-200 flex items-center bg-white rounded-md p-2 font-semibold">
                        <span class="material-icons mr-1">person_add</span> Sign Up
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </nav>