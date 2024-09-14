<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'manager') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];

    $query = "INSERT INTO locations (name, address, city, postal_code, country, phone) 
            VALUES (:name, :address, :city, :postal_code, :country, :phone)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':name' => $name,
        ':address' => $address,
        ':city' => $city,
        ':postal_code' => $postal_code,
        ':country' => $country,
        ':phone' => $phone
    ]);

    $success = "Location added successfully";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div id="pageWrapper">
        <?php include('header.php'); ?>
        <div class="main-content">
            <?php include('sidebar.php'); ?>
            <section class="contentArea">
                <h2>Add New Location</h2>
                <?php if (isset($success)) : ?>
                    <p style="color: green;"><?php echo $success; ?></p>
                <?php endif; ?>
                <form method="POST" action="add_location.php">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" required>
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" required>
                    <label for="city">City:</label>
                    <input type="text" name="city" id="city" required>
                    <label for="postal_code">Postal Code:</label>
                    <input type="text" name="postal_code" id="postal_code" required>
                    <label for="country">Country:</label>
                    <input type="text" name="country" id="country" required>
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" required>
                    <input type="submit" value="Add Location">
                </form>
            </section>
        </div>
        <?php include('footer.php'); ?>
    </div>
</body>

</html>