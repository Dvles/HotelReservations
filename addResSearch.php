<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/slider.css">
    <link rel="stylesheet" href="./styles/grids.css">
    <link rel="stylesheet" href="./styles/form.css">
    <!-- TO TRY: USER TO MODIFY SEARCH QUERY <script src="./js/form.js" defer></script> -->
</head>
<body>

<?php
$pageTitle = "Search Results";
include './db/config.php'; 
include './includes/nav.php';
include './includes/slider.php';  

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

// Initialize the number of nights
$number_of_nights = 0;

if ($checkin_date && $checkout_date) {
    try {
        // Calculate the number of nights
        $startDate = new DateTime($checkin_date);
        $endDate = new DateTime($checkout_date);
        $interval = $startDate->diff($endDate);
        $number_of_nights = $interval->days;
    } catch (Exception $e) {
        die("Date calculation failed: " . $e->getMessage());
    }
}

// Ensure user input is valid
if (!$checkin_date || !$checkout_date || !$roomType || $number_of_nights <= 0) {
    die("Invalid input data.");
}

// Print debugging information
// echo "<pre>";
// print_r([
//     'checkin_date' => $checkin_date,
//     'checkout_date' => $checkout_date,
//     'roomType' => $roomType,
//     'number_of_nights' => $number_of_nights
// ]);
// echo "</pre>";
?>

<!-- FORM for UX -->
<div class="form-container">
    <form action="./addResSearch.php" method="POST" enctype="multipart/form-data">
        <label for="checkin_date">Check-in date:</label>
        <input type="date" name="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>" id="checkin_date" disabled>
        
        <label for="checkout_date">Check-out date:</label>
        <input type="date" name="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>" id="checkout_date" disabled>
        
        <label for="room-type">Type</label>
        <select id="room-type" name="roomType" disabled>
            <option value="single" <?php if ($roomType == 'single') echo 'selected'; ?>>Single Room</option>
            <option value="double" <?php if ($roomType == 'double') echo 'selected'; ?>>Double Room</option>
            <option value="ensuite" <?php if ($roomType == 'ensuite') echo 'selected'; ?>>Ensuite</option>
        </select>

        <!-- Submit button will TO BE updated by JavaScript -->
        <input type="submit" id="update-button" value="Update" disabled>
    </form>
</div>

<?php
// Prepare the SQL query to find available rooms
$sql_rooms = "SELECT r.id, r.room_number, r.room_type, r.description, r.price_per_night, r.img
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
        echo "<div class='roomContainer'>";
        foreach ($rooms as $room) {
            // Ensure values are not null before passing to htmlspecialchars
            $roomNumber = htmlspecialchars($room['room_number'] ?? '', ENT_QUOTES, 'UTF-8');
            $roomType = htmlspecialchars($room['room_type'] ?? '', ENT_QUOTES, 'UTF-8');
            $description = htmlspecialchars($room['description'] ?? '', ENT_QUOTES, 'UTF-8');
            $pricePerNight = htmlspecialchars($room['price_per_night'] ?? '', ENT_QUOTES, 'UTF-8');
            $imgSrc = htmlspecialchars($room['img'] ?? '', ENT_QUOTES, 'UTF-8');

            // Calculate the total cost
            $totalCost = $pricePerNight * $number_of_nights;
            $totalCostFormatted = number_format($totalCost, 2);

            // Output room details
            echo "<div class='roomGrid'>";
            // Use a default image if $imgSrc is empty
            if (!empty($imgSrc)) {
                echo "<img src='" . $imgSrc . "' alt='Room Image'>";
            } else {
                echo "<img src='path/to/default_image.jpg' alt='Default Room Image'>"; // Replace with your default image path
            }

            echo "<h3>" . $roomType . "</h3>";
            echo "<p>" . $description . "</p>";
            echo "<div class='roomPrice'>";
            echo "<p><span>" . $pricePerNight . "$</span> / night</p>";
            echo "<p><span>" . $totalCostFormatted  . "$</span> / " . $number_of_nights . " nights</p>";
            echo "</div>";
            echo "<a href='booking.php?checkin_date=" . urlencode($checkin_date) . "&checkout_date=" . urlencode($checkout_date) . "&room_id=" . urlencode($room['id']) . "'> <button>Book Now</button> </a>";
            echo "</div>";
        }
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

// Close the connection
$cnx = null;
?>

</body>
</html>
