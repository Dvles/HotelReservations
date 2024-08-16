<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Confirmation</title>
        <link rel="stylesheet" href="./styles/style.css">
        <link rel="stylesheet" href="./styles/form.css">
        <link rel="stylesheet" href="./styles/grids.css">
    </head>
    <body>
        
        <?php include "./includes/nav.php"; 
        
        // Initialize variables with empty values
        $checkin_date = $_POST['checkin_date'] ?? null;
        $checkout_date = $_POST['checkout_date'] ?? null;
        $room_id = $_POST['room_id'] ?? null;
        $room_type = $_POST['room_type'] ?? null;
        $room_price = $_POST['room_price'] ?? null;
        $total_cost = $_POST['total_cost'] ?? null;
        $first_name = $_POST['first_name'] ?? null;
        $last_name = $_POST['last_name'] ?? null;
        $email = $_POST['email'] ?? null;
        $payment_method = $_POST['payment_method'] ?? null;
        
        // Debugging information
        if (empty($checkin_date) || empty($checkout_date) || empty($room_id) || empty($room_type) || empty($room_price) || empty($total_cost) || empty($first_name) || empty($last_name) || empty($email) || empty($payment_method)) {
            die("Invalid request. Please ensure all required parameters are provided.");
        }

        ?>

        <div class="booking-review-container">
            <h2>Booking Confirmation</h2>
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

    <div class="confirmation-message">
        <h3>Functionality Coming Soon</h3>
        <p>Thank you for your reservation! The reservation functionality will be available soon. We will get back to you to confirm your booking and provide further instructions.</p>
        <p>In the meantime, you can <a href="create_account.php">create an account</a> to manage your reservations or <a href="booking.php">make another booking</a>.</p>
    </div>
</div>

</body>
</html>
