<?php
    // Include constants for connecting to database
    require_once('constants.php');
    // Include helper functions
    require_once('helpers.php');
    // Redirect and throw 404 if query has no lot parameter
    if (!isset($_GET['lot_id'])) {
        header('Location: /404.php');
    }
    // Select the lot information matching the query
    $sql = "SELECT l.id,
                l.name,
                l.img_url,
                c.name as category_name,
                l.description,
                l.date_expiry,
                l.initial_price + IFNULL(MAX(b.price), 0)                       AS current_price,
                l.initial_price + IFNULL(MAX(b.price), 0) + l.bidding_increment AS min_bid
            FROM lots as l
                INNER JOIN categories as c ON l.category_id = c.id
                LEFT JOIN bids as b ON l.id = b.lot_id
            WHERE l.id = " . $_GET['lot_id'];

    // Create connection
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // Check for connection errors
    if ($conn == false) {
        print('Ошибка подключения: ' . mysqli_connect_error());
    }
    // Set character encoding for mysqli
    mysqli_set_charset($conn, 'utf8');
    // Create database query object
    $result = mysqli_query($conn, $sql);
    // Obtain array with data from sql query
    $lot = mysqli_fetch_assoc($result);
    // If query result is empty redirect and throw 404
    if ($lot['id'] == '') {
        mysqli_close($conn);
        header('Location: /404.php');
    }
    // Close connection
    mysqli_close($conn);
    // Calculate time to expiry and append it to the data passed to the lot card template
    $lot['time_to_expiry'] = get_time_to_expiry($lot['date_expiry']);
    // Append content of the class to toggle timer color when close to expiry or expired
    if (intval($lot['time_to_expiry'][0]) < 1) {
        $lot['timer_finishing'] = 'timer--finishing';
    } else {
        $lot['timer_finishing'] = '';
    }

    // Prepare to display template
    $lot_template = include_template('lot.php', ['lot' => $lot]);
    // Display the template
    print $lot_template;

