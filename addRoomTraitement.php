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

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Check if the file was uploaded without errors
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {

            // File upload preparation
            $folder = "./uploads";
            
            // Ensure the uploads directory exists
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
            
            // Create a unique file name
            $fileName = uniqid() . '-' . date("YmdHis") . '-' . basename($_FILES['img']['name']);
            $filePath = $folder . "/" . $fileName;

            // Move the uploaded file to the designated folder
            if (move_uploaded_file($_FILES['img']['tmp_name'], $filePath)) {
          
            } else {
                echo "Failed to move the uploaded file.";
            }
        }
    }


    // Form data
    $pricePerNight = $_POST['price_per_night'];
    $description = $_POST['description'];
    $roomType = $_POST['roomType'];
    $roomNumber=$_POST['roomNumber'];


    //DB connection
    include "./db/config.php";
    try {
        $cnx = new PDO(DSN,USERNAME,PASSWORD);
    } catch (Exception $e){
        print("An issue has occured.");
        die();
    } 

    try {

        $sql = "INSERT INTO rooms (id, room_number, room_type, price_per_night, description, img) VALUES (null, :room_number,:type,:pricePerNight,:description,:img)";
        $stmt =$cnx->prepare($sql);
        $stmt->bindValue(":room_number",$roomNumber);
        $stmt->bindValue(":type", $roomType);
        $stmt->bindValue("pricePerNight",$pricePerNight);
        $stmt->bindValue(":img",$filePath);
        $stmt->bindValue(":description", $description);

        $stmt->execute();

        // Redirect to singleRoom.php with query parameters
        header("Location: ./singleRoom.php?roomType=" . urlencode($roomType) .
                              "&pricePerNight=" . urlencode($pricePerNight) .
                              "&description=" . urlencode($description) .
                              "&filePath=" . urlencode($filePath));
        exit;



    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }







    ?>
</body>
</html>