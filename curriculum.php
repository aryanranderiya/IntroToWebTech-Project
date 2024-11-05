<?php
include './utils/config.php'; // Include your database connection file

// Create the curriculum table if it doesn't exist
$createTableQuery = "
CREATE TABLE IF NOT EXISTS curriculum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    faculty_name VARCHAR(255) NOT NULL,
    semester VARCHAR(50) NOT NULL,
    syllabus_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $createTableQuery)) {
    echo "Error creating table: " . mysqli_error($conn);
}

// Check user role (assuming the role is stored in session)
$user_role = $_COOKIE['user_role'] ?? 'student';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_role === 'faculty') {
    $subject_name = isset($_POST['subject_name']) ? $_POST['subject_name'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $faculty_name = isset($_POST['faculty_name']) ? $_POST['faculty_name'] : null;
    $semester = isset($_POST['semester']) ? $_POST['semester'] : null;
    $syllabus_url = isset($_POST['syllabus_url']) ? $_POST['syllabus_url'] : null;

    if ($subject_name && $description && $faculty_name && $semester && $syllabus_url) {
        $stmt = mysqli_prepare($conn, "INSERT INTO curriculum (subject_name, description, faculty_name, semester, syllabus_url) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $subject_name, $description, $faculty_name, $semester, $syllabus_url);

        if (mysqli_stmt_execute($stmt)) {
            echo "Curriculum added successfully!";
        } else {
            echo "Error adding curriculum: " . mysqli_error($conn);
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
    <title>Curriculum </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </noscript>
</head>

<body class="bg-gray-100 text-gray-800 max-h-screen overflow-hidden">
    <?php include './components/navbar.php'; ?>

    <div class="mx-auto flex">
        <!-- Sidebar -->
        <?php include './components/sidebar.php'; ?>

        <main class="py-8 px-6 overflow-y-scroll max-h-[calc(100vh-70px)] h-full w-full flex flex-col gap-6">

            <h1 class="text-3xl font-bold mb-6">Curriculum</h1>

            <?php if ($user_role === 'faculty'): ?>
                <h2 class="text-2xl">Add New Curriculum</h2>
                <div class="bg-gray-200 border border-1 border-zinc-300 rounded-lg shadow p-6 mb-6">
                    <form method="POST">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="subject_name">Subject Name:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="subject_name" placeholder="Enter subject name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="description">Description:</label>
                            <textarea class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="description" placeholder="Enter subject description" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="faculty_name">Faculty Name:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="faculty_name" placeholder="Enter faculty name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="semester">Semester:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="semester" placeholder="Enter semester" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="syllabus_url">Syllabus URL:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="syllabus_url" placeholder="Enter syllabus URL" required>
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200" type="submit">Add Curriculum</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php
            $curriculumQuery = "SELECT * FROM curriculum";
            $result = mysqli_query($conn, $curriculumQuery);
            ?>


            <div class="flex flex-row gap-4 flex-wrap">
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="bg-zinc-200 rounded-lg p-4 shadow flex flex-col w-[32%]">
                            <h3 class="font-bold text-lg"><?= htmlspecialchars($row['subject_name']) ?></h3>
                            <p class="text-sm text-gray-500">by <?= htmlspecialchars($row['faculty_name']) ?> | <?= htmlspecialchars($row['semester']) ?></p>
                            <p class="mt-2 text-gray-700"><?= htmlspecialchars($row['description']) ?></p>
                            <a href="<?= htmlspecialchars($row['syllabus_url']) ?>" class="mt-2 text-blue-600 hover:underline">View Syllabus</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-lg text-gray-700">No curriculum entries found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>