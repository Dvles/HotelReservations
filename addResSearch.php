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
include './db/config.php'; // Ensure this path is correct

// Establish a PDO connection
try {
    $cnx = new PDO(DSN, USERNAME, PASSWORD);
    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connected successfully.<br>";
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve user input from the form
$checkin_date = $_POST['checkin_date'] ?? null;
$checkout_date = $_POST['checkout_date'] ?? null;
$roomType = $_POST['roomType'] ?? null;

// Calculate the number of nights
$startDate = new DateTime($checkin_date);
$endDate = new DateTime($checkout_date);
$interval = $startDate->diff($endDate);
$number_of_nights = $interval->days;

// Ensure user input is valid
if (!$checkin_date || !$checkout_date || !$roomType || $number_of_nights <= 0) {
    die("Invalid input data.");
}

// Print debugging information
echo "<pre>";
print_r([
    'checkin_date' => $checkin_date,
    'checkout_date' => $checkout_date,
    'roomType' => $roomType,
    'number_of_nights' => $number_of_nights
]);
echo "</pre>";

// Prepare the SQL query to find available rooms
$sql_rooms = "
SELECT r.id, r.room_number, r.room_type, r.description, r.price_per_night
    FROM rooms r
    JOIN (
        SELECT room_id
        FROM availability
        WHERE start_date <= :checkin_date
        AND end_date >= :checkout_date
        GROUP BY room_id
        HAVING COUNT(*) > 0
    ) a ON r.id = a.room_id
    WHERE r.room_type = :roomType
";

try {
    // Prepare the statement
    $stmt_rooms = $cnx->prepare($sql_rooms);

    // Bind parameters
    $stmt_rooms->bindParam(':checkin_date', $checkin_date);
    $stmt_rooms->bindParam(':checkout_date', $checkout_date);
    $stmt_rooms->bindParam(':roomType', $roomType);

    // Execute the statement
    $stmt_rooms->execute();

    // Fetch results
    $rooms = $stmt_rooms->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rooms)) {
        echo "No rooms available for the selected dates and type.";
    } else {
        foreach ($rooms as $room) {
            $roomNumber = htmlspecialchars($room['room_number'] ?? '', ENT_QUOTES, 'UTF-8');
            $roomType = htmlspecialchars($room['room_type'] ?? '', ENT_QUOTES, 'UTF-8');
            $description = htmlspecialchars($room['description'] ?? '', ENT_QUOTES, 'UTF-8');
            $pricePerNight = htmlspecialchars($room['price_per_night'] ?? '', ENT_QUOTES, 'UTF-8');
            $totalCost = $pricePerNight * $number_of_nights;
            $totalCostFormatted = number_format($totalCost, 2);

            echo "<div class='room'>";
            echo "<h3>Room Number: " . $roomNumber . "</h3>";
            echo "<p>Type: " . $roomType . "</p>";
            echo "<p>Description: " . $description . "</p>";
            echo "<p>Price per Night: $" . $pricePerNight . "</p>";
            echo "<p>Total: $" . $totalCostFormatted . "</p>";
            echo "</div>";
        }
    }
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

// Close the connection
$cnx = null;
?>





</body>
</html>
