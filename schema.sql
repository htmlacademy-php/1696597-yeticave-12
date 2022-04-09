CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users(
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(50) NOT NULL UNIQUE,
  username VARCHAR(50) NOT NULL UNIQUE,
  user_password VARCHAR(255),
  contacts VARCHAR(255)
);

CREATE UNIQUE INDEX user_email_idx ON users(email);
CREATE UNIQUE INDEX user_name_idx ON users(username);

CREATE TABLE category(
  category_id INT PRIMARY KEY AUTO_INCREMENT,
  name_category VARCHAR(30) NOT NULL UNIQUE,
  code_category VARCHAR(30) NOT NULL UNIQUE
);

CREATE UNIQUE INDEX category_name_idx ON category(name_category);
CREATE UNIQUE INDEX category_code_idx ON category(code_category);

CREATE TABLE lot(
  lot_id INT PRIMARY KEY AUTO_INCREMENT,
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name_lot VARCHAR(50) NOT NULL,
  description_lot VARCHAR(50),
  img_url_lot VARCHAR(50),
  initial_price_lot DECIMAL(10,2),
  expiry_date_lot TIMESTAMP,
  bidding_increment DECIMAL(10, 2),
  
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
  winner_id INT,
  FOREIGN KEY (winner_id) REFERENCES users(user_id) ON DELETE SET NULL,
  category_id INT,
  FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE SET NULL
);

CREATE INDEX lot_name_idx ON lot(name_lot);

CREATE TABLE bid(
  bid_id INT PRIMARY KEY AUTO_INCREMENT,
  date_bid TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  price_bid DECIMAL(10,2),

  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
  lot_id INT,
  FOREIGN KEY (lot_id) REFERENCES lot(lot_id) ON DELETE CASCADE
);
