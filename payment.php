<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['rental'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rental = $_SESSION['rental'];
    $car_id = $rental['car_id'];
    $user_id = $_SESSION['user_id'];
    $pickup_date = $rental['pickup_date'];
    $return_date = $rental['return_date'];
    $pickup_location = $rental['pickup_location'];
    $return_location = $rental['return_location'];
    $total_price = $rental['total_price'];
    $extra_options = implode(', ', $rental['extra_options']);

    $credit_card_number = $_POST['credit_card_number'];
    $credit_card_expiration = $_POST['credit_card_expiration'];
    $credit_card_holder_name = $_POST['credit_card_holder_name'];
    $credit_card_bank = $_POST['credit_card_bank'];
    $credit_card_type = $_POST['credit_card_type'];

    $query = "INSERT INTO rentals (car_id, user_id, pickup_date, return_date, pickup_location, return_location, total_price, status, extra_options) 
            VALUES (:car_id, :user_id, :pickup_date, :return_date, :pickup_location, :return_location, :total_price, 'future', :extra_options)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':car_id' => $car_id,
        ':user_id' => $user_id,
        ':pickup_date' => $pickup_date,
        ':return_date' => $return_date,
        ':pickup_location' => $pickup_location,
        ':return_location' => $return_location,
        ':total_price' => $total_price,
        ':extra_options' => $extra_options
    ]);

    $invoice_id = $pdo->lastInsertId();
    unset($_SESSION['rental']);
    header('Location: confirm_rental.php?invoice_id=' . $invoice_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCAR - Payment</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .payment-form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            margin: 2rem auto;
        }

        .payment-form h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .payment-form label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
        }

        .payment-form input[type="text"],
        .payment-form input[type="date"],
        .payment-form input[type="number"],
        .payment-form input[type="radio"] {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .payment-form input[type="submit"] {
            background-color: #333;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 1rem;
            display: block;
            width: 100%;
            text-align: center;
        }

        .payment-form input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <div id="pageWrapper">
        <?php include('header.php'); ?>

        <div class="main-content">
            <?php include('sidebar.php'); ?>

            <section class="contentArea">
                <div class="payment-form">
                    <h2>Payment Details</h2>
                    <form method="POST" action="payment.php">
                        <label for="credit_card_number">Credit Card Number:</label>
                        <input type="text" name="credit_card_number" id="credit_card_number" required>
                        <label for="credit_card_expiration">Credit Card Expiration Date:</label>
                        <input type="date" name="credit_card_expiration" id="credit_card_expiration" required>
                        <label for="credit_card_holder_name">Credit Card Holder Name:</label>
                        <input type="text" name="credit_card_holder_name" id="credit_card_holder_name" required>
                        <label for="credit_card_bank">Credit Card Bank:</label>
                        <input type="text" name="credit_card_bank" id="credit_card_bank" required>
                        <label for="credit_card_type">Credit Card Type:</label>
                        <div>
                            <input type="radio" name="credit_card_type" value="Visa" required> Visa
                            <input type="radio" name="credit_card_type" value="MasterCard" required> MasterCard
                            <!-- Add more options as needed -->
                        </div>
                        <input type="submit" value="Confirm Payment">
                    </form>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>
</body>

</html>