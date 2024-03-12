<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"]) && isset($_POST["new_status_id"])) {
    $order_id = $_POST["order_id"];
    $new_status_id = $_POST["new_status_id"];

    //đảm bảo new_status_id là kiểu số
    $new_status_id = intval($new_status_id);

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $updateSql = "UPDATE orders SET delivery_status_id = ? WHERE orders_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("is", $new_status_id, $order_id); // "is" tương ứng với integer và string

    if ($stmt->execute()) {
        echo "Cập nhật thành công!";
    } else {
        echo "Có lỗi khi cập nhật: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
