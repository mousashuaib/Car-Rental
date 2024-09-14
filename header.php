<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="header-container">
        <div class="agency-name-logo">
            <img src="images/image.png" alt="BCAR Logo" width="50" height="50" />
            <h1>BCAR Car Rental Agency</h1>
        </div>
        <nav class="header-links">
            <a href="about.php">About Us</a>
            <?php if (isset($_SESSION['username'])) : ?>
                <a href="profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?> (Profile)</a>
                <a href="logout.php">Logout</a>
            <?php else : ?>
                <a href="login.php">Login</a>
                <a href="registration_step1.php">Sign Up</a>

            <?php endif; ?>
        </nav>
    </div>
</header>
