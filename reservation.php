<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
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

    ?>


    <div class="form-container">
        <form action="./addResSearch.php" method="POST" enctype="multipart/form-data">
            
            <label for="checkin_date">Check-in date:</label>
            <input type="date" name="checkin_date" id="">
            
            <label for="checkout_date">Check-out date:</label>
            <input type="date" name="checkout_date" id="">
            
            <label for="room-type">Type</label>
            <select id="room-type" name="roomType">
                <option value="single">Single Room</option>
                <option value="double">Double Room</option>
                <option value="ensuite">Ensuite</option>
            </select>

<!--      ADD TO NEXT PAGE  

            <label for="Name">Name:</label>
            <input type="text" name="name" id="">
            <label for="Name">Last name:</label>
            <input type="text" name="lastName" id="">
            <label for="Email">Email:</label>
            <input type="text" name="email" id="">

            <label for="comments">Notes:</label>
            <textarea name="description" id="description"></textarea> -->



            <input type="submit" value="See rooms">
        </form>
    </div>

    
</body>
</html>