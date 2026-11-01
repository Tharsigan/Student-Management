<?php
    // Detect the current user's role
    $role = $_SESSION['role'] ?? '';

    // Home page always uses the student green theme
    $current_page = basename($_SERVER['PHP_SELF']);

    if ($current_page == 'index.php') {
        $footer_theme = 'footer-student';
    } elseif ($role == 'admin') {
        $footer_theme = 'footer-admin';
    } else {
        $footer_theme = 'footer-student';
    }
?>

<footer class="site-footer <?= $footer_theme ?>">
    <div class="footer-section footer-brand">
        <img class="footer-logo"
             src="/student_management/images/logo.png"
             alt="Student Hub Logo">

        <p class="footer-description">
            Your university journey, organized in one place.
        </p>

        <p class="footer-copyright">
            &copy; 2026 Student Hub. All rights reserved.
        </p>
    </div>

    <div class="footer-section">
        <h3>Contact Us</h3>
        <p>Colombo, Sri Lanka</p>
        <p>
            <a href="mailto:info@studenthub.lk">
                info@studenthub.lk
            </a>
        </p>
    </div>

    <div class="footer-section">
        <h3>About Student Hub</h3>
        <p>
            A centralized platform for managing student profiles,
            courses, enrollments, and academic results.
        </p>
    </div>
</footer>
