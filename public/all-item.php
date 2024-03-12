<div class="container-content-list-product">
    <div class="list-product-all-item">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "z9milktea";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Kết nối không thành công: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM products ORDER BY RAND()";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-item">';
                echo '<a href="show-detail.php?product_id=' . $row['product_id'] . '" class="container-img">';
                echo "<img class='product-img' src='admin/productAD/uploads/" . htmlspecialchars($row['product_img']) . "' alt='Image of " . htmlspecialchars($row["product_name"]) . "'>";
                echo '</a>';
                echo '<p class="product-name">' . $row['product_name'] . '</p>';
                echo '<div class="product-des">' . $row['product_des'] . '</div>';

                // echo '<p class="hot-filter"><i class="far fa-copy"></i>Similarity</p>';

                echo '<div class="size-select hidden">';
                $productId = $row['product_id'];
                $sizeSql = $conn->prepare("SELECT sizes.size_name FROM product_sizes 
                      JOIN sizes ON product_sizes.size_id = sizes.size_id 
                      WHERE product_sizes.product_id = ?");
                $sizeSql->bind_param("s", $productId);
                $sizeSql->execute();
                $sizeResult = $sizeSql->get_result();

                while ($sizeRow = $sizeResult->fetch_assoc()) {
                    echo '<div class="size-option">' . $sizeRow['size_name'] . '</div>';
                }

                echo '</div>';

                echo '<div class="product-action">';
                
                // Hiển thị tất cả giá của sản phẩm
                echo '<div class="product-price">';
                
                $productInfoSql = $conn->prepare("SELECT p.*, GROUP_CONCAT(ps.product_price ORDER BY ps.size_id SEPARATOR ' - ') AS size_prices
                            FROM products p
                            LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
                            WHERE p.product_id = ?");
                $productInfoSql->bind_param("s", $productId);
                $productInfoSql->execute();
                $productInfoResult = $productInfoSql->get_result();
                
                if ($productInfoResult->num_rows > 0) {
                    $productInfo = $productInfoResult->fetch_assoc();
                    echo !empty($productInfo['size_prices']) ? $productInfo['size_prices'] : $productInfo['product_price'];
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
    </div>
</div>
