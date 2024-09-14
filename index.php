<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCAR - Home Page</title>
    <link rel="stylesheet" href="styles.css"> 
</head>

<body>
    <div id="pageWrapper">
        <?php include('header.php'); ?>

        <div class="main-content">
            <?php include('sidebar.php'); ?>

            <section class="contentArea">
                <div class="car-list">
                    <?php
                    $query = "SELECT cars.car_id, cars.model, cars.description, cars.price_per_day, carphotos.file_name 
                            FROM cars 
                            LEFT JOIN carphotos ON cars.car_id = carphotos.car_id";

                    $result = $pdo->query($query);

                    if ($result->rowCount() > 0) {
                        while ($car = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo '<a href="car_details.php?id=' . htmlspecialchars($car['car_id']) . '" class="car-link">';
                            echo '<div class="card">';
                            echo '<div class="card-img">';
                            echo '<img src="images/' . htmlspecialchars($car['file_name']) . '" alt="' . htmlspecialchars($car['model']) . '">';
                            echo '</div>';
                            echo '<div class="card-info">';
                            echo '<p class="text-title">' . htmlspecialchars($car['model']) . '</p>';
                            echo '<p class="text-description">' . htmlspecialchars($car['description']) . '</p>';
                            echo '</div>';
                            echo '<div class="card-footer">';
                            echo '<span class="text-title">$' . htmlspecialchars($car['price_per_day']) . '</span>';
                            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'customer') {
                                echo '<a href="rent_car.php?id=' . htmlspecialchars($car['car_id']) . '" class="rent-button">Rent Now</a>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo '<p>No cars found.</p>';
                    }
                    ?>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>
</body>

</html>
