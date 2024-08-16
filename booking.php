<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/form.css">
    <link rel="stylesheet" href="./styles/slider.css">
</head>
<body>
    <?php
    $pageTitle = "Booking Confirmation";
    include './db/config.php'; 
    include './includes/nav.php';
    include './includes/slider.php';

    // Retrieve query parameters
    $checkin_date = $_GET['checkin_date'] ?? null;
    $checkout_date = $_GET['checkout_date'] ?? null;
    $room_id = $_GET['room_id'] ?? null;

    if (!$checkin_date || !$checkout_date || !$room_id) {
        die("Invalid request.");
    }

    // Fetch room details
    try {
        $cnx = new PDO(DSN, USERNAME, PASSWORD);
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT r.id, r.room_number, r.room_type, r.description, r.price_per_night, r.img
                FROM rooms r
                WHERE r.id = :room_id";
        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->execute();
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$room) {
            die("Room not found.");
        }

        // Calculate total cost
        $startDate = new DateTime($checkin_date);
        $endDate = new DateTime($checkout_date);
        $interval = $startDate->diff($endDate);
        $number_of_nights = $interval->days;
        $totalCost = $room['price_per_night'] * $number_of_nights;
        $totalCostFormatted = number_format($totalCost, 2);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    ?>

    <div class="form-container">
        <form action="process_booking.php" method="POST">
            <input type="hidden" name="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>">
            <input type="hidden" name="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>">
            <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room_id); ?>">

            <h2>Room Details</h2>
            <img src="<?php echo htmlspecialchars($room['img']); ?>" alt="Room Image">
            <p><strong>Type:</strong> <?php echo htmlspecialchars($room['room_type']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($room['description']); ?></p>
            <p><strong>Price per Night:</strong> $<?php echo htmlspecialchars($room['price_per_night']); ?></p>
            <p><strong>Total Cost:</strong> $<?php echo $totalCostFormatted; ?></p>

            <h2>Your Details</h2>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>

            <input type="submit" value="Submit Booking">
        </form>
    </div>
</body>
</html>
