<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $credit_card_number = $_POST['credit_card_number'];
    $credit_card_expiration = $_POST['credit_card_expiration'];
    $credit_card_holder_name = $_POST['credit_card_holder_name'];
    $credit_card_bank = $_POST['credit_card_bank'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE users 
            SET name = :name, address = :address, dob = :dob, id_number = :id_number, email = :email, phone = :phone, 
            credit_card_number = :credit_card_number, credit_card_expiration = :credit_card_expiration, 
            credit_card_holder_name = :credit_card_holder_name, credit_card_bank = :credit_card_bank 
            WHERE user_id = :user_id";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':name' => $name,
        ':address' => $address,
        ':dob' => $dob,
        ':id_number' => $id_number,
        ':email' => $email,
        ':phone' => $phone,
        ':credit_card_number' => $credit_card_number,
        ':credit_card_expiration' => $credit_card_expiration,
        ':credit_card_holder_name' => $credit_card_holder_name,
        ':credit_card_bank' => $credit_card_bank,
        ':user_id' => $user_id
    ]);

    $_SESSION['username'] = $email; 
    $success = "Profile updated successfully";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCAR - Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div id="pageWrapper">
        <?php include('header.php'); ?>

        <div class="main-content">
            <?php include('sidebar.php'); ?>

            <section class="contentArea">
                <h2>Profile</h2>
                <?php
                $user_id = $_SESSION['user_id'];
                $query = "SELECT * FROM users WHERE user_id = :user_id";
                $stmt = $pdo->prepare($query);
                $stmt->execute([':user_id' => $user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <form method="POST" action="profile.php">
                    <?php if (isset($success)) : ?>
                        <p style="color: green;"><?php echo $success; ?></p>
                    <?php endif; ?>
                    <div class="input-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="address">Address:</label>
                        <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="id_number">ID Number:</label>
                        <input type="text" name="id_number" id="id_number" value="<?php echo htmlspecialchars($user['id_number']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="credit_card_number">Credit Card Number:</label>
                        <input type="text" name="credit_card_number" id="credit_card_number" value="<?php echo htmlspecialchars($user['credit_card_number']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="credit_card_expiration">Credit Card Expiration Date:</label>
                        <input type="date" name="credit_card_expiration" id="credit_card_expiration" value="<?php echo htmlspecialchars($user['credit_card_expiration']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="credit_card_holder_name">Credit Card Holder Name:</label>
                        <input type="text" name="credit_card_holder_name" id="credit_card_holder_name" value="<?php echo htmlspecialchars($user['credit_card_holder_name']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="credit_card_bank">Credit Card Bank:</label>
                        <input type="text" name="credit_card_bank" id="credit_card_bank" value="<?php echo htmlspecialchars($user['credit_card_bank']); ?>" required>
                    </div>
                    <input class="sign" type="submit" value="Update Profile">
                </form>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>
</body>

</html>
