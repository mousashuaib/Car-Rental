<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['name']) || empty($_POST['address']) || empty($_POST['dob']) || 
        empty($_POST['id_number']) || empty($_POST['email']) || empty($_POST['phone']) || 
        empty($_POST['credit_card_number']) || empty($_POST['credit_card_expiration']) || 
        empty($_POST['credit_card_holder_name']) || empty($_POST['credit_card_bank'])) {
        $error = "All fields are required.";
    } else {
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['address'] = $_POST['address'];
        $_SESSION['dob'] = $_POST['dob'];
        $_SESSION['id_number'] = $_POST['id_number'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['phone'] = $_POST['phone'];
        $_SESSION['credit_card_number'] = $_POST['credit_card_number'];
        $_SESSION['credit_card_expiration'] = $_POST['credit_card_expiration'];
        $_SESSION['credit_card_holder_name'] = $_POST['credit_card_holder_name'];
        $_SESSION['credit_card_bank'] = $_POST['credit_card_bank'];

        header("Location:registration_step2.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental - Register Step 1</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1 class="title">Register - Step 1</h1>
        <form class="form" action="registration_step1.php" method="post">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-group">
                <label for="address">Address (Flat/House No, Street, City, Country):</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="input-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="input-group">
                <label for="id_number">ID Number:</label>
                <input type="text" id="id_number" name="id_number" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="input-group">
                <label for="credit_card_number">Credit Card Number:</label>
                <input type="text" id="credit_card_number" name="credit_card_number" required>
            </div>
            <div class="input-group">
                <label for="credit_card_expiration">Credit Card Expiration Date:</label>
                <input type="date" id="credit_card_expiration" name="credit_card_expiration" required>
            </div>
            <div class="input-group">
                <label for="credit_card_holder_name">Credit Card Holder Name:</label>
                <input type="text" id="credit_card_holder_name" name="credit_card_holder_name" required>
            </div>
            <div class="input-group">
                <label for="credit_card_bank">Credit Card Bank:</label>
                <input type="text" id="credit_card_bank" name="credit_card_bank" required>
            </div>
            <input class="sign" type="submit" value="Next">
        </form>
    </div>
</body>
</html>
