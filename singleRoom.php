<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/style.css">

</head>
<body>

    <?php

        include "./includes/nav.php";

    ?>

    <h1>New room listed</h1>
    <div class="flex">

    <div class="middle">
        <?php 
        // Retrieve query parameters
        $roomType = isset($_GET['roomType']) ? htmlspecialchars($_GET['roomType']) : 'N/A';
        $pricePerNight = isset($_GET['pricePerNight']) ? htmlspecialchars($_GET['pricePerNight']) : 'N/A';
        $description = isset($_GET['description']) ? htmlspecialchars($_GET['description']) : 'N/A';
        $filePath = isset($_GET['filePath']) ? htmlspecialchars($_GET['filePath']) : '';

        // Display data
        ?>
        <h1><?php echo $roomType; ?></h1>
        <p>Room number: <?php echo $roomNumber; ?></p>
        <p>Price per night: <?php echo $pricePerNight; ?></p>
        <p>Description: <?php echo $description; ?></p>
    </div>

    <div class="right roomImg">
        <img src="<?php echo $filePath; ?>" class="roomImg" alt="Room Image">
    </div>
    </div>

    
</body>
</html>

