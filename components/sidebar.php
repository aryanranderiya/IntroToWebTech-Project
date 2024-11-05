<!-- ./components/sidebar.php -->
<aside class="w-fit pr-10 px-5 bg-[#00bbff] text-white h-screen p-4 space-y-4">

    <?php if ($user_role === 'faculty'): ?>
        <a href="attendance.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
            <span class="material-icons mr-2">check_circle</span>
            Mark Attendance
        </a>
    <?php endif; ?>
    <a href="study-material.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
        <span class="material-icons mr-2">menu_book</span> Study Material
    </a>
    <!-- <a href="past-papers.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
        <span class="material-icons mr-2">history_edu</span> Past Papers
    </a> -->
    <a href="timetable.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
        <span class="material-icons mr-2">schedule</span> Timetable
    </a>
    <a href="curriculum.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
        <span class="material-icons mr-2">book</span> Curriculum
    </a>
    <!-- <a href="assignments.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
        <span class="material-icons mr-2">assignment</span> Assignments
    </a> -->
    <a href="library.php" class="block p-2 flex items-center hover:bg-[#3bcaff] rounded text-nowrap">
        <span class="material-icons mr-2">local_library</span> Library
    </a>
</aside>