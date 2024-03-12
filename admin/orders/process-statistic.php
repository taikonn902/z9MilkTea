<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    if (!empty($startDate) && !empty($endDate)) {
        // Thống kê đơn hàng và tiền thu được
        $sqlOrderStatistic = "SELECT COUNT(*) AS totalOrders, SUM(order_total) AS totalRevenue
                              FROM orders
                              WHERE delivery_status_id = 4
                              AND order_time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";

        $resultOrderStatistic = $conn->query($sqlOrderStatistic);

        if ($resultOrderStatistic->num_rows > 0) {
            $rowOrderStatistic = $resultOrderStatistic->fetch_assoc();
            $response['totalOrders'] = $rowOrderStatistic['totalOrders'];
            $response['totalRevenue'] = number_format($rowOrderStatistic['totalRevenue'], 2, '.', ',') . 'đ';
        } else {
            $response['totalOrders'] = 0;
            $response['totalRevenue'] = '0đ';
        }

        // Thống kê sản phẩm được mua nhiều và ít nhất
        $sqlProductStatistic = "SELECT od.order_info
                                FROM order_des od
                                INNER JOIN orders o ON od.orders_id = o.orders_id
                                WHERE od.order_info LIKE '%<strong>%' 
                                AND o.delivery_status_id = 4
                                AND o.order_time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
                                
        $resultProductStatistic = $conn->query($sqlProductStatistic);

        if ($resultProductStatistic->num_rows > 0) {
            $grandTotalQuantity = 0;
            $quantityMap = array();

            while ($row = $resultProductStatistic->fetch_assoc()) {
                preg_match_all('/<strong>(.*?)<\/strong>.*?SL:\s*([0-9]+)/', $row['order_info'], $matches, PREG_SET_ORDER);

                foreach ($matches as $match) {
                    $productName = strip_tags($match[1]);
                    $quantity = (int) $match[2];

                    if (isset($quantityMap[$productName])) {
                        $quantityMap[$productName] += $quantity;
                    } else {
                        $quantityMap[$productName] = $quantity;
                    }

                    $grandTotalQuantity += $quantity;
                }
            }

            if (!empty($quantityMap)) {
                arsort($quantityMap);

                $response['topProduct'] = key($quantityMap);
                $response['topProductQuantity'] = current($quantityMap);

                $revenueData = ['labels' => array_keys($quantityMap), 'values' => array_values($quantityMap)];
                $response['revenueData'] = $revenueData;
            } else {
                $response['topProduct'] = '';
                $response['topProductQuantity'] = 0;
            }
        } else {
            $response['topProduct'] = '';
            $response['topProductQuantity'] = 0;
        }
    }
}

echo json_encode($response);
$conn->close();
