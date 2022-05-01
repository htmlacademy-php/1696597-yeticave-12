<?php

require_once('constants.php');
require_once('helpers.php');
require_once('db_functions.php');

// Temporary placeholder -- authorization to be implemented later
$is_auth = rand(0, 1);
$user_name = 'Андрей';

// Prepare content template and layout template
$categories = get_categories();
$content = include_template('404.php');
$layout_template = include_template('layout.php', [
    'content' => $content,
    'page_title' => '404 &ndash Страница не найдена',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);
print $layout_template;
