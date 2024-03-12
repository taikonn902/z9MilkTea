<div style="margin-left: 5px;">
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


            $sql = "SELECT products.*, categorys.category_name
        FROM products
        INNER JOIN categorys ON products.category_id = categorys.category_id
        WHERE categorys.category_name = 'Trà Sữa'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-item">';
                    echo '<a href="show-detail.php?product_id=' . $row['product_id'] . '" class="container-img">';
                    echo "<img class='product-img' src='admin/productAD/uploads/" . htmlspecialchars($row['product_img']) . "' alt='Image of " . htmlspecialchars($row["product_name"]) . "'>";
                    echo '</a>';
                    echo '<p class="product-name">' . $row['product_name'] . '</p>';
                    echo '<div class="product-des">' . $row['product_des'] . '</div>';

                    // echo '<p class="hot-filter"><i class="fa-solid fa-fire-flame-curved"></i>New</p>';

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
                    echo '<div class="product-price">' . $row['product_price'] . '</div>';
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
</div>