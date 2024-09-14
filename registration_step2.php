<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strlen($_POST['username']) < 6 || strlen($_POST['username']) > 13) {
        $error = "Username must be between 6 and 13 characters.";
    } elseif (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 12) {
        $error = "Password must be between 8 and 12 characters.";
    } elseif ($_POST['password'] !== $_POST['password_confirm']) {
        $error = "Passwords do not match.";
    } else {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];

        header("Location:registration_step3.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental - Register Step 2</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1 class="title">Register - Step 2</h1>
        <form class="form" action="registration_step2.php" method="post">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>
            <input class="sign" type="submit" value="Next">
        </form>
    </div>
</body>
</html>
