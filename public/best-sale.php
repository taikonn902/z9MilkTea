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

    $topProducts = array_slice($quantityMap, 0, 4);

    foreach ($topProducts as $productName => $quantity) {
        $productInfoSql = $conn->prepare("SELECT p.*, GROUP_CONCAT(ps.product_price ORDER BY ps.size_id SEPARATOR ' - ') AS size_prices
                            FROM products p
                            LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
                            WHERE p.product_name = ?");
        $productInfoSql->bind_param("s", $productName);
        $productInfoSql->execute();
        $productInfoResult = $productInfoSql->get_result();
        
        if ($productInfoResult->num_rows > 0) {
            $productInfo = $productInfoResult->fetch_assoc();
            
            echo '<div class="product-item">';
            echo '<a href="show-detail.php?product_id=' . $productInfo['product_id'] . '" class="container-img">';
            echo "<img class='product-img' src='admin/productAD/uploads/" . htmlspecialchars($productInfo['product_img']) . "' alt='Image of " . htmlspecialchars($productName) . "'>";
            echo '</a>';
            
            echo '<p class="product-name">' . $productName . '</p>';
            echo '<div class="product-des">' . $productInfo['product_des'] . '</div>';
            
            echo '<p class="hot-filter"><i class="fa-solid fa-coins"></i>Best Seller</p>';
            
            // Hiển thị bảng chọn kích thước
            echo '<div class="size-select hidden">';
            $sizeSql = $conn->prepare("SELECT sizes.size_name FROM product_sizes 
                JOIN sizes ON product_sizes.size_id = sizes.size_id 
                WHERE product_sizes.product_id = ?");
            $sizeSql->bind_param("s", $productInfo['product_id']);
            $sizeSql->execute();
            $sizeResult = $sizeSql->get_result();

            while ($sizeRow = $sizeResult->fetch_assoc()) {
                echo '<div class="size-option">' . $sizeRow['size_name'] . '</div>';
            }

            echo '</div>';
                
            echo '<div class="product-action">';
            
            // Hiển thị tất cả giá của sản phẩm
            echo '<div class="product-price">';
            echo !empty($productInfo['size_prices']) ? $productInfo['size_prices'] : $productInfo['product_price'];
            echo '</div>';
            
            echo '<div class="action-add">';
            echo '<button type="submit" class="add-to-cart">';
            echo '<i class="fa-solid fa-cart-shopping"></i>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
} else {
    echo "Không có sản phẩm nào bán chạy!!!";
}

$conn->close();
?>
