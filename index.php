<?php

require_once('constants.php');
require('helpers.php');
require_once('db_functions.php');
$page_title = 'Интернет-аукцион YetiCave';

// Temporary placeholder -- authorization to be implemented later
$is_auth = rand(0, 1);
$user_name = 'Андрей';

function format_price($lot_price): string
{
    $rounded_price = ceil($lot_price);
    if ($rounded_price < 1000) {
        $displayed_price = $rounded_price;
    } else {
        $displayed_price = number_format($rounded_price, 0, ',', ' ');
    }
    return $displayed_price . ' ₽';
}

// Create connection and set encoding
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn == false) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');

// Selecting lots for front page
$sql = "SELECT
  yeticave.lots.id,
  yeticave.lots.name,
  yeticave.lots.img_url,
  yeticave.lots.initial_price,
  yeticave.categories.name AS category,
  yeticave.lots.date_expiry AS date_expiry
FROM
  yeticave.lots
  INNER JOIN yeticave.categories ON lots.category_id = categories.id
WHERE
  lots.winner_id IS NULL
  AND lots.date_expiry > NOW()
GROUP BY
  lots.id
ORDER BY
   lots.date_created DESC";
$result = mysqli_query($conn, $sql);
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get names and codes of categories for main content template and for layout template
$categories = get_categories();

// Closing database connection
mysqli_close($conn);

// Preparing content template and layout template
$content = include_template('main.php', ['categories' => $categories, 'lots' => $lots]);
$layout_template = include_template('layout.php', [
    'content' => $content,
    'page_title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);
print $layout_template;
