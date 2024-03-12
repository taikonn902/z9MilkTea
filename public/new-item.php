
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

$sql = "SELECT p.*, GROUP_CONCAT(ps.product_price ORDER BY ps.size_id SEPARATOR ' - ') AS size_prices
        FROM products p
        LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
        GROUP BY p.product_id
        ORDER BY p.create_time DESC
        LIMIT 4";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product-item">';
        echo '<a href="show-detail.php?product_id=' . $row['product_id'] . '" class="container-img">';
        echo "<img class='product-img' src='admin/productAD/uploads/" . htmlspecialchars($row['product_img']) . "' alt='Image of " . htmlspecialchars($row["product_name"]) . "'>";
        echo '</a>';
        echo '<p class="product-name">' . $row['product_name'] . '</p>';
        echo '<div class="product-des">' . $row['product_des'] . '</div>';

        echo '<p class="hot-filter"><i class="fa-solid fa-fire-flame-curved"></i>New</p>';

        echo '<div class="size-select hidden">';
        $productId = $row['product_id'];
        $sizeSql = "SELECT sizes.size_name FROM product_sizes 
                      JOIN sizes ON product_sizes.size_id = sizes.size_id 
                      WHERE product_sizes.product_id = '$productId'";
        $sizeResult = $conn->query($sizeSql);

        while ($sizeRow = $sizeResult->fetch_assoc()) {
            echo '<div class="size-option">' . $sizeRow['size_name'] . '</div>';
        }

        echo '</div>';

        echo '<div class="product-action">';
        echo '<div class="product-price">';
        
        // Kiểm tra xem có giá của kích thước nào không
        if (!empty($row['size_prices'])) {
            echo $row['size_prices'];
        } else {
            echo $row['product_price'];
        }

        echo '</div>';
        echo '<div class="action-add">';
        echo '<button type="submit" class="add-to-cart">';
        echo '<i class="fa-solid fa-cart-shopping"></i>';
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "Không có sản phẩm mới.";
}

$conn->close();
?>

<style>
    .hot-filter {
        font-weight: 800;
        color: #fff;
        border-radius: 10px;
        padding: 10px;
        right: 10px;
        top: 10px;
        background-color: red;
        position: absolute;
        pointer-events: none;
    }

    .hot-filter i {
        margin-right: 5px;
    }
</style>