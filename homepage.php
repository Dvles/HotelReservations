<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/grids.css">
    <link rel="stylesheet" href="./styles/slider.css">
   
    <title>B-HOTEL</title>
</head>
<body>

    <?php
    $pageTitle= "B-HOTEL";
    include "./db/config.php";
    include_once "./includes/nav.php";
    include_once "./includes/slider.php";

    // connecting to DB & display rooms
    try {
        $cnx = new PDO (DSN,USERNAME,PASSWORD);
    } catch (Exception $e) {
        print ("error loading page");
        print $e;
        die();
    }

    $sql = "SELECT * FROM rooms ORDER BY id";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $arrayRooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //display rooms

    print ("<div class='roomContainer'>"); // Use a container div to wrap all rooms
    foreach ($arrayRooms as $rooms) {
        print ("<div class='roomGrid'>"); // A div for each room
        print ("<img src='" . $rooms['img'] . "'>");
        print ("<h3>" . $rooms['room_type'] ."</h3>");
        print("<p><span>" . $rooms['price_per_night']. "$ </span>/night </p>");
        print("<p> " . $rooms['description'] . "</p>");
        print("<a href=''><button>book now</button></a>");
        print ("</div>");
    }
    print ("</div>");
    

    ?>
    
</body>
</html>