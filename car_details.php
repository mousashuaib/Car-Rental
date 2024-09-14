<?php
include('db.php');

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$car_id = $_GET['id'];

$query = "SELECT cars.car_id, cars.model, cars.make, cars.type, cars.registration_year, cars.description, cars.price_per_day, cars.capacity_people, cars.capacity_suitcases, cars.color, cars.fuel_type, cars.average_consumption, cars.horsepower, cars.length, cars.width, cars.gear_type, cars.plate_number, carphotos.file_name
        FROM cars
        LEFT JOIN carphotos ON cars.car_id = carphotos.car_id
        WHERE cars.car_id = :car_id";

$stmt = $pdo->prepare($query);
$stmt->execute(['car_id' => $car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo "Car not found.";
    exit();
}

include('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($car['model']); ?> - Car Details</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div id="pageWrapper">
        <div class="main-content">
            <?php include('sidebar.php'); ?>

            <section class="contentArea">
                <div class="car-details">
                    <div class="car-images">
                        <img src="images/<?php echo htmlspecialchars($car['file_name']); ?>" alt="<?php echo htmlspecialchars($car['model']); ?>">
                    </div>
                    <div class="car-info">
                        <h2><?php echo htmlspecialchars($car['model']); ?></h2>
                        <ul>
                            <li><strong>Make:</strong> <?php echo htmlspecialchars($car['make']); ?></li>
                            <li><strong>Type:</strong> <?php echo htmlspecialchars($car['type']); ?></li>
                            <li><strong>Registration Year:</strong> <?php echo htmlspecialchars($car['registration_year']); ?></li>
                            <li><strong>Price per Day:</strong> $<?php echo htmlspecialchars($car['price_per_day']); ?></li>
                            <li><strong>Capacity (People):</strong> <?php echo htmlspecialchars($car['capacity_people']); ?></li>
                            <li><strong>Capacity (Suitcases):</strong> <?php echo htmlspecialchars($car['capacity_suitcases']); ?></li>
                            <li><strong>Color:</strong> <?php echo htmlspecialchars($car['color']); ?></li>
                            <li><strong>Fuel Type:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?></li>
                            <li><strong>Average Consumption:</strong> <?php echo htmlspecialchars($car['average_consumption']); ?> L/100km</li>
                            <li><strong>Horsepower:</strong> <?php echo htmlspecialchars($car['horsepower']); ?></li>
                            <li><strong>Length:</strong> <?php echo htmlspecialchars($car['length']); ?> m</li>
                            <li><strong>Width:</strong> <?php echo htmlspecialchars($car['width']); ?> m</li>
                            <li><strong>Gear Type:</strong> <?php echo htmlspecialchars($car['gear_type']); ?></li>
                            <li><strong>Plate Number:</strong> <?php echo htmlspecialchars($car['plate_number']); ?></li>
                        </ul>
                        <p><?php echo htmlspecialchars($car['description']); ?></p>
                        <a href="rent_car.php?id=<?php echo htmlspecialchars($car['car_id']); ?>" class="rent-button">Rent Now</a>
                    </div>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>
</body>

</html>