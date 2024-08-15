<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add room</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/slider.css">
    <link rel="stylesheet" href="./styles/form.css">
</head>
<body>

    <?php
        $pageTitle= "Add new room";
        include "./db/config.php";
        include "./includes/nav.php";
        include "./includes/slider.php";

    ?>


    <div class="form-container">
        <form action="./addRoomTraitement.php" method="POST" enctype="multipart/form-data">
            <label for="room-type">Type</label>
            <select id="room-type" name="roomType">
                <option value="single">Single Room</option>
                <option value="double">Double Room</option>
                <option value="ensuite">Ensuite</option>
            </select>

            <label for="room-number">Room Number</label>
            <input type="number" name="roomNumber" id="room-number" required>

            <label for="price_per_night">Price per Night</label>
            <input type="number" name="price_per_night" id="price_per_night" required>

            <label for="img">Room Picture</label>
            <input type="file" name="img" id="img" accept="image/*" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" required></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>

    
</body>
</html>