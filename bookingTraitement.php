<?php
// Include necessary files
include "./db/config.php";
include "./includes/nav.php";

// Get data from the form
$checkin_date = $_POST['checkin_date'] ?? null;
$checkout_date = $_POST['checkout_date'] ?? null;
$room_id = $_POST['room_id'] ?? null;
$room_type = $_POST['room_type'] ?? null; // Ensure this is being sent from the form
$room_price = $_POST['room_price'] ?? null; // Ensure this is being sent from the form
$total_cost = $_POST['total_cost'] ?? null; // Ensure this is being sent from the form
$first_name = $_POST['first_name'] ?? null;
$last_name = $_POST['Last_name'] ?? null; // Ensure this matches the form field name
$email = $_POST['email'] ?? null;
$payment_method = $_POST['payment_method'] ?? null;

// Debugging output to check posted data
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Validate input
if (!$checkin_date || !$checkout_date || !$room_id || !$room_type || !$room_price || !$total_cost || !$first_name || !$last_name || !$email || !$payment_method) {
    die("Invalid request. Please ensure all required parameters are provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Your Booking</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/form.css">
    <link rel="stylesheet" href="./styles/grids.css">
</head>
<body>

<?php include "./includes/nav.php"; ?>

<div class="booking-review-container">
    <h2>Review Your Booking</h2>
    <div class="booking-details">
        <h3>Booking Details:</h3>
        <p><strong>Check-in Date:</strong> <?php echo htmlspecialchars($checkin_date); ?></p>
        <p><strong>Check-out Date:</strong> <?php echo htmlspecialchars($checkout_date); ?></p>
        <p><strong>Room Type:</strong> <?php echo htmlspecialchars($room_type); ?></p>
        <p><strong>Price per Night:</strong> $<?php echo htmlspecialchars($room_price); ?></p>
        <p><strong>Total Cost:</strong> $<?php echo htmlspecialchars($total_cost); ?></p>
        
        <h3>Your Information:</h3>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($first_name); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($last_name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
    </div>

    <div class="booking-buttons">
        <form action="confirmBooking.php" method="POST">
            <!-- Pass all data to the confirmation page -->
            <input type="hidden" name="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>">
            <input type="hidden" name="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>">
            <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room_id); ?>">
            <input type="hidden" name="room_type" value="<?php echo htmlspecialchars($room_type); ?>">
            <input type="hidden" name="room_price" value="<?php echo htmlspecialchars($room_price); ?>">
            <input type="hidden" name="total_cost" value="<?php echo htmlspecialchars($total_cost); ?>">
            <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
            <input type="hidden" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="hidden" name="payment_method" value="<?php echo htmlspecialchars($payment_method); ?>">

            <button type="submit">Confirm Booking</button>
        </form>
        <form action="booking.php" method="GET">
            <!-- Pass data back to the form page -->
            <input type="hidden" name="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>">
            <input type="hidden" name="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>">
            <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room_id); ?>">
            <button type="submit">Go Back and Edit</button>
        </form>
    </div>
</div>

</body>
</html>
