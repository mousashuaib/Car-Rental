<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['return_rental'])) {
    $rental_id = $_POST['rental_id'];

    try {
        $pdo->beginTransaction();

       
            $query = "DELETE FROM rentals WHERE rental_id = :rental_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':rental_id' => $rental_id]);

        $pdo->commit();

        header('Location: view_rented_cars.php');
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}

$user_id = $_SESSION['user_id'];
$query = "SELECT rentals.rental_id, cars.model, cars.type, rentals.pickup_date, rentals.return_date, rentals.pickup_location, rentals.return_location, rentals.total_price, rentals.status 
          FROM rentals 
          JOIN cars ON rentals.car_id = cars.car_id 
          WHERE rentals.user_id = :user_id 
          ORDER BY rentals.pickup_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([':user_id' => $user_id]);
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCAR - View Rented Cars</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .rented-car-list {
            margin-top: 20px;
        }

        .rented-car-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .rented-car-list table th,
        .rented-car-list table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .rented-car-list table th {
            background-color: #f2f2f2;
        }

        .return-button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .return-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div id="pageWrapper">
        <?php include('header.php'); ?>

        <div class="main-content">
            <?php include('sidebar.php'); ?>

            <section class="contentArea">
                <h2>View Rented Cars</h2>
                <div class="rented-car-list">
                    <?php if (count($rentals) > 0) : ?>
                        <table>
                            <tr>
                                <th>Model</th>
                                <th>Type</th>
                                <th>Pickup Date</th>
                                <th>Return Date</th>
                                <th>Pickup Location</th>
                                <th>Return Location</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($rentals as $rental) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($rental['model']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['type']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['pickup_date']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['return_date']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['pickup_location']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['return_location']); ?></td>
                                    <td>$<?php echo htmlspecialchars($rental['total_price']); ?></td>
                                    <td><?php echo htmlspecialchars($rental['status']); ?></td>
                                    <td>
                                        <?php if ($rental['status'] == 'future') : ?>
                                            <form method="POST" action="view_rented_cars.php">
                                                <input type="hidden" name="rental_id" value="<?php echo htmlspecialchars($rental['rental_id']); ?>">
                                                <button type="submit" name="return_rental" class="return-button">Return Car</button>
                                            </form>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else : ?>
                        <p>No rented cars found.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>
</body>

</html>
