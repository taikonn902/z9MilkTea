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

$newContent = "";

if ($result->num_rows > 0) {
    $newContent .= '<table class="order-table">';
    $newContent .= '<thead>';
    $newContent .= '<tr>';
    $newContent .= '<th class="title-colum">Tên</th>';
    $newContent .= '<th class="title-column">Tổng Tiền</th>';
    $newContent .= '<th class="title-column">Đơn Hàng</th>';
    $newContent .= '<th class="title-column">Ghi Chú</th>';
    $newContent .= '<th class="time-column">Thời Gian</th>';
    $newContent .= '<th class="title-column">Trạng Thái</th>';
    $newContent .= '</tr>';
    $newContent .= '</thead>';
    $newContent .= '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $newContent .= '<tr>';
        $newContent .= '<td class="name-column">' . $row["hoTen"] . '</td>';
        $newContent .= '<td class="total-column">' . $row["order_total"] . '</td>';
        $newContent .= '<td class="name-column">' . $row["order_info"] . '</td>';
        $newContent .= '<td class="note-column">' . $row["note"] . '</td>';
        $newContent .= '<td class="time-column">' . $row["order_time"] . '</td>';
        $newContent .= '<td class="action-colum">';
        $newContent .= '<select class="delivery-status-select" onchange="update_status(this)" data-order-id="' . $row["orders_id"] . '">';

        $sqlStatus = "SELECT delivery_status_id, delivery_status_name FROM delivery_status";
        $resultStatus = $conn->query($sqlStatus);

        if ($resultStatus->num_rows > 0) {
            while ($statusRow = $resultStatus->fetch_assoc()) {
                $selected = ($statusRow["delivery_status_id"] == $row["delivery_status_id"]) ? "selected" : "";
                $newContent .= '<option value="' . $statusRow["delivery_status_id"] . '" ' . $selected . '>' . $statusRow["delivery_status_name"] . '</option>';
            }
        }

        $newContent .= '</select>';
        $newContent .= '</td>';
        $newContent .= '</tr>';
    }

    $newContent .= '</tbody>';
    $newContent .= '</table>';
} else {
    $newContent .= '<table class="order-table">';
    $newContent .= '<thead>';
    $newContent .= '<tr>';
    $newContent .= '<th class="title-colum">Tên</th>';
    $newContent .= '<th class="title-column">Tổng Tiền</th>';
    $newContent .= '<th class="title-column">Đơn Hàng</th>';
    $newContent .= '<th class="title-column">Ghi Chú</th>';
    $newContent .= '<th class="title-column">Thời Gian</th>';
    $newContent .= '<th class="title-column">Trạng Thái</th>';
    $newContent .= '</tr>';
    $newContent .= '</thead>';
    $newContent .= '<tbody>';
    $newContent .= '<tr><td colspan="6">Chưa có đơn hàng mới nào !!!</td></tr>';
    $newContent .= '</tbody>';
    $newContent .= '</table>';
}

echo $newContent;

$conn->close();
?>
