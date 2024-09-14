<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCAR - Search Car</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div id="pageWrapper">
        <?php include('header.php'); ?>

        <div class="main-content">
            <?php include('sidebar.php'); ?>

            <section class="contentArea">
                <h2>Search Car</h2>
                <form method="GET" action="search_car.php">
                    <label for="type">Car Type:</label>
                    <select name="type" id="type">
                        <option value="">Any</option>
                        <option value="Mercedis">Mercedis</option>
                        <option value="hyundai">hyundai</option>
                        <option value="BMW">BMW</option>
                        <option value="volov">volvo</option>	
                        <option value="sorento">sorento</option>
                        <option value="Golf">Golf</option>
                        <option value="reno">reno</option>
                        <option value="KIA">KIA</option>
                        <option value="sedan">sedan</option>
                        <option value="van">van</option>
                        <option value="suv">suv</option>

                    </select>
                    <label for="location">Pickup Location:</label>
                    <input type="text" name="location" id="location">
                    <label for="min_price">Min Price:</label>
                    <input type="number" name="min_price" id="min_price" min="0">
                    <label for="max_price">Max Price:</label>
                    <input type="number" name="max_price" id="max_price" min="0">
                    <label for="from_date">From Date:</label>
                    <input type="date" name="from_date" id="from_date">
                    <label for="to_date">To Date:</label>
                    <input type="date" name="to_date" id="to_date">
                    <input type="submit" value="Search">
                </form>

                <div class="car-list">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        $type = $_GET['type'] ?? '';
                        $location = $_GET['location'] ?? '';
                        $min_price = $_GET['min_price'] ?? 0;
                        $max_price = $_GET['max_price'] ?? 1000;
                        $from_date = $_GET['from_date'] ?? date('Y-m-d');
                        $to_date = $_GET['to_date'] ?? date('Y-m-d', strtotime('+3 days'));

                        $query = "SELECT cars.car_id, cars.model, cars.description, cars.price_per_day, cars.type, cars.fuel_type, carphotos.file_name 
                                FROM cars 
                                LEFT JOIN carphotos ON cars.car_id = carphotos.car_id 
                                WHERE (cars.type LIKE :type OR :type = '')
                                AND (cars.price_per_day BETWEEN :min_price AND :max_price)
                                AND (cars.car_id NOT IN (
                                    SELECT car_id FROM rentals 
                                    WHERE (pickup_date BETWEEN :from_date AND :to_date)
                                    OR (return_date BETWEEN :from_date AND :to_date)
                                ))";

                        $stmt = $pdo->prepare($query);
                        $stmt->execute([
                            ':type' => "%$type%",
                            ':min_price' => $min_price,
                            ':max_price' => $max_price,
                            ':from_date' => $from_date,
                            ':to_date' => $to_date
                        ]);

                        if ($stmt->rowCount() > 0) {
                            echo '<table class="car-table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th><button id="showChecked">Show Checked</button></th>';
                            echo '<th><a href="?sort=price_per_day">Price Per Day</a></th>';
                            echo '<th><a href="?sort=type">Car Type</a></th>';
                            echo '<th>Fuel Type</th>';
                            echo '<th>Photo</th>';
                            echo '<th>Action</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            while ($car = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<tr>';
                                echo '<td><input type="checkbox" class="car-checkbox" data-id="' . htmlspecialchars($car['car_id']) . '"></td>';
                                echo '<td>' . htmlspecialchars($car['price_per_day']) . '</td>';
                                echo '<td>' . htmlspecialchars($car['type']) . '</td>';
                                echo '<td class="' . htmlspecialchars($car['fuel_type']) . '">' . htmlspecialchars($car['fuel_type']) . '</td>';
                                echo '<td><img src="images/' . htmlspecialchars($car['file_name']) . '" alt="' . htmlspecialchars($car['model']) . '" class="car-photo"></td>';
                                echo '<td><a href="car_details.php?id=' . htmlspecialchars($car['car_id']) . '" class="rent-button">Rent Now</a></td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<p>No cars found.</p>';
                        }
                    }
                    ?>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>


































    
    <script>
        document.getElementById('showChecked').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.car-checkbox:checked');
            const checkedIds = Array.from(checkboxes).map(cb => cb.getAttribute('data-id'));
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const id = row.querySelector('.car-checkbox').getAttribute('data-id');
                if (!checkedIds.includes(id)) {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>