<?php

require_once('constants.php');
require_once('helpers.php');
// Include functions that get data from database for templates
require_once('db_functions.php');

// Temporary placeholder -- authorization to be implemented later
$is_auth = rand(0, 1);
$user_name = 'Андрей';

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
            FROM yeticave.lots as l
                INNER JOIN yeticave.categories as c ON l.category_id = c.id
                LEFT JOIN yeticave.bids as b ON l.id = b.lot_id
            WHERE l.id = " . $_GET['lot_id'];

// Create connection, check for connection error, set encoding, retrieve lot information
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn == false) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');
$result = mysqli_query($conn, $sql);
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

// Get names and codes of categories for layout template
$categories = get_categories();

// Prepare content template and layout template
$content = include_template('lot.php', ['lot' => $lot, 'categories' => $categories]);
$layout_template = include_template('layout.php', [
    'content' => $content,
    'page_title' => $lot['name'],
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);
print $layout_template;
