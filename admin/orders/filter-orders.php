<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST["filter-txt"];

    $sql = "SELECT o.orders_id, o.user_id, o.order_total, o.delivery_status_id, o.order_time,
                od.hoTen, od.SDT, od.address, od.order_info,
                u.user_name,
                ds.delivery_status_name
            FROM orders o
            JOIN order_des od ON o.orders_id = od.orders_id
            JOIN users u ON o.user_id = u.user_id
            JOIN delivery_status ds ON o.delivery_status_id = ds.delivery_status_id
            WHERE o.orders_id LIKE '%$searchTerm%'
               OR od.SDT LIKE '%$searchTerm%'
               OR od.hoTen LIKE '%$searchTerm%'
               OR od.order_info LIKE '%$searchTerm%'
            ORDER BY o.order_time DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="order-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th class="title-colum">Mã Đơn Hàng</th>';
        echo '<th class="title-column">Họ Tên</th>';
        echo '<th class="title-column">SDT</th>';
        echo '<th class="title-column">Địa Chỉ</th>';
        echo '<th class="title-column">Chi Tiết Đơn Hàng</th>';
        echo '<th class="title-column">Tổng Tiền</th>';
        echo '<th class="title-column">Thời Gian Đặt</th>';
        echo '<th class="title-column">Trạng Thái</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td class="name-column">' . $row["orders_id"] . '</td>';
            echo '<td class="name-column">' . $row["hoTen"] . '</td>';
            echo '<td class="name-column">' . $row["SDT"] . '</td>';
            echo '<td class="name-column">' . $row["address"] . '</td>';
            echo '<td class="action-colum">' . $row["order_info"] . '</td>';
            echo '<td class="total-column">' . $row["order_total"] . '</td>';
            echo '<td class="time-column">' . $row["order_time"] . '</td>';
            echo '<td class="status-column">' . $row["delivery_status_name"] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Không có kết quả nào phù hợp.</p>';
    }
}

$conn->close();
?>
