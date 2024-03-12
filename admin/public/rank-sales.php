<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

$sql = "SELECT od.order_info
        FROM order_des od
        INNER JOIN orders o ON od.orders_id = o.orders_id
        WHERE od.order_info LIKE '%<strong>%' AND o.delivery_status_id = 4";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $grandTotalQuantity = 0;
    $quantityMap = array();

    while ($row = $result->fetch_assoc()) {
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

    arsort($quantityMap);
    $topProducts = array_slice($quantityMap, 0, 3);

    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th colspan="3" class="title-sales">Sản Phẩm Bán Chạy</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($topProducts as $productName => $quantity) {
        $productInfoSql = "SELECT * FROM products WHERE product_name = '$productName'";
        $productInfoResult = $conn->query($productInfoSql);

        if ($productInfoResult->num_rows > 0) {
            $productInfo = $productInfoResult->fetch_assoc();
            echo '<tr>';
            echo '<td><img src="productAD/uploads/' . htmlspecialchars($productInfo['product_img']) . '" alt="Image of ' . htmlspecialchars($productName) . '" width="50"></td>';
            echo '<td class="name-sales">' . $productName . '</td>';
            echo '</tr>';
        }
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo "Không có sản phẩm nào bán chạy!!!";
}

$conn->close();
?>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }

    .title-sales {
        padding: 10px 0px 20px 0;
    }

    tbody img {
        width: 95px;
        border-radius: 10px;
    }

    .name-sales {
        font-weight: 700;
    }
</style>