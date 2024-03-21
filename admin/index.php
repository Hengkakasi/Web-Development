<?php 
//embed PHP code from another file
require_once 'config/connect.php';
require_once 'config/confirmLogin.php';

//before access admin page need to login first 
if(isset($_SESSION["Uid"])){
   $admin_name = $_SESSION["Uid"];
}else{
   header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/styless.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="icon" href="image/logo-bg.png" type="image/x-icon">
    <title>Secangkir Dashboard</title>

    <style>
        .total-payment {
            position: relative;
            cursor: pointer;
        }

        .tooltip-popup {
            display: none;
            position: fixed;
            z-index: 1;
            opacity: 0;
            transition: opacity 0.3s;
            background-color: #ffffff;
            color: #000000;
            padding: 8px;
            border-radius: 4px;
            white-space: nowrap;
            text-align: center;
        }

    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index.php" class="logo">
            <img style="height: 36px; width: 36px;" src="image/logo-bg.png">
            <div class="logo-name"><span>Secangkir</span>Cafe</div>
        </a>
        <ul class="side-menu">
            <li class="active"><a href="index.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="menulist.php"><i class='bx bx-coffee'></i>Menu</a></li>
            <li><a href="order.php"><i class='bx bx-receipt'></i>Orders</a></li>
            <li><a href="customer.php"><i class='bx bx-user'></i>Customer List</a></li>
            <li><a href="reports.php"><i class='bx bx-bar-chart-alt-2'></i>Report</a></li>
            <li><a href="profile.php"><i class='bx bx-id-card'></i>Profile Setting</a></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="index.php" class="notif">
                <i class='bx bx-bell'></i>
            </a>
            <a href="profile.php" class="profile">
                <img src="image/logo-bg.png">
            </a>
        </nav>

        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                </div>
                <a href="reports.php" class="report">
                    <i class='bx bxs-report'></i>
                    <span>View Report</span>
                </a>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3 style="text-align: center;">
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "secangkir";

                            // Create connection
                            $connection = new mysqli($servername, $username, $password, $database);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Query to count the number of orders
                            $sql = "SELECT COUNT(order_id) AS total_orders
                                    FROM orders";
                            $result = $connection->query($sql);

                            if ($result) {
                                // Fetch the result as an associative array
                                $row = $result->fetch_assoc();

                                // Access the total orders value
                                $totalOrders = $row['total_orders'];
                            
                                // Output the total orders
                                echo "$totalOrders";
                            } else {
                                echo "Error: " . $connection->error;
                            }

                            // Close connection
                            $connection->close();
                        ?>
                        </h3>
                        <p style="text-align: center;">Total Orders</p>
                    </span>
                </li>
                <li><i class='bx bx-check-double'></i>
                    <span class="info">
                        <h3 style="text-align: center;">
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "secangkir";

                            // Create connection
                            $connection = new mysqli($servername, $username, $password, $database);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Query to sum the number of complete orders
                            $sql = "SELECT SUM(CASE WHEN order_status = 'complete' THEN 1 ELSE 0 END) AS total_complete_orders
                                    FROM orders";
                            $result = $connection->query($sql);

                            if ($result) {
                                // Fetch the result as an associative array
                                $row = $result->fetch_assoc();

                                // Access the total complete orders value
                                $totalCompleteOrders = $row['total_complete_orders'];
                            
                                // Output the total complete orders
                                echo "$totalCompleteOrders";
                            } else {
                                echo "Error: " . $connection->error;
                            }

                            // Close connection
                            $connection->close();
                        ?>

                        </h3>
                        <p style="text-align: center;">Completed Orders</p>
                    </span>
                </li>
                <li><i class='bx bx-user'></i>
                    <span class="info">
                        <h3 style="text-align: center;">
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "secangkir";

                            // Create connection
                            $connection = new mysqli($servername, $username, $password, $database);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Query to count the number of customers
                            $sql = "SELECT COUNT(customer_id) AS total_customers
                                    FROM customer";
                            $result = $connection->query($sql);

                            if ($result) {
                                // Fetch the result as an associative array
                                $row = $result->fetch_assoc();

                                // Access the total customers value
                                $totalCustomers = $row['total_customers'];
                            
                                // Output the total customers
                                echo "$totalCustomers";
                            } else {
                                echo "Error: " . $connection->error;
                            }

                            // Close connection
                            $connection->close();
                        ?>
                        </h3>
                        <p style="text-align: center;">Total Customer</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3 style="text-align: center;">
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "secangkir";

                            // Create connection
                            $connection = new mysqli($servername, $username, $password, $database);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Query to sum total_amount from payment table
                            $sql = "SELECT SUM(total_amount) AS total_sum FROM payment";
                            $result = $connection->query($sql);

                            if ($result) {
                                // Fetch the result as an associative array
                                $row = $result->fetch_assoc();

                                // Access the total_sum value
                                $totalSum = $row['total_sum'];
                            
                                // Output the total sum
                                echo "RM $totalSum";
                            } else {
                                echo "Error: " . $connection->error;
                            }

                            // Close connection
                            $connection->close();
                        ?>
                        </h3>
                        <p style="text-align: center;">Total Sales</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-timer'></i>
                        <h3>Preparing and In Queue Orders</h3>
                    </div>
                    <table>
                        <thead>
                            <tr class="center-text">
                                <th>Customer Name</th>
                                <th>Food Name + Quantity</th>
                                <th>Total Quantity</th>
                                <th>Remark</th>
                                <th>Take Note</th>
                                <th>Total Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "secangkir";

                            // Create connection
                            $connection = new mysqli($servername, $username, $password, $database);

                            // Check connection
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                                                // Update order status
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
                                $order_id = $_POST['order_id'];
                                $order_status = $_POST['order_status'];
                            
                                $updateQuery = "UPDATE ORDERS SET order_status='$order_status' WHERE order_id='$order_id'";
                                $result = $connection->query($updateQuery);
                            
                                if (!$result) {
                                    echo "Failed to update order status: " . $connection->error;
                                }
                            }

                            // Query to retrieve order and payment information
                            $query = "SELECT 
                                        o.order_id,
                                        c.customer_name,
                                        GROUP_CONCAT(CONCAT(f.food_name, ' x', oi.quantity) SEPARATOR '<br> ') AS food_and_quantity,
                                        SUM(oi.quantity) AS total_quantity,
                                        o.remark,
                                        o.take_meal,
                                        p.total_amount AS total_payment,
                                        p.payment_time,
                                        pm.paymentMethod_name AS payment_method,
                                        o.order_status
                                    FROM 
                                        orders o
                                        JOIN customer c ON o.customer_id = c.customer_id
                                        JOIN orderitems oi ON o.order_id = oi.order_id
                                        JOIN food f ON oi.food_id = f.food_id
                                        LEFT JOIN payment p ON o.order_id = p.order_id
                                        LEFT JOIN paymentmethod pm ON p.paymentMethod_id = pm.paymentMethod_id
                                    WHERE
                                        o.order_status IN ('in queue', 'preparing')
                                    GROUP BY 
                                        o.order_id
                                    ORDER BY
                                        CASE
                                            WHEN o.order_status = 'preparing' THEN 1
                                            WHEN o.order_status = 'in queue' THEN 2
                                        END";
                            $result = $connection->query($query);
                        
                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }
                        
                            // Loop through the rows of the result
                            while ($row = $result->fetch_assoc()) {
                                $order_id = $row["order_id"];
                                $customer_name = $row["customer_name"];
                                $food_and_quantity = $row["food_and_quantity"];
                                $total_quantity = $row["total_quantity"];
                                $remark = $row["remark"];
                                $take_meal = $row["take_meal"];
                                $total_payment = $row["total_payment"];
                                $order_status = $row["order_status"];
                                $payment_time = $row["payment_time"];
                                $payment_method = $row["payment_method"];
                            
                                echo "<tr>";
                                echo "<td>$customer_name</td>";
                                echo "<td>$food_and_quantity</td>";
                                echo "<td>$total_quantity</td>";
                                echo "<td>$remark</td>";
                                echo "<td>$take_meal</td>";
                                echo "<td class='total-payment' onmouseover='showPaymentTooltip(this)' onmouseout='hidePaymentTooltip()' data-payment-time='$payment_time' data-payment-method='$payment_method'>$total_payment</td>";
                                echo "<td class='status-cell' data-order-id='$order_id' data-status='$order_status'>";
                                echo "<span class='status $order_status'>$order_status</span>";
                                    
                                // <!-- Dropdown list -->
                                echo"<div class='status-dropdown' style='display: none;'>";
                                echo"<form method='post' action=''>";
                                echo"<select name='order_status'>";
                                echo"<option value='in queue' ".($order_status == 'in queue' ? 'selected' : '').">In Queue</option>";
                                echo"<option value='preparing' " .($order_status == 'preparing' ? 'selected ' : ''). "> Preparing</option>";
                                echo"<option value='complete' ".($order_status == 'complete' ? 'selected' : '').">Complete</option>";
                                echo"</select>";
                                echo"<input type='hidden' name='order_id' value='$order_id'>";
                                echo"<button type='submit' name='update_status' class='update-status-btn'>Update</button>";
                                echo"</form>";
                                echo"</div>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bottom-data">
            <div class="reminders">
                <div class="header">
                        <i class='bx bxs-pie-chart-alt-2'></i>
                        <h3>Number Of Food In Each Categories</h3>
                    </div>

                    <?php 
                    //embed PHP code from another file
                    require_once 'config/connect.php';

                    // Fetch food category data
                    $query = "SELECT c.category_name, COUNT(f.food_id) AS food_count
                              FROM category c
                              LEFT JOIN food f ON c.category_id = f.category_id
                              GROUP BY c.category_name";

                    $result = $connection->query($query);

                    if (!$result) {
                        die("Invalid query: " . $connection->error);
                    }

                    // Fetch data and prepare for JavaScript
                    $data = array();
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    ?>

                    <!-- Pie chart canvas -->
                    <canvas id="foodCategoryChart" width="100px" height="100px"></canvas>

                    <script>
                        // Use PHP data in JavaScript
                        const categoryLabels = <?php echo json_encode(array_column($data, 'category_name')); ?>;
                        const foodCounts = <?php echo json_encode(array_column($data, 'food_count')); ?>;
                                    
                        const foodCategoryChartCanvas = document.getElementById('foodCategoryChart').getContext('2d');
                                    
                        new Chart(foodCategoryChartCanvas, {
                            type: 'pie',
                            data: {
                                labels: categoryLabels,
                                datasets: [{
                                    data: foodCounts,
                                    backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12'], // Add more colors if needed
                                }],
                            },
                        });
                    </script>
                </div>

                <div class="reminders">
                    <div class="header">
                        <i class='bx bx-line-chart'></i>
                        <h3>Total Income</h3>
                    </div>
                    
                    <canvas id="incomeLineChart" width="400px" height="400px"></canvas>

                    <?php
                    // Query to get the total income for each date
                    $query = "SELECT DATE(payment_time) AS payment_date, 
                                     SUM(total_amount) AS total_income
                              FROM payment
                              GROUP BY DATE(payment_time)";

                    $result = $connection->query($query);

                    if (!$result) {
                        die("Invalid query: " . $connection->error);
                    }
                
                    // Fetch data and prepare for JavaScript
                    $data = array();
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    ?>

                    <script>
                        // Use PHP data in JavaScript
                        const paymentDates = <?php echo json_encode(array_column($data, 'payment_date')); ?>;
                        const totalIncome = <?php echo json_encode(array_column($data, 'total_income')); ?>;
                
                        const incomeLineChartCanvas = document.getElementById('incomeLineChart').getContext('2d');
                
                        new Chart(incomeLineChartCanvas, {
                            type: 'line',
                            data: {
                                labels: paymentDates,
                                datasets: [{
                                    label: 'Total Income',
                                    data: totalIncome,
                                    borderColor: '#3498db', // Line color for Total Income
                                    fill: false,
                                }],
                            },
                        });
                    </script>

                    <?php
                    // Close connection
                    $connection->close();
                    ?>
                </div>
            </div>

        </main>

    </div>

    <div class="tooltip-popup" id="paymentTooltip"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var statusCells = document.querySelectorAll('.status-cell');

            statusCells.forEach(function (statusCell) {
                statusCell.addEventListener('click', function (event) {
                    event.stopPropagation(); // Prevent the click event from propagating

                    // Hide all other dropdowns
                    hideAllDropdowns();

                    // Show the dropdown for the clicked row
                    var dropdown = statusCell.querySelector('.status-dropdown');
                    dropdown.style.display = 'block';
                });
            });

            document.addEventListener('click', function (event) {
                // Hide dropdowns when clicking outside of them
                hideAllDropdowns();
            });

            function hideAllDropdowns() {
                var dropdowns = document.querySelectorAll('.status-dropdown');
                dropdowns.forEach(function (dropdown) {
                    dropdown.style.display = 'none';
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            var totalPaymentCells = document.querySelectorAll('.total-payment');

            totalPaymentCells.forEach(function (totalPaymentCell) {
                totalPaymentCell.addEventListener('mouseover', function () {
                    showPaymentTooltip(totalPaymentCell);
                });

                totalPaymentCell.addEventListener('mouseout', function () {
                    hidePaymentTooltip();
                });
            });
        });

        function showPaymentTooltip(element) {
            var paymentTime = element.getAttribute('data-payment-time');
            var paymentMethod = element.getAttribute('data-payment-method');
            var tooltipContent = "Payment Date: " + paymentTime + "<br>Payment Method: " + paymentMethod;

            var tooltipPopup = document.getElementById('paymentTooltip');
            tooltipPopup.innerHTML = tooltipContent;

            var rect = element.getBoundingClientRect();
            var tooltipWidth = tooltipPopup.offsetWidth;
            var tooltipHeight = tooltipPopup.offsetHeight;

            var leftOffset = rect.left + (rect.width / 2) - (tooltipWidth / 2);
            var topOffset = rect.bottom;

            tooltipPopup.style.top = topOffset + 'px';
            tooltipPopup.style.left = leftOffset + 'px';

            tooltipPopup.style.display = 'block';
            tooltipPopup.style.opacity = 1;
        }

        function hidePaymentTooltip() {
            var tooltipPopup = document.getElementById('paymentTooltip');
            tooltipPopup.style.display = 'none';
            tooltipPopup.style.opacity = 0;
        }
    </script>

    <script src="index.js"></script>
</body>

</html>