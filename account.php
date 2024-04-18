<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/styles.css">
    <title>My Account</title>
</head>

<body>
    <div class="topnav">
        <a class="active" href="index.php">Home</a>
        <a href="index.html">About</a>
        <a href="signup.html" class="account">Sign-Up</a>
        <a href="signin.html" class="account">Sign-In</a>
    </div>

    <header style="background-image: url('style/images/img1.jpg');">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>My Profile</h1>
        </div>
    </header>

    <main>
        <section class="customer-details">
            <h2>About Customer</h2>
            <div class="customer-info">
                <div>
                    <h3>Name</h3>
                    <p><?php echo isset($_SESSION['customerName']) ? $_SESSION['customerName'] : 'Customer'; ?></p>
                </div>
                <div>
                    <h3>Gmail</h3>
                    <p><?php echo isset($_SESSION['customerGmail']) ? $_SESSION['customerGmail'] : 'Customer'; ?></p>
                </div>
                <div>
                    <h3>ID</h3>
                    <p><?php echo isset($_SESSION['customerId']) ? $_SESSION['customerId'] : 'N/A'; ?></p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 PROJECT TEAM-1</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>
