<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="main-header-admin">

    <div class="brand">
        <img
            class="logo"
            src="/student_management/images/logo.png"
            alt="University Logo"
        >

        <div class="brand-text">
            <h2>Student Hub</h2>
            <p>Student Management System</p>
        </div>
    </div>

    <!-- Navbar is now inside the header -->
    <nav class="admin-navbar">
        <div class="nav-links">

            <a href="/student_management/admin/dashboard.php"
               class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                <span class="nav-icon">⌂</span> Dashboard
            </a>

            <a href="/student_management/admin/students.php"
               class="nav-link <?= $current_page == 'students.php' ? 'active' : '' ?>">
                <span class="nav-icon">♙</span> Students
            </a>

            <a href="/student_management/admin/course.php"
               class="nav-link <?= $current_page == 'course.php' ? 'active' : '' ?>">
                <span class="nav-icon">▤</span> Courses
            </a>

            <a href="/student_management/admin/enrollments.php"
               class="nav-link <?= $current_page == 'enrollments.php' ? 'active' : '' ?>">
                <span class="nav-icon">▣</span> Enrollments
            </a>

            <a href="/student_management/admin/results.php"
               class="nav-link <?= $current_page == 'results.php' ? 'active' : '' ?>">
                <span class="nav-icon">▥</span> Results
            </a>

            <a href="/student_management/admin/admins.php"
               class="nav-link <?= $current_page == 'admins.php' ? 'active' : '' ?>">
                <span class="nav-icon">♙</span> Admin
            </a>

        </div>

        <a href="/student_management/logout.php" class="logout-link">
            <span class="nav-icon">↪</span> Logout
        </a>
    </nav>

</header>

