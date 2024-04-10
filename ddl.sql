Cart

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    zip INT NOT NULL,
    name_on_card VARCHAR(255) NOT NULL,
    card_number BIGINT NOT NULL,
    exp_month VARCHAR(255) NOT NULL,
    exp_year INT NOT NULL,
    cvv INT NOT NULL
);
