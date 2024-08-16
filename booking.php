<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/form.css">
    <link rel="stylesheet" href="./styles/slider.css">
    <link rel="stylesheet" href="./styles/grids.css">
</head>
<body>

<?php
$pageTitle= "Reservation";
include "./db/config.php";
include "./includes/nav.php";
include "./includes/slider.php";

// Initialize variables
$checkin_date = $_GET['checkin_date'] ?? null;
$checkout_date = $_GET['checkout_date'] ?? null;
$room_id = $_GET['room_id'] ?? null;

// Validate input
if (!$checkin_date || !$checkout_date || !$room_id) {
    die("Invalid request. Please ensure all required parameters are provided.");
}

// Fetch room details
try {
    $cnx = new PDO(DSN, USERNAME, PASSWORD);
    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM rooms WHERE id = :room_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->execute();

    $room = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$room) {
        die("Room not found.");
    }

    $pricePerNight = $room['price_per_night'];
    $description = htmlspecialchars($room['description']);
    $imgSrc = htmlspecialchars($room['img']);
    $roomType = htmlspecialchars($room['room_type']);
    
    // Calculate total cost
    $startDate = new DateTime($checkin_date);
    $endDate = new DateTime($checkout_date);
    $interval = $startDate->diff($endDate);
    $number_of_nights = $interval->days;
    $totalCost = $pricePerNight * $number_of_nights;
    $totalCostFormatted = number_format($totalCost, 2);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div class="roomContainer">
    <!-- Room Details -->
    <div class="roomGrid">
        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="Room Image">
        <h3><?php echo htmlspecialchars($roomType); ?></h3>
        <p><?php echo htmlspecialchars($description); ?></p>
        <div class="roomPrice">
            <p><span><?php echo htmlspecialchars($pricePerNight); ?>$</span> / night</p>
            <p><span><?php echo htmlspecialchars($totalCostFormatted); ?>$</span> / <?php echo htmlspecialchars($number_of_nights); ?> nights</p>
        </div>
    </div>

    <!-- Booking Form -->
    <div class="roomGrid">
        <h2>Book Your Room</h2>
        <form action="confirmBooking.php" method="POST">
            <!-- Hidden Inputs for Form Submission -->
            <input type="hidden" name="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>">
            <input type="hidden" name="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>">
            <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room_id); ?>">
            
            <!-- Display Check-in and Check-out Dates -->
            <label for="checkin_date_display">Check-in Date:</label>
            <input type="text" id="checkin_date_display" name="checkin_date_display" value="<?php echo htmlspecialchars($checkin_date); ?>" readonly>
            
            <label for="checkout_date_display">Check-out Date:</label>
            <input type="text" id="checkout_date_display" name="checkout_date_display" value="<?php echo htmlspecialchars($checkout_date); ?>" readonly>
            
            <label for="room_type">Room Type:</label>
            <input type="text" id="room_type" name="room_type" value="<?php echo htmlspecialchars($roomType); ?>" disabled>
            
            <label for="room_price">Price per Night:</label>
            <input type="text" id="room_price" name="room_price" value="<?php echo htmlspecialchars($pricePerNight); ?>" disabled>
            
            <label for="total_cost">Total Cost:</label>
            <input type="text" id="total_cost" name="total_cost" value="<?php echo htmlspecialchars($totalCostFormatted); ?>" disabled>
            
            <label for="name">First name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="name">Last Name:</label>
            <input type="text" id="Last_name" name="Last_name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="comments">Notes:</label>
            <textarea name="description" id="description"></textarea> 
            
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method">
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <!-- Add more payment methods if needed -->
            </select>
            
            <button type="submit">Confirm Booking</button>
        </form>
    </div>
</div>

</body>
</html>
