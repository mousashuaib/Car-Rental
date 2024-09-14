<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'manager') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = $_POST['model'];
    $make = $_POST['make'];
    $type = $_POST['type'];
    $registration_year = $_POST['registration_year'];
    $description = $_POST['description'];
    $price_per_day = $_POST['price_per_day'];
    $capacity_people = $_POST['capacity_people'];
    $capacity_suitcases = $_POST['capacity_suitcases'];
    $color = $_POST['color'];
    $fuel_type = $_POST['fuel_type'];
    $average_consumption = $_POST['average_consumption'];
    $horsepower = $_POST['horsepower'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $gear_type = $_POST['gear_type'];
    $plate_number = $_POST['plate_number'];
    $conditions = $_POST['conditions'];

    $query = "INSERT INTO cars (model, make, type, registration_year, description, price_per_day, capacity_people, capacity_suitcases, 
            color, fuel_type, average_consumption, horsepower, length, width, gear_type, plate_number, status) 
            VALUES (:model, :make, :type, :registration_year, :description, :price_per_day, :capacity_people, :capacity_suitcases, 
            :color, :fuel_type, :average_consumption, :horsepower, :length, :width, :gear_type, :plate_number, 'available')";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':model' => $model,
        ':make' => $make,
        ':type' => $type,
        ':registration_year' => $registration_year,
        ':description' => $description,
        ':price_per_day' => $price_per_day,
        ':capacity_people' => $capacity_people,
        ':capacity_suitcases' => $capacity_suitcases,
        ':color' => $color,
        ':fuel_type' => $fuel_type,
        ':average_consumption' => $average_consumption,
        ':horsepower' => $horsepower,
        ':length' => $length,
        ':width' => $width,
        ':gear_type' => $gear_type,
        ':plate_number' => $plate_number
    ]);

    $car_id = $pdo->lastInsertId();

    $upload_dir = 'images/';
    for ($i = 1; $i <= 3; $i++) {
        if (isset($_FILES['car_photo' . $i]) && $_FILES['car_photo' . $i]['error'] == 0) {
            $file_name = 'car' . $car_id . 'img' . $i . '.' . pathinfo($_FILES['car_photo' . $i]['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['car_photo' . $i]['tmp_name'], $upload_dir . $file_name);

            $query = "INSERT INTO carphotos (car_id, file_name) VALUES (:car_id, :file_name)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':car_id' => $car_id,
                ':file_name' => $file_name
            ]);
        }
    }

    $success = "Car added successfully with ID: " . $car_id;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div id="pageWrapper">
        <?php include('header.php'); ?>
        <div class="main-content">
            <?php include('sidebar.php'); ?>
            <section class="contentArea">
                <h2>Add New Car</h2>
                <?php if (isset($success)) : ?>
                    <p style="color: green;"><?php echo $success; ?></p>
                <?php endif; ?>
                <form method="POST" action="add_car.php" enctype="multipart/form-data">
                    <label for="model">Model:</label>
                    <input type="text" name="model" id="model" required>

                    <label for="make">Make:</label>
         <input type="text" name="make" id="make" required>

                    </select>
                    <label for="type">Type:</label>
                    <select name="type" id="type" required>
                      <option value="BMW">BMW</option>
                        <option value="hyundai">hyundai</option>
                        <option value="Mercedis">Mercedis</option>
                        <option value="volov">volov</option>
                        <option value="sorento">sorento</option>
                        <option value="reno">reno</option>
                        <option value="KIA">KIA</option>

                    </select>
                    <label for="registration_year">Registration Year:</label>
                    <input type="number" name="registration_year" id="registration_year" required>
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>
                    <label for="price_per_day">Price per Day:</label>
                    <input type="number" name="price_per_day" id="price_per_day" required>
                    <label for="capacity_people">Capacity (People):</label>
                    <input type="number" name="capacity_people" id="capacity_people" required>
                    <label for="capacity_suitcases">Capacity (Suitcases):</label>
                    <input type="number" name="capacity_suitcases" id="capacity_suitcases" required>
                    <label for="color">Color:</label>
                    <input type="text" name="color" id="color" required>
                    <label for="fuel_type">Fuel Type:</label>
                    <select name="fuel_type" id="fuel_type" required>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                        <option value="electric">Electric</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                    <label for="average_consumption">Avg Petroleum Consumption (L/100km):</label>
                    <input type="number" step="0.1" name="average_consumption" id="average_consumption" required>
                    <label for="horsepower">Horsepower:</label>
                    <input type="number" name="horsepower" id="horsepower" required>
                    <label for="length">Length (m):</label>
                    <input type="number" step="0.01" name="length" id="length" required>
                    <label for="width">Width (m):</label>
                    <input type="number" step="0.01" name="width" id="width" required>
                    <label for="gear_type">Gear Type:</label>
                    <select name="gear_type" id="gear_type" required>
                        <option value="manual">Manual</option>
                        <option value="automatic">Automatic</option>
                    </select>
                    <label for="plate_number">Plate Number:</label>
                    <input type="text" name="plate_number" id="plate_number" required>
                    <label for="conditions">Conditions:</label>
                    <textarea name="conditions" id="conditions"></textarea>
                    <label for="car_photo1">Car Photo 1:</label>
                    <input type="file" name="car_photo1" id="car_photo1" required>
                    <input type="submit" value="Add Car">
                </form>
            </section>
        </div>
        <?php include('footer.php'); ?>
    </div>
</body>

</html>