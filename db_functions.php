<?php

/**
 * Returns names and codes of categories from database for layout template
 *
 * @return array Names of all categories
 */
function get_categories(): array
{
    // Create connection
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // Check for connection errors
    if ($conn == false) {
        print('Ошибка подключения: ' . mysqli_connect_error());
    }
    // Set character encoding for mysqli
    mysqli_set_charset($conn, 'utf8');

    //Selecting categories
    $sql = "
    SELECT
        yeticave.categories.name,
        yeticave.categories.code
    FROM
        yeticave.categories";

    //Result
    $result = mysqli_query($conn, $sql);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close connection
    mysqli_close($conn);
    return $categories;
}

