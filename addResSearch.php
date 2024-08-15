<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/slider.css">
    <link rel="stylesheet" href="./styles/form.css">
</head>
<body>
    <?php
    $pageTitle= "Reservation";

    include "./db/config.php";
    include "./includes/nav.php";
    include "./includes/slider.php";

    // search results

    $roomType = $_POST['roomType'];

    Try {
        $cnx = new PDO (DSN,USERNAME,PASSWORD);

    } catch (Exception $e) {
        // problème de connexion!!
        // instructions à suivre en cas de 
        // problème de connexion
        print("<h3>An error has occured/h3>");

        // var_dump ($e->getMessage());
        die();
    }
    $sql = "SELECT * FROM rooms WHERE room_type LIKE :type";
    $stmt = $cnx->prepare($sql);
    $stmt->bindValue(":roomType", $roomType);

    $stmt->execute();

    $arrayRooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    print("<ul>");
    foreach($arrayRooms as $rooms){
        print ("<img class='affiche' src='./uploads/" . $rooms['img'] . "'>");
        print("<li> Price per night: " . $rooms['price_per_night'] . "</li>");
        print("<li> <p>Price per night: " . $rooms['description'] . "</p></li>");
        print("<button>Book now</button>");
    }

    print("<ul>");



    ?>
</body>
</html>