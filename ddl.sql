CREATE TABLE Users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    UserType ENUM('Client', 'Seller') NOT NULL,
    UNIQUE (email)
);

CREATE TABLE Clients (
    userId INT PRIMARY KEY,
    city VARCHAR(100),
    state VARCHAR(50),
    phone_number VARCHAR(20),
    FOREIGN KEY (userId) REFERENCES Users(userId) ON DELETE CASCADE
);

CREATE TABLE Brands (
    brandId INT AUTO_INCREMENT PRIMARY KEY,
    brandName VARCHAR(50) NOT NULL
);

CREATE TABLE Products (
    productId INT AUTO_INCREMENT PRIMARY KEY,
    sellerId INT,
    productName VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    brandId INT,
    image VARCHAR(255) NOT NULL,
    Feature VARCHAR(3) NOT NULL default 'yes', 
    FOREIGN KEY (sellerId) REFERENCES Users(userId) ON DELETE CASCADE,
    FOREIGN KEY (brandId) REFERENCES brands(brandId) ON DELETE CASCADE
);

CREATE TABLE PaymentCards (
    cardId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    cardNumber VARCHAR(20) NOT NULL,
    expiryYear INT NOT NULL,
    expiryMonth VARCHAR(10) NOT NULL,
    CVV VARCHAR(4) NOT NULL,
    billingAddress VARCHAR(255) NOT NULL,
    FOREIGN KEY (userId) REFERENCES Clients(userId) ON DELETE CASCADE
);

CREATE TABLE Payments (
    paymentId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    cardId INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES Clients(userId) ON DELETE CASCADE,
    FOREIGN KEY (cardId) REFERENCES PaymentCards(cardId) ON DELETE CASCADE
);

CREATE TABLE Cart (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    productId INT,
    quantity INT NOT NULL, 
    unitPrice DECIMAL(10, 2) NOT NULL, 
    FOREIGN KEY (userId) REFERENCES Clients(userId) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES Products(productId) ON DELETE CASCADE
);

CREATE TABLE Orders (
    orderId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    orderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    totalPrice DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered') DEFAULT 'pending',
    shippingAddress VARCHAR(255),
    FOREIGN KEY (userId) REFERENCES Clients(userId) ON DELETE CASCADE
);

CREATE TABLE OrderDetails (
    orderDetailId INT AUTO_INCREMENT PRIMARY KEY,
    orderId INT,
    productId INT,
    quantity INT NOT NULL, 
    unitPrice DECIMAL(10, 2) NOT NULL, 
    FOREIGN KEY (orderId) REFERENCES Orders(orderId) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES Products(productId) ON DELETE CASCADE
);

CREATE TABLE ProductDiscounts (
    productId INT,
    discount INT,
    FOREIGN KEY (productId) REFERENCES Products(productId) ON DELETE CASCADE
);
