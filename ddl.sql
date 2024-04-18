CREATE TABLE Users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    UserType ENUM('Client', 'Seller') NOT NULL,
    UNIQUE (email) -- Ensure uniqueness of email
);
CREATE TABLE Clients (
    userId INT PRIMARY KEY,
    city VARCHAR(100),
    state VARCHAR(50),
    phone_number VARCHAR(20),
    FOREIGN KEY (userId) REFERENCES Users(userId) ON DELETE CASCADE
);
CREATE TABLE Departments (
    departmentId INT AUTO_INCREMENT PRIMARY KEY,
    departmentName VARCHAR(255) NOT NULL
);
CREATE TABLE Products (
    productId INT AUTO_INCREMENT PRIMARY KEY,
    sellerId INT,
    productName VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    departmentId INT,
    image varchar(50) NOT NULL,
    FOREIGN KEY (sellerId) REFERENCES Users(userId),
    FOREIGN KEY (departmentId) REFERENCES Departments(departmentId)
);
CREATE TABLE PaymentCards (
    cardId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    cardNumber VARCHAR(20) NOT NULL,
    expiryYear INT NOT NULL,
    expiryMonth VARCHAR(10) NOT NULL,
    CVV VARCHAR(4) NOT NULL,
    billingAddress VARCHAR(255) NOT NULL,
    FOREIGN KEY (userId) REFERENCES Clients(userId)
);
CREATE TABLE Payments (
    paymentId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    cardId INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES Clients(userId),
    FOREIGN KEY (cardId) REFERENCES PaymentCards(cardId)
);
-- Table to store products added to the user's cart.
CREATE TABLE Cart (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    productId INT,
    quantity INT NOT NULL, 
    unitPrice DECIMAL(10, 2) NOT NULL, 
    FOREIGN KEY (userId) REFERENCES Clients(userId),
    FOREIGN KEY (productId) REFERENCES Products(productId)
);
-- Table to store orders placed by users.
CREATE TABLE Orders (
    orderId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    orderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    totalPrice DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered') DEFAULT 'pending',
    shippingAddress VARCHAR(255),
    cardId INT,
    FOREIGN KEY (userId) REFERENCES Clients(userId),
    FOREIGN KEY (cardId) REFERENCES PaymentCards(cardId)
);
-- Table to store detailed information about the products included in each order.
CREATE TABLE OrderDetails (
    orderDetailId INT AUTO_INCREMENT PRIMARY KEY,
    orderId INT,
    productId INT,
    quantity INT NOT NULL, 
    unitPrice DECIMAL(10, 2) NOT NULL, 
    FOREIGN KEY (orderId) REFERENCES Orders(orderId),
    FOREIGN KEY (productId) REFERENCES Products(productId)
);
CREATE TABLE ProductDiscounts (
    productId INT,
    discount INT,
    FOREIGN KEY (productId) REFERENCES Products(productId)
 );