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
        'img_url' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => $categories[0],
        'price' => 159999,
        'img_url' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => $categories[1],
        'price' => 8000,
        'img_url' => 'img/lot-3.jpg'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => $categories[2],
        'price' => 10999,
        'img_url' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => $categories[3],
        'price' => 7500,
        'img_url' => 'img/lot-5.jpg'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => $categories[5],
        'price' => 5400,
        'img_url' => 'img/lot-6.jpg'
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

$content = include_template('main.php', ['categories' => $categories, 'lots' => $lots]);
$layout_template = include_template('layout.php', [
    'content' => $content,
    'page_title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);
print $layout_template;
