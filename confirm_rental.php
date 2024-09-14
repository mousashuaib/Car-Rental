<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['invoice_id'])) {
    header('Location: login.php');
    exit();
}

$invoice_id = $_GET['invoice_id'];
$query = "SELECT * FROM rentals WHERE rental_id = :invoice_id";
$stmt = $pdo->prepare($query);
$stmt->execute([':invoice_id' => $invoice_id]);
$rental = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCAR - Rental Confirmation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .confirmation {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            margin: 2rem auto;
            text-align: center;
        }

        .confirmation h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .confirmation p {
            margin: 0.5rem 0;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div id="pageWrapper">
        <?php include('header.php'); ?>

        <div class="main-content">
            <?php include('sidebar.php'); ?>

            <section class="contentArea">
                <div class="confirmation">
                    <h2>Rental Confirmation</h2>
                    <p>Thank you for renting with us!</p>
                    <p>Your rental has been successfully processed.</p>
                    <p>Invoice ID: <?php echo htmlspecialchars($invoice_id); ?></p>
                    <p>Total Price: $<?php echo htmlspecialchars($rental['total_price']); ?></p>
                    <p>Pickup Date: <?php echo htmlspecialchars($rental['pickup_date']); ?></p>
                    <p>Return Date: <?php echo htmlspecialchars($rental['return_date']); ?></p>
                    <p>Pickup Location: <?php echo htmlspecialchars($rental['pickup_location']); ?></p>
                    <p>Return Location: <?php echo htmlspecialchars($rental['return_location']); ?></p>
                    <p>Extra Options: <?php echo htmlspecialchars($rental['extra_options']); ?></p>
                    <a href="index.php" class="rent-button">Return to Home</a>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>
</body>

</html>
