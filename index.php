<?php
require('helpers.php');
$page_title = 'Интернет-аукцион YetiCave';
$is_auth = rand(0, 1);
$user_name = 'Андрей'; // укажите здесь ваше имя

function format_price($lot_price)
{
    $rounded_price = ceil($lot_price);
    if ($rounded_price < 1000) {
        $displayed_price = $rounded_price;
    } else {
        $displayed_price = number_format($rounded_price, 0, ',', ' ');
    }
    return $displayed_price . ' ₽';
}

/*  Returns the number of hours and minutes left until $expiry_date
    as an array of strings in the format ['hh', 'mm'] */
function get_time_to_expiry(string $expiry_date): array
{
    $now = date('Y-m-d H:i');
    $diff = strtotime($expiry_date) - strtotime($now);
    if ($diff > 0) {
        $hours = floor($diff/(60*60));
        $minutes = floor(($diff - ($hours*60*60))/60);
        $timer = [$hours, $minutes];

        // padding single-digit timer values to get double digits, i.e. '0:8' to '00:08'
        foreach ($timer as $key => $value) {
            if ($value < 0) {
                $value = 0;
            }
            $timer[$key] = str_pad(strval($value), 2, '0', STR_PAD_LEFT);
        }
        return $timer;
    } else {
        return ['00', '00'];
    }
}

// Define constants for connecting with database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'yeticave');


//Create connection
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn == false)
{
    print('Ошибка подключения: ' . mysqli_connect_error());
}

//Set correct encoding
mysqli_set_charset($conn, 'utf8');

// Selecting lots for front page
$sql = "SELECT
  lots.name,
  lots.img_url,
  lots.initial_price,
  categories.name AS category,
  lots.date_expiry AS date_expiry
FROM
  lots
  INNER JOIN categories ON lots.category_id = categories.id
WHERE
  lots.winner_id IS NULL
  AND lots.date_expiry > NOW()
GROUP BY
  lots.id
ORDER BY
   lots.date_created DESC";

//Result
$result = mysqli_query($conn, $sql);
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

//Selecting categories
$sql = "
    SELECT
        categories.name,
        categories.code
    FROM
        categories";

//Result
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$content = include_template('main.php', ['categories' => $categories, 'lots' => $lots]);
$layout_template = include_template('layout.php', [
    'content' => $content,
    'page_title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);
print $layout_template;
