<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password is empty for XAMPP
$database = "university_portal";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if (!mysqli_query($conn, $sql)) {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}
// else {
// echo "Database created successfully<br>";
// }

// Close the initial connection
mysqli_close($conn);

// Reconnect to the newly created database
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection to the database
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL to create the users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('faculty', 'student') DEFAULT 'student', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute the query to create the table
if (!mysqli_query($conn, $sql)) {
    echo "Error creating users table: " . mysqli_error($conn) . "<br>";
}
// else {
//  echo "Users table created successfully<br>";
// }

// Close the connection
// mysqli_close($conn);
