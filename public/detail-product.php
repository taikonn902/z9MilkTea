<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Rethink+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Truy vấn thông tin cơ bản của sản phẩm
    $detailSql = "SELECT p.*, GROUP_CONCAT(ps.product_price ORDER BY ps.size_id SEPARATOR ' - ') AS size_prices
                  FROM products p
                  LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
                  WHERE p.product_id = ?
                  GROUP BY p.product_id";

    $stmt = $conn->prepare($detailSql);
    $stmt->bind_param("s", $productId);
    $stmt->execute();
    $detailResult = $stmt->get_result();

    if ($detailResult->num_rows > 0) {
        $detailRow = $detailResult->fetch_assoc();

        echo '<div class="product-detail">';
        echo '<div class="container-img-left">';
        echo "<img class='detail-product-img' src='admin/productAD/uploads/" . htmlspecialchars($detailRow['product_img'], ENT_QUOTES, 'UTF-8') . "' alt='Hình ảnh " . htmlspecialchars($detailRow["product_name"], ENT_QUOTES, 'UTF-8') . "'>";
        echo '</div>';

        echo '<div class="container-info-right">';
        echo '<p class="detail-product-name">' . $detailRow['product_name'] . '</p>';

        // Kiểm tra xem có giá của kích thước nào không
        if (!empty($detailRow['size_prices'])) {
            echo '<p class="detail-product-price">' . $detailRow['size_prices'] . '</p>';
        } else {
            echo '<p class="detail-product-price">' . $detailRow['product_price'] . '</p>';
        }

        echo '<div class="detail-size-select">';
        $sizeSql = "SELECT sizes.size_name FROM product_sizes 
                     JOIN sizes ON product_sizes.size_id = sizes.size_id 
                     WHERE product_sizes.product_id = ?";
        $stmt = $conn->prepare($sizeSql);
        $stmt->bind_param("s", $productId);
        $stmt->execute();
        $sizeResult = $stmt->get_result();

        while ($sizeRow = $sizeResult->fetch_assoc()) {
            echo '<p class="detail-size-option">' . $sizeRow['size_name'] . '</p>';
        }
        echo '</div>';

        echo '<p class="detail-product-des">' . $detailRow['product_des'] . '</p>';

        echo '<div class="detail-action-add">';
        echo '<button type="submit" class="detail-add-to-cart"> Thêm Vào Giỏ Hàng </button>';
        echo '<button type="button" class="detail-favorite" id="moveToSimilarityItems"> Xem Sản Phẩm Tương Tự </button>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "Không tìm thấy sản phẩm.";
    }
} else {
    echo "Không có thông tin sản phẩm.";
}

$conn->close();
?>

<style>
    * {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .product-detail {
        width: 80%;
        display: flex;
        gap: 20px;
        margin: 0px auto;
    }

    .detail-product-img {
        width: 400px;
        height: 400px;
    }

    .container-info-right {
        position: relative;
    }

    .detail-product-name {
        font-size: 30px;
        font-weight: 700;
        color: #221F20;
        overflow: hidden;
        margin: 20px 0 20px 0;
        transition: all ease-in-out 0.3s;
    }

    .detail-product-price {
        font-size: 20px;
        color: #f80000;
        font-weight: 800;
        margin-bottom: 30px;
    }

    .detail-size-select {
        overflow: hidden;
        display: flex;
        gap: 20px;
    }

    .detail-size-option {
        border: none;
        background-color: #FFD400;
        color: #221F20;
        padding: 10px 50px;
        font-weight: 600;
        cursor: pointer;
        overflow: hidden;
        position: relative;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .detail-size-option::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, #221F20);
        transition: left 0.2s ease-in-out;
    }

    .detail-size-option:hover::before {
        left: 100%;
        background: linear-gradient(to right, #000000, #221F20);
    }

    .detail-size-option:hover {
        color: #FFD400;
        background-color: #221F20;
    }

    .detail-product-des {
        color: #221F20;
        overflow: hidden;
        margin-top: 30px;
    }

    .detail-add-to-cart {
        padding: 15px 50px;
        background-color: #FFD400;
        color: #221F20;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all ease-in-out 0.3s;
        position: absolute;
        left: 0;
        bottom: 20px;
        font-weight: 800;
    }

    .detail-add-to-cart:hover {
        background-color: #221F20;
        color: #FFD400;
    }

    .detail-favorite {
        padding: 15px 50px;
        background-color: #FFD400;
        color: #221F20;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all ease-in-out 0.3s;
        position: absolute;
        bottom: 20px;
        left: 40%;
        font-weight: 800;
    }

    .detail-favorite:hover {
        background-color: #221F20;
        color: #FFD400;
    }

    .detail-favorite:hover i {
        color: #FFD400;
    }
</style>

<style>
    .selected {
        background-color: #221F20;
        color: #FFD400;
    }
</style>

<script>
    document.getElementById('moveToSimilarityItems').addEventListener('click', function() {
        document.getElementById('SimilarityItems').scrollIntoView({
            behavior: 'smooth'
        });
    });
</script>