<?php
include 'config.php'; // Include your database connection file

// Create the timetable table if it doesn't exist
$createTableQuery = "
CREATE TABLE IF NOT EXISTS timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(255) NOT NULL,
    faculty_name VARCHAR(255) NOT NULL,
    lecture_time TIME NOT NULL,
    semester VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $createTableQuery)) {
    echo "Error creating table: " . mysqli_error($conn);
}

// Check user role (assuming the role is stored in session or cookie)
$user_role = $_COOKIE['user_role'] ?? 'student';

// Handle form submission for adding timetable entries
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_role === 'faculty') {
    $subject_name = $_POST['subject_name'] ?? null;
    $faculty_name = $_POST['faculty_name'] ?? null;
    $lecture_time = $_POST['lecture_time'] ?? null;
    $semester = $_POST['semester'] ?? null;

    if ($subject_name && $faculty_name && $lecture_time && $semester) {
        $stmt = mysqli_prepare($conn, "INSERT INTO timetable (subject_name, faculty_name, lecture_time, semester) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $subject_name, $faculty_name, $lecture_time, $semester);

        if (mysqli_stmt_execute($stmt)) {
            echo "Timetable entry added successfully!";
        } else {
            echo "Error adding timetable entry: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </noscript>
</head>

<body class="bg-gray-100 text-gray-800 max-h-screen overflow-hidden">
    <?php include 'navbar.php'; ?>

    <div class="mx-auto flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <main class="py-8 px-6 overflow-y-scroll max-h-[calc(100vh-70px)] h-full w-full flex flex-col gap-6">

            <h1 class="text-3xl font-bold mb-6">Timetable</h1>

            <?php if ($user_role === 'faculty'): ?>
                <h2 class="text-2xl">Add New Timetable Entry</h2>
                <div class="bg-gray-300 rounded-lg shadow p-6 mb-6">
                    <form method="POST">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="subject_name">Subject Name:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="subject_name" placeholder="Enter subject name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="faculty_name">Faculty Name:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="faculty_name" placeholder="Enter faculty name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="lecture_time">Lecture Time:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="time" name="lecture_time" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="semester">Semester:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="semester" placeholder="Enter semester" required>
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200" type="submit">Add Timetable Entry</button>
                    </form>
                </div>
            <?php endif; ?>


            <div class="overflow-x-auto overflow-y-visible">
                <table class="min-w-full bg-white border-gray-400 border-[1px]">
                    <thead>
                        <tr>
                            <th class="border-gray-400 border-[1px] px-4 py-2">Subject Name</th>
                            <th class="border-gray-400 border-[1px] px-4 py-2">Faculty Name</th>
                            <th class="border-gray-400 border-[1px] px-4 py-2">Lecture Time</th>
                            <th class="border-gray-400 border-[1px] px-4 py-2">Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $timetableQuery = "SELECT * FROM timetable";
                        $result = mysqli_query($conn, $timetableQuery);

                        if ($result && mysqli_num_rows($result) > 0):
                            while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="border-gray-400 border-[1px] px-4 py-2"><?= htmlspecialchars($row['subject_name']) ?></td>
                                    <td class="border-gray-400 border-[1px] px-4 py-2"><?= htmlspecialchars($row['faculty_name']) ?></td>
                                    <td class="border-gray-400 border-[1px] px-4 py-2"><?= htmlspecialchars($row['lecture_time']) ?></td>
                                    <td class="border-gray-400 border-[1px] px-4 py-2"><?= htmlspecialchars($row['semester']) ?></td>
                                </tr>
                            <?php endwhile;
                        else: ?>
                            <tr>
                                <td colspan="4" class="border-gray-400 border-[1px] px-4 py-2 text-center">No timetable entries found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>