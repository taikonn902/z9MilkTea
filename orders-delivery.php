<link rel="shortcut icon" href="images/logo-ico.png" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/custom-scrol.css">

<title>Z9 | Đơn Hàng</title>
<link rel="stylesheet" href="css/style.css">

<?php
    include "public/header.php";
?>

<div class="container-orders-delivery">
    <section class="orders-unfinished">
        <h1>Đơn Hàng Của Bạn</h1>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }        

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "z9milktea";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $sql = "SELECT orders.orders_id, orders.order_total, delivery_status.delivery_status_name,
            order_des.address, order_des.SDT, order_des.hoTen, order_des.order_info
            FROM orders
            JOIN delivery_status ON orders.delivery_status_id = delivery_status.delivery_status_id
            LEFT JOIN order_des ON orders.orders_id = order_des.orders_id
            WHERE orders.user_id = '$user_id' AND orders.delivery_status_id IN (1, 2, 3)";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "
                    <table class='orders-table'>
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Tên</th>
                            <th>Địa Chỉ</th>
                            <th>SDT</th>
                            <th>Đơn Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["orders_id"] . "</td>
                            <td>" . $row["hoTen"] . "</td>
                            <td>" . $row["address"] . "</td>
                            <td>" . $row["SDT"] . "</td>
                            <td>" . $row["order_info"] . "</td>
                            <td>" . $row["order_total"] . "</td>
                            <td>" . $row["delivery_status_name"] . "</td>
                            </tr>";
                }
                echo "</table>";
            } else {
                echo "<table class='orders-table'>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Tên</th>
                        <th>Địa Chỉ</th>
                        <th>SDT</th>
                        <th>Đơn Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                    </tr>
                            
                    <tr><td colspan='7'>Chưa có đơn hàng nào!!!</td></tr>
                </table>";
            }
        } else {
            echo "Chưa đăng nhập.";
        }

        $conn->close();
        ?>
    </section>

    <section class="history-orders">
        <h1>Lịch Sử Đặt Món</h1>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "z9milktea";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $sql = "SELECT orders.orders_id, orders.order_total, delivery_status.delivery_status_name,
            order_des.address, order_des.SDT, order_des.hoTen, order_des.order_info
            FROM orders
            JOIN delivery_status ON orders.delivery_status_id = delivery_status.delivery_status_id
            LEFT JOIN order_des ON orders.orders_id = order_des.orders_id
            WHERE orders.user_id = '$user_id' AND orders.delivery_status_id IN (4, 5)";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "
                    <table class='orders-history-table'>
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Tên</th>
                            <th>Địa Chỉ</th>
                            <th>SDT</th>
                            <th>Đơn Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["orders_id"] . "</td>
                            <td>" . $row["hoTen"] . "</td>
                            <td>" . $row["address"] . "</td>
                            <td>" . $row["SDT"] . "</td>
                            <td>" . $row["order_info"] . "</td>
                            <td>" . $row["order_total"] . "</td>
                            <td>" . $row["delivery_status_name"] . "</td>
                            </tr>";
                }
                echo "</table>";
            } else {
                echo "<table class='orders-history-table'>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Tên</th>
                        <th>Địa Chỉ</th>
                        <th>SDT</th>
                        <th>Đơn Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                    </tr>
                            
                    <tr><td colspan='7'>Chưa có đơn hàng nào!!!</td></tr>
                </table>";
            }
        } else {
            echo "Chưa đăng nhập.";
        }

        $conn->close();
        ?>
    </section>
</div>

<style>
    .container-orders-delivery {
        width: 90%;
        margin: 0px auto;
    }

    .orders-unfinished {
        margin-top: 30px;
        text-align: center;
    }

    .orders-unfinished h1,
    .history-orders h1 {
        font-size: 25px;
        font-weight: 800;
    }

    /* style.css */
    .orders-table,
    .orders-history-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .orders-table th,
    .orders-history-table th {
        background-color: #FFD400;
    }

    .orders-table th,
    .orders-table td,
    .orders-history-table th,
    .orders-history-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    /* Thanh trượt cho bảng */
    .orders-history-table {
        max-height: 450px;
        overflow-y: auto;
    }

    .orders-history-table::-webkit-scrollbar {
        width: 5px;
    }

    .orders-history-table::-webkit-scrollbar-thumb {
        background-color: #007BFF;
        border-radius: 10px;
    }

    .orders-history-table::-webkit-scrollbar-track {
        background-color: #E0E0E0;
        border-radius: 10px;
    }

    .history-orders {
        margin: 30px 0;
        text-align: center;
    }
</style>