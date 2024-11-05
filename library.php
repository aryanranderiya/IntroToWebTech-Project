<?php
include 'config.php'; // Include your database connection file

// Check user role (assuming the role is stored in session)
$user_role = $_COOKIE['user_role'] ?? 'student';

// Create the books table if it doesn't exist
$createTableQuery = "
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $createTableQuery)) {
    echo "Error creating table: " . mysqli_error($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_role === 'faculty') {
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $author = isset($_POST['author']) ? $_POST['author'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : null;

    // Check if all fields are filled
    if ($title && $author && $description && $image_url) {
        // Insert the book details into the database
        $stmt = mysqli_prepare($conn, "INSERT INTO books (title, author, description, image_url) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $title, $author, $description, $image_url);

        if (mysqli_stmt_execute($stmt)) {
            echo "Book added successfully!";
        } else {
            echo "Error adding book: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}

// Fetch all books from the database with search functionality
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
$booksQuery = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
$stmt = mysqli_prepare($conn, $booksQuery);
$searchWildcard = '%' . $searchTerm . '%';
mysqli_stmt_bind_param($stmt, "ss", $searchWildcard, $searchWildcard);
mysqli_stmt_execute($stmt);
$booksResult = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
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

            <h1 class="text-3xl font-bold mb-6">Library</h1>

            <?php if ($user_role === 'faculty'): ?>
                <h2 class="text-2xl">Add New Book</h2>
                <div class="bg-gray-200 border border-1 border-zinc-300 rounded-lg shadow p-6 mb-6">
                    <form method="POST">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="title">Title:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="title" placeholder="Enter book title" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="author">Author:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="author" placeholder="Enter author's name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="description">Description:</label>
                            <textarea class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name="description" placeholder="Enter book description" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold" for="image_url">Image URL:</label>
                            <input class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="image_url" placeholder="Enter image URL" required>
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200" type="submit">Add Book</button>
                    </form>
                </div>
            <?php endif; ?>


            <form method="POST" class="mb-4 flex items-center">
                <input type="text" name="search" placeholder="Search books by title or author" class="border rounded-full rounded-r-none pl-4 w-full bg-gray-200 border border-2 border-gray-300 border-r-transparent p-2 focus:outline-none focus:ring-2 h-[45px] focus:ring-blue-500" value="<?= htmlspecialchars($searchTerm) ?>">
                <button class=" text-white px-4 py-2 h-[45px] rounded transition duration-200 bg-[#00bbff] rounded-l-none rounded-r-full flex items-center justify-center" type="submit">
                    <span class="material-icons">search</span>
                </button>
            </form>

            <div class="flex flex-col gap-2">
                <?php if ($booksResult && mysqli_num_rows($booksResult) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($booksResult)): ?>
                        <div class="bg-white rounded-lg overflow-hidden flex items-center">
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="w-24 rounded-lg h-24 object-cover">
                            <div class="px-4">
                                <h3 class="font-bold text-lg"><?= htmlspecialchars($row['title']) ?></h3>
                                <p class="text-sm text-gray-500">by <?= htmlspecialchars($row['author']) ?></p>
                                <p class="mt-2 text-gray-700"><?= htmlspecialchars($row['description']) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-lg text-gray-700">No books found for your search.</p>
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