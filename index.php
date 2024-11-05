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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </noscript>
</head>

<body class="bg-gray-100 text-gray-800 max-h-screen overflow-hidden">

    <!-- Navbar -->
    <nav class="bg-[#00bbff] p-4 border-1 border-b border-white">
        <div class="mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">University Portal</h1>

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

    <div class="mx-auto flex">
        <!-- Sidebar -->
        <aside class="w-fit pr-10 px-5 bg-[#00bbff] text-white h-screen p-4 space-y-4">
            <a href="attendance.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">check_circle</span>
                <?php if ($user_role === 'faculty'): ?>
                    Mark Attendance
                <?php else: ?>
                    View Attendance
                <?php endif; ?>
            </a>
            <a href="study-material.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">menu_book</span> Study Material
            </a>
            <a href="past-papers.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">history_edu</span> Past Papers
            </a>
            <a href="timetable.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">schedule</span> Timetable
            </a>
            <a href="curriculum.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">book</span> Curriculum
            </a>
            <a href="assignments.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">assignment</span> Assignments
            </a>
            <a href="library.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">local_library</span> Library
            </a>
        </aside>

        <main class="py-8 px-6 overflow-y-scroll max-h-[calc(100vh-70px)] h-full w-full flex flex-wrap gap-6">
            <!-- Attendance Section -->
            <section id="attendance" class="bg-white bg-zinc-200 p-6 rounded-lg max-w-[20vw] min-w-[20vw] w-[20vw] min-h-full">
                <h2 class="text-2xl font-bold mb-4"><?= $user_role === 'faculty' ? 'Mark Attendance' : 'View Attendance' ?></h2>
                <p><?= $user_role === 'faculty' ? 'Mark attendance for your classes.' : 'View your attendance records and history.' ?></p>
                <a href="attendance.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block">View</a>
            </section>

            <!-- Study Material Section -->
            <section id="study-material" class="bg-white bg-zinc-200 p-6 rounded-lg max-w-[20vw] min-w-[20vw] w-[20vw] min-h-full">
                <h2 class="text-2xl font-bold mb-4"><?= $user_role === 'faculty' ? 'Upload Study Material' : 'Access Study Material' ?></h2>
                <p><?= $user_role === 'faculty' ? 'Upload and manage study materials for your subjects.' : 'Access subject-wise study materials provided by your faculty.' ?></p>
                <a href="study-material.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block">View</a>
            </section>

            <!-- Past Papers Section -->
            <section id="past-papers" class="bg-white bg-zinc-200 p-6 rounded-lg max-w-[20vw] min-w-[20vw] w-[20vw] min-h-full">
                <h2 class="text-2xl font-bold mb-4"><?= $user_role === 'faculty' ? 'Manage Past Papers' : 'Explore Past Papers' ?></h2>
                <p><?= $user_role === 'faculty' ? 'Upload and manage past exam papers for your courses.' : 'Explore past exam papers for practice and review.' ?></p>
                <a href="past-papers.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block">View</a>
            </section>

            <!-- Timetable Section -->
            <section id="timetable" class="bg-white bg-zinc-200 p-6 rounded-lg max-w-[20vw] min-w-[20vw] w-[20vw] min-h-full">
                <h2 class="text-2xl font-bold mb-4"><?= $user_role === 'faculty' ? 'View Your Classes' : 'Check Your Timetable' ?></h2>
                <p><?= $user_role === 'faculty' ? 'View the schedule for your classes.' : 'Check your weekly schedule and upcoming classes.' ?></p>
                <a href="timetable.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block">View</a>
            </section>

            <!-- Curriculum Section -->
            <section id="curriculum" class="bg-white bg-zinc-200 p-6 rounded-lg max-w-[20vw] min-w-[20vw] w-[20vw] min-h-full">
                <h2 class="text-2xl font-bold mb-4"><?= $user_role === 'faculty' ? 'View Curriculum for Your Courses' : 'View Your Curriculum' ?></h2>
                <p><?= $user_role === 'faculty' ? 'Manage the curriculum for your courses and subjects.' : 'View your course curriculum and requirements.' ?></p>
                <a href="curriculum.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block">View</a>
            </section>

            <!-- Assignments Section -->
            <section id="assignments" class="bg-white bg-zinc-200 p-6 rounded-lg max-w-[20vw] min-w-[20vw] w-[20vw] min-h-full">
                <h2 class="text-2xl font-bold mb-4"><?= $user_role === 'faculty' ? 'Manage Assignments' : 'Assignments' ?></h2>
                <p><?= $user_role === 'faculty' ? 'Create and manage assignments for your classes.' : 'Access and submit your assignments.' ?></p>
                <a href="assignments.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block">View</a>
            </section>

            <!-- Library Section -->
            <section id="library" class="bg-white bg-zinc-200 p-6 rounded-lg max-w-[20vw] min-w-[20vw] w-[20vw] min-h-full">
                <h2 class="text-2xl font-bold mb-4"><?= $user_role === 'faculty' ? 'Manage Library Resources' : 'Library' ?></h2>
                <p><?= $user_role === 'faculty' ? 'Manage and update library resources for your students.' : 'Explore the university library resources.' ?></p>
                <a href="library.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block">View</a>
            </section>
        </main>

    </div>

</body>

</html>