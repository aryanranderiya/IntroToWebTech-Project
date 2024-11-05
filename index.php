<?php
include_once './utils/config.php';

$username = '';
$user_role = '';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];

    $stmt = mysqli_prepare($conn, "SELECT username, role FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = htmlspecialchars($row['username']);
        $user_role = $row['role'];
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

    <?php include './components/navbar.php'; ?>

    <div class="mx-auto flex">

        <?php include './components/sidebar.php'; ?>
        <main class="py-8 px-6 overflow-y-scroll max-h-[calc(100vh-70px)] h-full w-full flex flex-wrap gap-6 bg-zinc-100">

            <?php if ($user_role === 'faculty'): ?>
                <section id="attendance" class="bg-white  rounded-2xl shadow-lg max-w-[25vw] min-w-[25vw] w-[25vw] min-h-full flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">

                    <img src="./assets/attendance.png" alt="Attendance" class="rounded-t-lg w-full max-h-[200px] h-[200px] object-cover object-top ">

                    <div class="p-6 flex flex-col justify-between h-full">
                        <div>
                            <h2 class="text-2xl font-bold mb-4 flex items-center">
                                <span class="material-icons mr-2">check_circle</span>
                                <?= $user_role === 'faculty' ? 'Mark Attendance' : 'View Attendance' ?>
                            </h2>
                            <p><?= $user_role === 'faculty' ? 'Mark attendance for your classes.' : 'View your attendance records and history.' ?></p>
                        </div>
                        <a href="attendance.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block self-end transition-colors duration-300">View</a>
                    </div>
                </section>
            <?php endif; ?>

            <section id="study-material" class="bg-white  rounded-2xl shadow-lg max-w-[25vw] min-w-[25vw] w-[25vw] min-h-full flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">

                <img src="./assets/material.jpg" alt="Study Material" class="rounded-t-lg w-full max-h-[200px] min-h-[200px]  object-cover object-top ">

                <div class="p-6 flex flex-col justify-between h-full">
                    <div>
                        <h2 class="text-2xl font-bold mb-4 flex items-center">
                            <span class="material-icons mr-2">school</span>
                            <?= $user_role === 'faculty' ? 'Upload Study Material' : 'Access Study Material' ?>
                        </h2>
                        <p><?= $user_role === 'faculty' ? 'Upload and manage study materials for your subjects.' : 'Access subject-wise study materials provided by your faculty.' ?></p>
                    </div>
                    <a href="study-material.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block self-end transition-colors duration-300">View</a>
                </div>
            </section>

            <section id="timetable" class="bg-white  rounded-2xl shadow-lg max-w-[25vw] min-w-[25vw] w-[25vw] min-h-full flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">

                <img src="./assets/timetable.jpg" class="rounded-t-lg w-full h-[200px] object-cover object-top ">

                <div class="p-6 flex flex-col justify-between h-full">
                    <div>
                        <h2 class="text-2xl font-bold mb-4 flex items-center">
                            <span class="material-icons mr-2">schedule</span>
                            <?= $user_role === 'faculty' ? 'View Your Classes' : 'Check Your Timetable' ?>
                        </h2>
                        <p><?= $user_role === 'faculty' ? 'View the schedule for your classes.' : 'Check your weekly schedule and upcoming classes.' ?></p>
                    </div>
                    <a href="timetable.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block self-end transition-colors duration-300">View</a>
                </div>
            </section>

            <section id="curriculum" class="bg-white  rounded-2xl shadow-lg max-w-[25vw] min-w-[25vw] w-[25vw] min-h-full flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">

                <img src="./assets/material.jpg" alt="Curriculum" class="rounded-t-lg w-full h-[200px] min-h-[200px] object-cover object-top ">

                <div class="p-6 flex flex-col justify-between h-full">
                    <div>
                        <h2 class="text-2xl font-bold mb-4 flex items-center">
                            <span class="material-icons mr-2">book</span>
                            <?= $user_role === 'faculty' ? 'View Curriculum for Your Courses' : 'View Your Curriculum' ?>
                        </h2>
                        <p><?= $user_role === 'faculty' ? 'Manage the curriculum for your courses and subjects.' : 'View your course curriculum and requirements.' ?></p>
                    </div>
                    <a href="curriculum.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block self-end transition-colors duration-300">View</a>
                </div>
            </section>

            <section id="library" class="bg-white  rounded-2xl shadow-lg max-w-[25vw] min-w-[25vw] w-[25vw] min-h-full flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">

                <img src="./assets/library.jpg" alt="Library" class="rounded-t-lg w-full h-[200px] min-h-[200px] object-cover object-top ">

                <div class="p-6 flex flex-col justify-between h-full">
                    <div>
                        <h2 class="text-2xl font-bold mb-4 flex items-center">
                            <span class="material-icons mr-2">library_books</span>
                            <?= $user_role === 'faculty' ? 'Manage Library Resources' : 'Library' ?>
                        </h2>
                        <p><?= $user_role === 'faculty' ? 'Manage and update library resources for your students.' : 'Explore the university library resources.' ?></p>
                    </div>
                    <a href="library.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-[#3bcaff] inline-block self-end transition-colors duration-300">View</a>
                </div>
            </section>
        </main>

    </div>
</body>

</html>