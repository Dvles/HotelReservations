<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/grids.css">
    <link rel="stylesheet" href="./styles/slider.css">
   
    <title>ROOLS</title>
</head>
<body>

    <?php
    $pageTitle= "Discover rooms";
    include "./db/config.php";
    include_once "./includes/nav.php";
    include_once "./includes/slider.php";

    // Get filter values from the request
    $filterType = isset($_GET['type']) ? $_GET['type'] : '';
    $filterPriceMin = isset($_GET['price_min']) ? $_GET['price_min'] : '';
    $filterPriceMax = isset($_GET['price_max']) ? $_GET['price_max'] : '';

    // connecting to DB & display rooms
    try {
        $cnx = new PDO (DSN,USERNAME,PASSWORD);
    } catch (Exception $e) {
        print ("error loading page");
        print $e;
        die();
    }
    // Build the SQL query with filters
    $sql = "SELECT * FROM rooms WHERE 1=1"; // Start with a base query

    if ($filterType) {
        $sql .= " AND room_type = :type";
    }
    if ($filterPriceMin) {
        $sql .= " AND price_per_night >= :price_min";
    }
    if ($filterPriceMax) {
        $sql .= " AND price_per_night <= :price_max";
    }

    $sql .= " ORDER BY id";

    $stmt = $cnx->prepare($sql);

    // Bind filter values if they are set
    if ($filterType) {
        $stmt->bindParam(':type', $filterType);
    }
    if ($filterPriceMin) {
        $stmt->bindParam(':price_min', $filterPriceMin);
    }
    if ($filterPriceMax) {
        $stmt->bindParam(':price_max', $filterPriceMax);
    }

    $stmt->execute();
    $arrayRooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <!-- Filter Form -->
    <div class="filter-container">
        <form method="GET" action="">
            <div class="filter-group">
                <label for="type">Room Type:</label>
                <select id="type" name="type">
                    <option value="">All Types</option>
                    <option value="single" <?php echo $filterType === 'single' ? 'selected' : ''; ?>>Single</option>
                    <option value="double" <?php echo $filterType === 'double' ? 'selected' : ''; ?>>Double</option>
                    <option value="ensuite" <?php echo $filterType === 'ensuite' ? 'selected' : ''; ?>>Ensuite</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="price_min">Min Price:</label>
                <input type="number" id="price_min" name="price_min" value="<?php echo htmlspecialchars($filterPriceMin); ?>">
            </div>
            <div class="filter-group">
                <label for="price_max">Max Price:</label>
                <input type="number" id="price_max" name="price_max" value="<?php echo htmlspecialchars($filterPriceMax); ?>">
            </div>
            <button type="submit">Apply Filters</button>
        </form>
    </div>

    <!-- Display Rooms -->
    <div class="roomContainer">
        <?php foreach ($arrayRooms as $rooms): ?>
            <div class='roomGrid'>
                <img src='<?php echo htmlspecialchars($rooms['img']); ?>' alt='Room Image'>
                <h3><?php echo htmlspecialchars($rooms['room_type']); ?></h3>
                <p><span><?php echo htmlspecialchars($rooms['price_per_night']); ?>$ </span>/night</p>
                <p><?php echo htmlspecialchars($rooms['description']); ?></p>
                <a href=''><button>Book Now</button></a>
            </div>
        <?php endforeach; ?>
    </div>

    </body>
    </html>