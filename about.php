<?php
include("db.php");
include("header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>An About Us</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .about-us {
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 4rem);
        }

        .about {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 800px;
            width: 100%;
        }

        .about img {
            margin-bottom: 1rem;
        }

        .abouttext {
            text-align: center;
        }

        .abouttext h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .abouttext p {
            font-size: 1rem;
            line-height: 1.5;
            color: #333;
        }

        .custom-button {
            background-color: #333;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            margin-top: 1rem;
        }

        .custom-button:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <section class="about-us">
        <div class="about">
            <img src="images/image.png" class="pic" width="100" height="100">
            <div class="abouttext">
                <h2>About Us</h2>
                <p>Welcome to BCAR, your trusted partner in car rentals. At BCAR, we are dedicated 
                    to providing exceptional service and a wide range of vehicles to suit all your
                    travel needs. Whether you are planning a family vacation, a business trip, 
                    or a weekend getaway, we have the perfect car for you. Our mission is to
                    make car rental easy, affordable, and enjoyable, offering you a seamless experience from booking to return. 
                    With a commitment to quality and customer satisfaction,
                    BCAR ensures that every journey is a pleasant one. Choose BCAR for reliable vehicles,
                    competitive prices, and unmatched service.
                    Drive with confidence, drive with BCAR.</p>
                <a href="index.php" class="custom-button">Return to Home Page</a>
            </div>
        </div>
    </section>
</body>

</html>

<?php
include("footer.php");
?>
