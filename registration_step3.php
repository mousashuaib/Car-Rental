<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_SESSION['name'];
    $address = $_SESSION['address'];
    $dob = $_SESSION['dob'];
    $id_number = $_SESSION['id_number'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $credit_card_number = $_SESSION['credit_card_number'];
    $credit_card_expiration = $_SESSION['credit_card_expiration'];
    $credit_card_holder_name = $_SESSION['credit_card_holder_name'];
    $credit_card_bank = $_SESSION['credit_card_bank'];
    $username = $_SESSION['username'];
    $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

    $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error = "Username or Email already exists. Please choose another.";
    } else {
        $sql = "INSERT INTO users (name, address, dob, id_number, email, phone, credit_card_number, credit_card_expiration, credit_card_holder_name, credit_card_bank, username, password, user_type) 
                VALUES (:name, :address, :dob, :id_number, :email, :phone, :credit_card_number, :credit_card_expiration, :credit_card_holder_name, :credit_card_bank, :username, :password, 'customer')";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'name' => $name,
                'address' => $address,
                'dob' => $dob,
                'id_number' => $id_number,
                'email' => $email,
                'phone' => $phone,
                'credit_card_number' => $credit_card_number,
                'credit_card_expiration' => $credit_card_expiration,
                'credit_card_holder_name' => $credit_card_holder_name,
                'credit_card_bank' => $credit_card_bank,
                'username' => $username,
                'password' => $password
            ]);
            $user_id = $pdo->lastInsertId(); 
            session_destroy();
            echo "Registration successful! Your customer ID is $user_id. <a href='login.php'>Login here</a>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental - Register Step 3</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1 class="title">Register - Step 3</h1>
        <form class="form" action="registration_step3.php" method="post">
            <h2 class="title">Confirm your details:</h2>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <p>Name: <?php echo $_SESSION['name']; ?></p>
            </div>
            <div class="input-group">
                <p>Address: <?php echo $_SESSION['address']; ?></p>
            </div>
            <div class="input-group">
                <p>Date of Birth: <?php echo $_SESSION['dob']; ?></p>
            </div>
            <div class="input-group">
                <p>ID Number: <?php echo $_SESSION['id_number']; ?></p>
            </div>
            <div class="input-group">
                <p>Email: <?php echo $_SESSION['email']; ?></p>
            </div>
            <div class="input-group">
                <p>Phone: <?php echo $_SESSION['phone']; ?></p>
            </div>
            <div class="input-group">
                <p>Credit Card Number: <?php echo $_SESSION['credit_card_number']; ?></p>
            </div>
            <div class="input-group">
                <p>Credit Card Expiration Date: <?php echo $_SESSION['credit_card_expiration']; ?></p>
            </div>
            <div class="input-group">
                <p>Credit Card Holder Name: <?php echo $_SESSION['credit_card_holder_name']; ?></p>
            </div>
            <div class="input-group">
                <p>Credit Card Bank: <?php echo $_SESSION['credit_card_bank']; ?></p>
            </div>
            <div class="input-group">
                <p>Username: <?php echo $_SESSION['username']; ?></p>
            </div>
            <input class="sign" type="submit" value="Confirm">
        </form>
    </div>
</body>
</html>
