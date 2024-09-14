<nav class="sidebarNavigation">
    <ul class="menuItems">
        <li><a href="index.php" class="navItem">Home</a></li>
        <li><a href="search_car.php" class="navItem">Search Car</a></li>
        <?php
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'manager') {
            echo "<li><a href='add_car.php' class='navItem'>Add Car</a></li>";
            echo "<li><a href='add_location.php' class='navItem'>Add Location</a></li>";
            echo "<li><a href='view_cars.php' class='navItem'>Cars Inquire</a></li>";
        } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'customer') {
            echo "<li><a href='view_rented_cars.php' class='navItem'>View Rented Cars</a></li>";
            echo "<li><a href='return_car.php' class='navItem'>Return Car</a></li>";
        }
        ?>
        <?php if (!isset($_SESSION['username'])) : ?>
            <li><a href="login.php" class="navItem">Login</a></li>
            <li><a href="registration_step1.php.php" class="navItem">Sign Up</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['username'])) : ?>
            <li><a href="logout.php" class="navItem">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
