<?php
include './utils/config.php'; // Include your database connection file

// Check if the user is faculty
$isFaculty = $_COOKIE['user_role'] === 'faculty';

// Check if the study_materials table exists, and create it if it doesn't
$tableCheckQuery = "
CREATE TABLE IF NOT EXISTS study_materials (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path TEXT NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

if (!mysqli_query($conn, $tableCheckQuery)) {
    echo "Error creating table: " . mysqli_error($conn);
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['study_material'])) {
    // File upload handling code remains unchanged
}

// Fetch uploaded study materials with search functionality
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    $searchQuery = "WHERE file_name LIKE '%$searchTerm%'";
}

$materialsQuery = "SELECT * FROM study_materials $searchQuery ORDER BY upload_date DESC";
$materialsResult = mysqli_query($conn, $materialsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Material Management</title>
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
        <main class="py-8 px-6 overflow-y-scroll max-h-[calc(100vh-70px)] h-full w-full flex flex-col gap-6">
            <h1 class="text-3xl font-bold mb-6">

                <?php if ($isFaculty): ?>
                    Upload
                <?php endif; ?>

                Study Material</h1>

            <?php if ($isFaculty): // Only show the upload form for faculty 
            ?>
                <form method="POST" enctype="multipart/form-data" class="mb-8">
                    <input type="file" name="study_material[]" class="border rounded p-2" multiple required>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Upload</button>
                </form>
            <?php endif; ?>

            <form method="GET" class="mb-4 flex items-center">
                <input type="text" name="search" placeholder="Search books by title or author" class="border rounded-full rounded-r-none pl-4 w-full bg-gray-200 border border-2 border-gray-300 border-r-transparent p-2 focus:outline-none focus:ring-2 h-[45px] focus:ring-blue-500">
                <button class=" text-white px-4 py-2 h-[45px] rounded transition duration-200 bg-[#00bbff] rounded-l-none rounded-r-full flex items-center justify-center" type="submit">
                    <span class="material-icons">search</span>
                </button>
            </form>

            <h2 class="text-2xl font-bold mb-4">Uploaded Study Materials</h2>

            <table class="min-w-full border-collapse border border-gray-200 bg-white">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">File Name</th>
                        <th class="border border-gray-300 px-4 py-2">Upload Date</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($materialsResult && mysqli_num_rows($materialsResult) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($materialsResult)): ?>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['file_name']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['upload_date']) ?></td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank" class="text-blue-500 hover:underline">View</a>
                                    <form method="POST" action="./utils/delete_studymaterial.php" class="inline">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="border border-gray-300 px-4 py-2 text-center">No study materials found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>

</html>