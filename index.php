<?php
require('helpers.php');
$page_title = 'Интернет-аукцион YetiCave';
$is_auth = rand(0, 1);
$user_name = 'Андрей'; // укажите здесь ваше имя
$categories = [
    'Доски и лыжи',
    'Крепления',
    'Ботинки',
    'Одеждка',
    'Инструменты',
    'Разное'
];
$lots = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => $categories[0],
        'price' => 10999,
        'img_url' => 'img/lot-1.jpg',
        'expiry_date' => '2022-04-01'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => $categories[0],
        'price' => 159999,
        'img_url' => 'img/lot-2.jpg',
        'expiry_date' => '2022-04-02'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => $categories[1],
        'price' => 8000,
        'img_url' => 'img/lot-3.jpg',
        'expiry_date' => '2022-04-02'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => $categories[2],
        'price' => 10999,
        'img_url' => 'img/lot-4.jpg',
        'expiry_date' => '2022-04-04'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => $categories[3],
        'price' => 7500,
        'img_url' => 'img/lot-5.jpg',
        'expiry_date' => '2022-04-05'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => $categories[5],
        'price' => 5400,
        'img_url' => 'img/lot-6.jpg',
        'expiry_date' => '2022-04-07'
    ],
];

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

$content = include_template('main.php', ['categories' => $categories, 'lots' => $lots]);
$layout_template = include_template('layout.php', [
    'content' => $content,
    'page_title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);
print $layout_template;
