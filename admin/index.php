<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/custom-scrol.css">
    <link rel="shortcut icon" href="./images/logo-ico.png" type="image/x-icon">

    <title>Z9 | Trang Quản Trị</title>
</head>

<?php
include "./DB-connect/connectDB.php";
?>

<body>
    <?php
    include "public/header-admin.php";
    ?>

    <div class="container-nav">
        <nav class="nav-admin-page">
            <li class="nav-item">
                <i class="fa-solid fa-house"></i>
                <a href="#">Trang Chủ</a>
            </li>
            <li class="dropdown">
                <i class="fa-solid fa-wine-glass"></i>
                <a href="#">Cửa Hàng</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item"><a href="categoryAD/index.php">Loại Sản Phẩm</a></li>
                    <li class="dropdown-item"><a href="productAD/index.php">Sản Phẩm</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <i class="fa-regular fa-calendar"></i>
                <a href="orders/index.php">Đơn Hàng</a>
            </li>
            <li class="nav-item">
                <i class="fa-solid fa-comments"></i>
                <a href="">Bình Luận</a>
            </li>
            <li class="nav-item">
                <i class="fa-solid fa-users"></i>
                <a href="users/index.php">Người Dùng</a>
            </li>

            <li class="nav-item">
                <i class="fa-solid fa-gears"></i>
                <a href="settings/edit-avt.php">Cài Đặt</a>
            </li>

            <li class="nav-item">
                <i class="fa-solid fa-rotate-left"></i>
                <a href="../index.php">về Trang Web</a>
            </li>

            <li class="nav-item">
                <i class="fa-solid fa-right-from-bracket"></i>
                <a href="logout.php">Đăng Xuất</a>
            </li>
        </nav>
    </div>

    <style>
        .left-content-top {
            width: 18%;
        }

        .right-content-top {
            width: 82%;
        }

        .note-column {
            color: #1E90FF;
            font-size: 14px;
            font-weight: 600;
        }

        .time-column {
            width: 120px;
        }
    </style>
    <main id="main-page">
        <div class="container-main-top-page">
            <fieldset class="left-content-top">
                <legend>Thông Tin</legend>

                <div class="shop-des-container">
                    <a href="productAD/index.php"><img class="img-left-content-des" src="./images/img-product-des.png" alt="img"></a>
                    <div class="shop-info">
                        <p>Sản Phẩm</p>
                        <span>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM products";
                            $result = mysqli_query($conn, $query);
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $totalAccounts = $row['total'];
                                echo $totalAccounts;
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>
                        </span>
                    </div>
                </div>

                <div class="shop-des-container">
                    <a href="users/index.php"><img class="img-left-content-des" src="./images/user.png" alt="img"></a>
                    <div class="shop-info">
                        <p>Người Dùng</p>
                        <span>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM users";
                            $result = mysqli_query($conn, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $totalAccounts = $row['total'];
                                echo $totalAccounts;
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>
                        </span>
                    </div>
                </div>

                <div class="shop-des-container">
                    <a href="orders/index.php"><img class="img-left-content-des" src="./images/orders.png" alt="img"></a>
                    <div class="shop-info">
                        <p>Đơn Hàng</p>
                        <span>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM orders";
                            $result = mysqli_query($conn, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $totalAccounts = $row['total'];
                                echo $totalAccounts;
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </fieldset>

            <fieldset class="right-content-top">
                <legend>Đơn Hàng Chờ Xử Lý</legend>

                <div id="right-content-top">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "z9milktea";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"]) && isset($_POST["new_status_id"])) {
                        $order_id = $_POST["order_id"];
                        $new_status_id = $_POST["new_status_id"];

                        $updateSql = "UPDATE orders SET delivery_status_id = ? WHERE orders_id = ?";
                        $stmt = $conn->prepare($updateSql);
                        $stmt->bind_param("ii", $new_status_id, $order_id);
                        $stmt->execute();
                        $stmt->close();
                    }

                    $sql = "SELECT o.orders_id, o.user_id, o.order_total, o.delivery_status_id, o.order_time, o.note,
                                od.hoTen, od.SDT, od.address, od.order_info,
                                u.user_name,
                                ds.delivery_status_name
                                FROM orders o
                                JOIN order_des od ON o.orders_id = od.orders_id
                                JOIN users u ON o.user_id = u.user_id
                                JOIN delivery_status ds ON o.delivery_status_id = ds.delivery_status_id
                                WHERE o.delivery_status_id IN (1, 2, 3)
                                ORDER BY o.order_time ASC";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<table class="order-table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="title-colum">Tên</th>';
                        echo '<th class="title-column">Tổng Tiền</th>';
                        echo '<th class="title-column">Đơn Hàng</th>';
                        echo '<th class="title-column">Ghi Chú</th>';
                        echo '<th class="time-column">Thời Gian</th>';
                        echo '<th class="title-column">Trạng Thái</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="name-column">' . $row["hoTen"] . '</td>';
                            echo '<td class="total-column">' . $row["order_total"] . '</td>';
                            echo '<td class="name-column">' . $row["order_info"] . '</td>';
                            echo '<td class="note-column">' . $row["note"] . '</td>';
                            echo '<td class="time-column">' . $row["order_time"] . '</td>';
                            echo '<td class="action-colum">';
                            echo '<select class="delivery-status-select" onchange="update_status(this)" data-order-id="' . $row["orders_id"] . '">';

                            $sqlStatus = "SELECT delivery_status_id, delivery_status_name FROM delivery_status";
                            $resultStatus = $conn->query($sqlStatus);

                            if ($resultStatus->num_rows > 0) {
                                while ($statusRow = $resultStatus->fetch_assoc()) {
                                    $selected = ($statusRow["delivery_status_id"] == $row["delivery_status_id"]) ? "selected" : "";
                                    echo '<option value="' . $statusRow["delivery_status_id"] . '" ' . $selected . '>' . $statusRow["delivery_status_name"] . '</option>';
                                }
                            }

                            echo '</select>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo '<table class="order-table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="title-colum">Tên</th>';
                        echo '<th class="title-column">Tổng Tiền</th>';
                        echo '<th class="title-column">Đơn Hàng</th>';
                        echo '<th class="title-column">Ghi Chú</th>';
                        echo '<th class="title-column">Thời Gian</th>';
                        echo '<th class="title-column">Trạng Thái</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        echo '<tr><td colspan="6">Chưa có đơn hàng mới nào !!!</td></tr>';
                        echo '</tbody>';
                        echo '</table>';
                    }

                    $conn->close();
                    ?>

                    <!-- script cập nhật đơn hàng và reload bảng đơn hàng mới -->
                    <script>
                        function update_status(select) {
                            var order_id = select.dataset.orderId;
                            var new_status_id = select.value;

                            var xhr = new XMLHttpRequest();

                            xhr.open("POST", "orders/change-orders.php", true);

                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4) {
                                    if (xhr.status == 200) {
                                        var response = xhr.responseText;
                                        console.log(response);

                                        if (response.trim() === "Cập nhật thành công!") {
                                            console.log("Cập nhật thành công!");

                                            location.reload();
                                        } else {
                                            console.log("Có lỗi khi cập nhật: " + response);
                                        }
                                    } else {
                                        console.log("Có lỗi khi gửi yêu cầu: " + xhr.status);
                                    }
                                }
                            };

                            xhr.send("order_id=" + order_id + "&new_status_id=" + new_status_id);
                        }

                        document.addEventListener("DOMContentLoaded", function() {
                            setInterval(reloadFieldsetContent, 20000);
                        });

                        function reloadFieldsetContent() {
                            var elementToReload = document.getElementById('right-content-top');

                            if (elementToReload) {
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        elementToReload.innerHTML = this.responseText;
                                    }
                                };
                                xhttp.open("GET", "public/reload-content.php", true);
                                xhttp.send();
                            }
                        }
                    </script>
                </div>
            </fieldset>
        </div>

        <div class="container-main-bottom-page">
            <fieldset class="left-bottom-content">
                <legend>Thống Kê Doanh Thu</legend>

                <form class="form-statistical" action="orders/process-statistic.php" method="POST">
                    <div class="action-filter">
                        <div class="left-form">
                            <label for="startDate">Ngày bắt đầu:</label>
                            <input type="date" id="startDate" name="startDate" required>
                        </div>

                        <div class="right-form">
                            <label for="endDate">Ngày kết thúc:</label>
                            <input type="date" id="endDate" name="endDate" required>
                        </div>
                    </div>

                    <div class="contaienr-btn">
                        <button class="btn-filter-sale" type="submit">Lọc Thống Kê</button>
                    </div>
                </form>

                <div class="container-content-statistic">
                    <fieldset class="statistic-left">
                        <legend>Tổng Quan</legend>

                        <div class="container-donhang">
                            <p>Số Đơn Hàng</p>
                            <span id="totalOrders">
                                <p>Chưa có thông tin để truy vấn!!!</p>
                            </span>
                        </div>

                        <div class="container-doanhthu">
                            <p>Doanh Thu</p>
                            <span id="formattedTotalRevenue">
                                <p>Chưa có thông tin để truy vấn!!!</p>
                            </span>
                        </div>

                        <div class="container-muanhieunhat">
                            <p>Bán Nhiều Nhất</p>
                            <span id="topProduct">
                                <p>Chưa có thông tin để truy vấn!!!</p>
                            </span>
                            <span id="topProductQuantity"></span>
                            <p id="noOrdersMessage"></p>
                    </fieldset>

                    <fieldset class="statistic-right">
                        <legend>Biểu Đồ</legend>

                        <canvas id="revenueChart" width="400" height="190"></canvas>
                    </fieldset>
                </div>

                <!-- thống kê doanh thu theo ngày, tháng , năm -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelector('.form-statistical').addEventListener('submit', function(event) {
                            event.preventDefault();
                            submitForm();
                        });
                    });

                    function submitForm() {
                        var startDate = document.getElementById('startDate').value;
                        var endDate = document.getElementById('endDate').value;

                        if (startDate !== '' && endDate !== '') {
                            // Sử dụng AJAX để gửi yêu cầu đến process-statistic.php
                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    var result = JSON.parse(xhr.responseText);

                                    document.getElementById('totalOrders').innerText = result.totalOrders;
                                    document.getElementById('formattedTotalRevenue').innerText = result.totalRevenue;

                                    var topProductContainer = document.getElementById('topProduct');
                                    if (result.topProduct !== '') {
                                        var topProductText = result.topProduct + '  ' + result.topProductQuantity + ' ly';
                                        topProductContainer.innerText = topProductText;
                                    } else {
                                        topProductContainer.innerText = 'Chưa có thông tin';
                                    }

                                    drawRevenueChart(result.revenueData);
                                }
                            };

                            xhr.open('POST', 'orders/process-statistic.php', true);
                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            xhr.send('startDate=' + startDate + '&endDate=' + endDate);
                        } else {
                            document.getElementById('formattedTotalRevenue').innerText = '';
                        }
                    }

                    function drawRevenueChart(revenueData) {
                        var ctx = document.getElementById('revenueChart').getContext('2d');

                        var chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: revenueData.labels,
                                datasets: [{
                                    label: 'Số sản phẩm bán ra',
                                    data: revenueData.values,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                </script>
            </fieldset>

            <fieldset class="right-content-bottom">
                <legend>Số Liệu Thống Kê</legend>

                <div class="show-content-sales">
                    <div class="container-conntent-sales">
                        <p class="title-sales">Tổng Doanh Số Bán</p>
                        <span>
                            <?php
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "z9milktea";

                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Kết nối không thành công: " . $conn->connect_error);
                                }

                                $sql = "SELECT SUM(order_total) AS total_order
                                        FROM orders
                                        WHERE delivery_status_id = 4";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $totalOrder = number_format($row['total_order'], 3, '.', '.') . 'đ';

                                    echo '<div class="order-total">';
                                    echo '<p class="total-quantity">' . $totalOrder . '</p>';
                                    echo '</div>';
                                } else {
                                    echo "Không có đơn hàng nào có trạng thái giao hàng là 4.";
                                }

                                $conn->close();
                            ?>
                        </span>
                    </div>

                    <div class="container-rank-sales">
                        <?php
                        include "public/rank-sales.php";
                        ?>
                    </div>

                </div>
            </fieldset>
        </div>
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</html>