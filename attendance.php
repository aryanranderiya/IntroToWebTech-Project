<?php
include 'config.php'; // Include your database connection file
if ($_COOKIE['user_role'] !== 'faculty') {
    // Redirect to the desired page
    header('Location: index.php');
    exit();
}

// Handle attendance submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendance_date = isset($_POST['attendance_date']) ? $_POST['attendance_date'] : null;
    $attendances = $_POST['attendance'] ?? [];

    // Validate attendance date and ensure at least one student is marked
    if ($attendance_date && count($attendances) > 0) {
        foreach ($attendances as $student_id => $status) {
            // Check if attendance for that date already exists
            $checkAttendanceQuery = "SELECT * FROM attendance WHERE student_id = ? AND attendance_date = ?";
            $stmtCheck = mysqli_prepare($conn, $checkAttendanceQuery);
            mysqli_stmt_bind_param($stmtCheck, "is", $student_id, $attendance_date);
            mysqli_stmt_execute($stmtCheck);
            $resultCheck = mysqli_stmt_get_result($stmtCheck);

            if (mysqli_num_rows($resultCheck) > 0) {
                // Update existing record
                $stmtUpdate = mysqli_prepare($conn, "UPDATE attendance SET status = ? WHERE student_id = ? AND attendance_date = ?");
                mysqli_stmt_bind_param($stmtUpdate, "sis", $status, $student_id, $attendance_date);
                mysqli_stmt_execute($stmtUpdate);
                mysqli_stmt_close($stmtUpdate);
            } else {
                // Insert new attendance record
                $stmtInsert = mysqli_prepare($conn, "INSERT INTO attendance (student_id, attendance_date, status) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmtInsert, "iss", $student_id, $attendance_date, $status);
                mysqli_stmt_execute($stmtInsert);
                mysqli_stmt_close($stmtInsert);
            }

            mysqli_stmt_close($stmtCheck);
        }
        echo "Attendance recorded successfully!";
    } else {
        echo "Please select a date and mark at least one student's attendance.";
    }
}

// Fetch students
$studentsQuery = "SELECT id, username FROM users WHERE role = 'student'";
$studentsResult = mysqli_query($conn, $studentsQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </noscript>
    <style>
        .attendance-button {
            transition: background-color 0.3s, color 0.3s;
        }

        .attendance-button:not(.selected) {
            background-color: #E5E7EB;
            /* Light gray when not selected */
            color: #1F2937;
            /* Dark gray text */
        }

        .attendance-button.selected {
            background-color: #10B981;
            /* Green for present */
            color: white;
            /* White text */
        }

        .attendance-button.absent.selected {
            background-color: #EF4444;
            /* Red for absent */
            color: white;
            /* White text */
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 max-h-screen overflow-hidden">
    <?php include 'navbar.php'; ?>

    <div class="mx-auto flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <main class="py-8 px-6 overflow-y-scroll max-h-[calc(100vh-70px)] h-full w-full flex flex-col gap-6">

            <h1 class="text-3xl font-bold mb-6">Attendance</h1>

            <div class="bg-gray-300 rounded-lg shadow p-6 mb-6">
                <form method="POST" id="attendanceForm">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-semibold" for="attendance_date">Attendance Date:</label>
                        <input type="date" name="attendance_date" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Student Name</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($studentsResult && mysqli_num_rows($studentsResult) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($studentsResult)): ?>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['username']) ?></td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="flex space-x-2">
                                                <button type="button" class="attendance-button size-[40px] rounded-full" onclick="selectAttendance(<?= $row['id'] ?>, 'Present')">P</button>
                                                <button type="button" class="attendance-button absent size-[40px] rounded-full" onclick="selectAttendance(<?= $row['id'] ?>, 'Absent')">A</button>
                                                <input type="hidden" name="attendance[<?= $row['id'] ?>]" id="attendance_<?= $row['id'] ?>" value="">
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class='border border-gray-300 px-4 py-2 text-center'>No students found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200 mt-4" type="submit">Save Changes</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        function selectAttendance(studentId, status) {
            const presentButton = document.querySelector(`button[onclick="selectAttendance(${studentId}, 'Present')"]`);
            const absentButton = document.querySelector(`button[onclick="selectAttendance(${studentId}, 'Absent')"]`);
            const hiddenInput = document.getElementById(`attendance_${studentId}`);

            // Reset buttons
            presentButton.classList.remove('selected');
            absentButton.classList.remove('selected');
            hiddenInput.value = '';

            // Select the appropriate button
            if (status === 'Present') {
                presentButton.classList.add('selected');
                hiddenInput.value = 'Present';
            } else {
                absentButton.classList.add('selected');
                hiddenInput.value = 'Absent';
            }
        }
    </script>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>