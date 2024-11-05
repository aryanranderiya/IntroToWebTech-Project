<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal</title>
      <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800 max-h-screen overflow-hidden">

    <!-- Navbar -->
    <nav class="bg-[#00bbff] p-4 border-1 border-b border-white">
        <div class="mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">University Portal</h1>
            <div class="flex space-x-4">
                <a href="login.php" class="text-gray-200 hover:text-white flex items-center  font-semibold">
                    <span class="material-icons mr-1">login</span> Login
                </a>
                <a href="signup.php" class="text-[#00bbff] hover:bg-gray-200 flex items-center bg-white rounded-md  p-2 font-semibold">
                    <span class="material-icons mr-1">person_add</span> Sign Up
                </a>
            </div>
        </div>
    </nav>

    <div class=" mx-auto flex">
        <!-- Sidebar -->
        <aside class="w-fit pr-10 px-5 bg-[#00bbff] text-white h-screen p-4 space-y-4">
            <a href="attendance.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">check_circle</span> Attendance
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
            <a href="performance.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">insights</span> Performance
            </a>
            <a href="assignments.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">assignment</span> Assignments
            </a>
            <a href="library.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
                <span class="material-icons mr-2">local_library</span> Library
            </a>
        </aside>

        <!-- Main Content -->
        <main class="py-8 px-6 overflow-y-scroll max-h-[calc(100vh-70px)] h-full w-full flex flex-wrap gap-6">
            <!-- Attendance Section -->
            <section id="attendance" class="bg-white bg-zinc-200 p-6 rounded-lg max-w-[20vw] min-w-[20vw] w-[20vw] h-full">
                <h2 class="text-2xl font-bold mb-4">Attendance</h2>
                <p>View your attendance records and history.</p>
                <a href="attendance.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-blue-700 inline-block">View</a>
            </section>

            <!-- Study Material Section -->
            <section id="study-material" class="bg-white bg-zinc-200 p-6 rounded-lg  max-w-[20vw] min-w-[20vw] w-[20vw]  h-full">
                <h2 class="text-2xl font-bold mb-4">Study Material</h2>
                <p>Access subject-wise study materials.</p>
                <a href="study-material.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-blue-700 inline-block">View</a>
            </section>

            <!-- Past Papers Section -->
            <section id="past-papers" class="bg-white bg-zinc-200 p-6 rounded-lg  max-w-[20vw] min-w-[20vw] w-[20vw]  h-full">
                <h2 class="text-2xl font-bold mb-4">Past Papers</h2>
                <p>Explore past exam papers for practice and review.</p>
                <a href="past-papers.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-blue-700 inline-block">View</a>
            </section>

            <!-- Timetable Section -->
            <section id="timetable" class="bg-white bg-zinc-200 p-6 rounded-lg  max-w-[20vw] min-w-[20vw] w-[20vw]  h-full">
                <h2 class="text-2xl font-bold mb-4">Student Timetable</h2>
                <p>Check your weekly schedule and upcoming classes.</p>
                <a href="timetable.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-blue-700 inline-block">View</a>
            </section>

            <!-- Curriculum Section -->
            <section id="curriculum" class="bg-white bg-zinc-200 p-6 rounded-lg  max-w-[20vw] min-w-[20vw] w-[20vw]  h-full">
                <h2 class="text-2xl font-bold mb-4">Curriculum</h2>
                <p>View your course curriculum and requirements.</p>
                <a href="curriculum.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-blue-700 inline-block">View</a>
            </section>

            <!-- Performance Tracking Section -->
            <section id="performance" class="bg-white bg-zinc-200 p-6 rounded-lg  max-w-[20vw] min-w-[20vw] w-[20vw]  h-full">
                <h2 class="text-2xl font-bold mb-4">Performance Tracking</h2>
                <p>Track your grades and view a performance dashboard.</p>
                <ul class="list-disc list-inside ml-6">
                    <li>Grade History</li>
                    <li>Grades Dashboard</li>
                </ul>
                <a href="performance.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-blue-700 inline-block">View</a>
            </section>

            <!-- Assignment Submission Section -->
            <section id="assignments" class="bg-white bg-zinc-200 p-6 rounded-lg  max-w-[20vw] min-w-[20vw] w-[20vw]  h-full">
                <h2 class="text-2xl font-bold mb-4">Assignment Submission</h2>
                <p>Submit assignments and check deadlines.</p>
                <a href="assignments.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-blue-700 inline-block">View</a>
            </section>

            <!-- Library Section -->
            <section id="library"class="bg-white bg-zinc-200 p-6 rounded-lg  max-w-[20vw] min-w-[20vw] w-[20vw]  h-full">
                <h2 class="text-2xl font-bold mb-4">Library</h2>
                <p>Access library resources and search for books.</p>
                <a href="library.php" class="mt-4 bg-[#00bbff] text-white py-2 px-4 rounded hover:bg-blue-700 inline-block">View</a>
            </section>
        </main>
    </div>
</body>
</html>
