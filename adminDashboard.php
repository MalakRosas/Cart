<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style/AdminDashboard.css">
</head>

<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="style/images/logo.png" alt="Logo">
                    <h2>Lorem<span class="text-muted">ispum</span></h2>
                </div>
                <div class="close" id="btn_close">
                    <i class="material-icons-sharp">close</i>
                </div>
            </div>
            <div class="sidebar">
                <a href="adminDashboard" class="active">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="adminCustomer.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Customers</h3>
                </a>
                <a href="allProducts.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Products</h3>
                </a>
                <a href="adminSeller.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Sellers</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Lorem_ipsum 5</h3>
                </a>
            </div>
        </aside>
        <main>
            <h1>Dashboard</h1>
            <div class="date">
                <input type="date">
            </div>
            <div class="insights">
                <div class="sales">
                    <span class="material-icons-sharp">grid_view</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Lorem_ipsum_b1</h3>
                            <h1>$25.00</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy="38" r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 HOURS</small>
                </div>
                <div class="expenses">
                    <span class="material-icons-sharp">grid_view</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Lorem_ipsum_b2</h3>
                            <h1>$25.00</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy="38" r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 HOURS</small>
                </div>
                <div class="income">
                    <span class="material-icons-sharp">grid_view</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Lorem_ipsum_b3</h3>
                            <h1>$25.00</h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy="38" r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Last 24 HOURS</small>
                </div>
            </div>
            <div class="recent-order">
                <h2>Recent :</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Number</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include('connection.php');
                            // Query to fetch products
                            $sql = "SELECT productName, productId FROM Products";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["productName"] . "</td>";
                                    echo "<td>" . $row["productId"] . "</td>";
                                    echo "<td>Due</td>";
                                    echo "<td class=\"warning\">Pending</td>";
                                    echo "<td class=\"primary\">Details</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>0 results</td></tr>";
                            }
                            $conn->close(); // Close the database connection
                        ?>
                    </tbody>
                </table>
                <a href="#">show All </a>
            </div>
        </main>
        <!-- Right sidebar -->
        <div class="right">
            <!-- Right sidebar content -->
            <div class="top">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-icons-sharp">light_mode</span>
                    <span class="material-icons-sharp active">dark_mode</span>

                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Admin</b></p>
                        <small class="text-muted">Hello world</small>
                    </div>
                    <div class="profile-photo">
                        <img src="style/icon.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

