/* Populating table 'users' */
INSERT INTO
  users(
    registration_date,
    email,
    username,
    password,
    contacts
  )
VALUES
  (
    '2022-02-24 03:59',
    'test_email_1@example.com',
    'test_user_1',
    'test_password_1',
    'test contacts 1'
  ),
  (
    '2022-04-01 15:23',
    'test_email_2@example.com',
    'test_user_2',
    'test_password_2',
    'test contacts 2'
  ),
  (
    '2022-04-12 16:38',
    'test_email_3@example.com',
    'test_user_3',
    'test_password_3',
    'test contacts 3'
  );

/* Populating table 'categories' */
INSERT INTO
  categories(name, code)
VALUES
  ('Доски и лыжи', 'skiboards'),
  ('Крепления', 'bindings'),
  ('Ботинки', 'boots'),
  ('Одежда', 'skiwear'),
  ('Инструменты', 'tools'),
  ('Разное', 'misc');

/* Populating table 'lots' */
INSERT INTO
  lots(
    user_id,
    category_id,
    winner_id,
    name,
    description,
    img_url,
    date_created,
    date_expiry,
    initial_price,
    bidding_increment
  )
VALUES
  (
    1,
    1,
    2,
    '2014 Rossignol District Snowboard',
    'description 1',
    'img/lot-1.jpg',
    '2022-04-02 15:00',
    '2022-04-05 15:00',
    10999,
    100
  ),
  (
    1,
    1,
    2,
    'DC Ply Mens 2016/2017 Snowboard',
    'description 2',
    'img/lot-2.jpg',
    '2022-04-03 16:00',
    '2022-04-06 16:00',
    159999,
    100
  ),
  (
    1,
    2,
    2,
    'Крепления Union Contact Pro 2015 года размер L/XL',
    'description 3',
    'img/lot-3.jpg',
    '2022-04-12 17:00',
    '2022-04-15 17:00',
    8000,
    100
  ),
  (
    1,
    NULL,
    NULL,
    'Ботинки для сноуборда DC Mutiny Charocal',
    'description 4',
    'img/lot-4.jpg',
    '2022-04-12 16:30',
    '2022-04-15 16:30',
    10999,
    100
  ),
  (
    1,
    4,
    NULL,
    'Куртка для сноуборда DC Mutiny Charocal',
    'description 5',
    'img/lot-5.jpg',
    '2022-04-10 15:00',
    '2022-04-13 15:00',
    7500,
    100
  ),
  (
    1,
    6,
    NULL,
    'Маска Oakley Canopy',
    'description 6',
    'img/lot-6.jpg',
    '2022-04-12 11:00',
    '2022-04-15 11:00',
    5400,
    100
  );

/* Populating table 'bids' */
INSERT INTO
  bids(user_id, lot_id, date_created, price)
VALUES
  (3, 4, '2022-04-12 16:55', 11000),
  (2, 4, '2022-04-12 16:59', 12599),
  (2, 6, '2022-04-12 17:54', 5500);

/* Showing the names of all categories */
SELECT
  categories.name
FROM
  categories;

/* Showing non-expired lots with no winner assigned, displaying name,
 lot image's URL, initial price, highest bid (if any), category (if any) */
SELECT
  lots.name,
  lots.img_url,
  lots.initial_price,
  IF(
    b.current_max_price IS NOT NULL,
    b.current_max_price,
    lots.initial_price
  ) AS current_price,
  IF(categories.name IS NULL, '—', categories.name) AS category_name
FROM
  lots
  LEFT JOIN (
    SELECT
      lot_id,
      MAX(price) AS current_max_price
    FROM
      bids
    GROUP BY
      lot_id
  ) AS b ON lots.id = b.lot_id
  LEFT JOIN categories ON lots.category_id = categories.id
WHERE
  date_expiry > NOW()
  AND winner_id IS NULL;

/* Showing ID and name of the lot with ID = 5 */
SELECT
  lots.id,
  lots.name
FROM
  lots
WHERE
  lots.id = 5;

/* Updating the name field of lot with ID = 4 */
UPDATE
  lots
SET
  lots.name = '(БЕЗ КАТЕГОРИИ) Ботинки для сноуборда DC Mutiny Charocal'
WHERE
  lots.id = 4;

/* Showing all columns from bids associated with lot with ID = 4
  Grouping the displayed lots by date with later date lots displayed first */
SELECT
  *
FROM
  bids
WHERE
  lot_id = 4
ORDER BY
  date_created DESC;