<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/styles.css">
    <title>Hello world Shop</title>
</head>

<body>
    <div class="topnav">
        <a class="active" href="index.php">Home</a>
        <a href="index.html">About</a>
        <a href="index.html">Categories</a>
        <a href="index.html">offers</a>
        <a href="index.html">shopping cart</a>
        <a href="account.php" class="account">Account</a>
        <a href="signup.html" class="account">Sign-Up</a>
        <a href="signin.html" class="account">Sign-In</a>
    </div>
    <header style="background-image: url('style/images/img1.jpg');">
        <div class="overlay"></div>
        <div class="header-content">
            <h1>HELLO WORLD SHOP-2024</h1>
            <section id="search">
                <input type="text" id="searchInput" placeholder="Search...">
                <button onclick="search()">Search</button>
            </section>
        </div>
    </header>
    <main>
        <section id="slideshow">
            <div class="slideshow-container">
                <div class="mySlides">
                    <img src="style/images/img1.jpg" alt="Image 1">
                </div>
                <div class="mySlides">
                    <img src="style/images/img2.jpg" alt="Image 2">
                </div>
                <div class="mySlides">
                    <img src="style/images/img3.jpg" alt="Image 3">
                </div>
                <div class="mySlides">
                    <img src="style/images/img4.jpg" alt="Image 4">
                </div>
            </div> 
        </section>
        <section id="categories">
            <h2>Categories</h2>
            <div class="category-container">
                <div class="category">
                    <a href="#">
                    <img src="style/images/img1.jpg" alt="Category 1">
                </div>
                <div class="category">
                    <a href="#">
                    <img src="style/images/img2.jpg" alt="Category 2">
                </div>
                <div class="category">
                    <a href="#">
                    <img src="style/images/img2.jpg" alt="Category 2">
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