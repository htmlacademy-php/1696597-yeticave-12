CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  contacts VARCHAR(255) NOT NULL
);

CREATE UNIQUE INDEX user_email_idx ON users(email);
CREATE UNIQUE INDEX user_name_idx ON users(username);

CREATE TABLE categories(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  name VARCHAR(255) NOT NULL UNIQUE,
  code VARCHAR(255) NOT NULL UNIQUE
);

CREATE UNIQUE INDEX category_name_idx ON categories(name);
CREATE UNIQUE INDEX category_code_idx ON categories(code);

CREATE TABLE lots(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  user_id INT NOT NULL,
  category_id INT NOT NULL,
  winner_id INT NULL,
  name VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  img_url VARCHAR(255) NOT NULL,
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  date_expiry TIMESTAMP NOT NULL,
  initial_price DECIMAL(10,2) NOT NULL,
  bidding_increment DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (winner_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
);

CREATE INDEX lot_name_idx ON lots(name);

CREATE TABLE bids(
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  user_id INT NOT NULL,
  lot_id INT NOT NULL,
  date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (lot_id) REFERENCES lots(id) ON DELETE CASCADE
);
