<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['rental'] = [
        'car_id' => $_POST['car_id'],
        'pickup_date' => $_POST['pickup_date'],
        'return_date' => $_POST['return_date'],
        'pickup_location' => $_POST['pickup_location'],
        'return_location' => $_POST['return_location'],
        'total_price' => $_POST['total_price'],
        'extra_options' => isset($_POST['extra_options']) ? $_POST['extra_options'] : []
    ];
    header('Location: payment.php');
    exit();
}

$query = "SELECT * FROM locations";
$locations_stmt = $pdo->prepare($query);
$locations_stmt->execute();
$locations = $locations_stmt->fetchAll(PDO::FETCH_ASSOC);

$car_id = $_GET['id'];
$query = "SELECT * FROM cars WHERE car_id = :car_id";
$stmt = $pdo->prepare($query);
$stmt->execute([':car_id' => $car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCAR - Rent Car</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .rent-car-form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            margin: 2rem auto;
        }

        .rent-car-form h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .rent-car-form p {
            margin: 0.5rem 0;
            font-size: 1rem;
        }

        .rent-car-form label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
        }

        .rent-car-form input[type="text"],
        .rent-car-form input[type="date"],
        .rent-car-form input[type="number"],
        .rent-car-form select {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .rent-car-form input[type="submit"] {
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

        .rent-car-form input[type="submit"]:hover {
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
                <div class="rent-car-form">
                    <h2>Rent Car</h2>
                    <form method="POST" action="rent_car.php">
                        <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['car_id']); ?>">
                        <p>Model: <?php echo htmlspecialchars($car['model']); ?></p>
                        <p>Description: <?php echo htmlspecialchars($car['description']); ?></p>
                        <label for="pickup_date">Pickup Date:</label>
                        <input type="date" name="pickup_date" id="pickup_date" required>
                        <label for="return_date">Return Date:</label>
                        <input type="date" name="return_date" id="return_date" required>
                        <label for="pickup_location">Pickup Location:</label>
                        <select name="pickup_location" id="pickup_location" required>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo htmlspecialchars($location['location_id']); ?>">
                                    <?php echo htmlspecialchars($location['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="return_location">Return Location:</label>
                        <select name="return_location" id="return_location" required>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo htmlspecialchars($location['location_id']); ?>">
                                    <?php echo htmlspecialchars($location['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="total_price">Total Price:</label>
                        <input type="number" name="total_price" id="total_price" value="<?php echo htmlspecialchars($car['price_per_day']); ?>" required>
                        <label for="extra_options">Extra Options:</label>
                        <div>
                            <input type="checkbox" name="extra_options[]" value="baby_seat"> Baby Seat
                            <input type="checkbox" name="extra_options[]" value="insurance"> Insurance
                        </div>
                        <input type="submit" value="Rent Now">
                    </form>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>
</body>

</html>