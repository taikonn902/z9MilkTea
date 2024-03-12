<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="shortcut icon" href="images/logo-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="css/custom-scrol.css">
    <title>Z9 | Thông Tin Sản Phẩm</title>
</head>

<body>
    <?php
    include "public/header.php";
    ?>

    <h3 class="link-nav-page">
        <p><a href="index.php">Trang Chủ</a></p>
        <i class="fa-solid fa-circle-right"></i>
        <p><a href="show-list-item.php">Tất Cả Sản Phẩm</a></p>
        <i class="fa-solid fa-circle-right"></i>
        <p><a href="#">Thông Tin Sản Phẩm</a></p>
    </h3>

    <main id="main-page">
        <section class="container-product-detail">
            <?php
            include "public/detail-product.php";
            ?>
        </section>

        <section class="comment-container">
            <h3>Thảo <span>Luận</span></h3>
            <?php
                include "public/comment.php";
            ?>
        </section>

        <div class="container-same-prduct" id="SimilarityItems">
            <h3>Sản Phẩm <span>Tương Tự</span></h3>
            <div class="product-list">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "z9milktea";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                if (isset($_GET['product_id'])) {
                    $productId = $_GET['product_id'];

                    // Truy vấn thông tin cơ bản của sản phẩm
                    $detailSql = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
                    $detailSql->bind_param("s", $productId);
                    $detailSql->execute();
                    $detailResult = $detailSql->get_result();

                    if ($detailResult->num_rows > 0) {
                        $row = $detailResult->fetch_assoc();

                        $currentProductCategory = $row['category_id'];

                        // Sử dụng prepared statement cho truy vấn sản phẩm cùng category
                        $sameCategorySql = $conn->prepare("SELECT p.*, GROUP_CONCAT(ps.product_price ORDER BY ps.size_id SEPARATOR ' - ') AS size_prices
                            FROM products p
                            LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
                            WHERE p.category_id = ? AND p.product_id != ?
                            GROUP BY p.product_id
                            LIMIT 4");

                        $sameCategorySql->bind_param("ss", $currentProductCategory, $productId);
                        $sameCategorySql->execute();
                        $sameCategoryResult = $sameCategorySql->get_result();

                        if ($sameCategoryResult->num_rows > 0) {
                            while ($sameRow = $sameCategoryResult->fetch_assoc()) {
                                echo '<div class="product-item">';
                                echo '<a href="show-detail.php?product_id=' . $sameRow['product_id'] . '" class="container-img">';
                                echo "<img class='product-img' src='admin/productAD/uploads/" . htmlspecialchars($sameRow['product_img']) . "' alt='Image of " . htmlspecialchars($sameRow["product_name"]) . "'>";
                                echo '</a>';
                                echo '<p class="product-name">' . $sameRow['product_name'] . '</p>';
                                echo '<div class="product-des">' . $sameRow['product_des'] . '</div>';

                                echo '<p class="hot-filter"><i class="far fa-copy"></i>Similarity</p>';

                                echo '<div class="size-select hidden">';
                                $sameProductId = $sameRow['product_id'];
                                $sizeSql = $conn->prepare("SELECT sizes.size_name FROM product_sizes 
                                    JOIN sizes ON product_sizes.size_id = sizes.size_id 
                                    WHERE product_sizes.product_id = ?");
                                $sizeSql->bind_param("s", $sameProductId);
                                $sizeSql->execute();
                                $sizeResult = $sizeSql->get_result();

                                while ($sizeRow = $sizeResult->fetch_assoc()) {
                                    echo '<div class="size-option">' . $sizeRow['size_name'] . '</div>';
                                }

                                echo '</div>';

                                echo '<div class="product-action">';
                                echo '<div class="product-price">';

                                // Kiểm tra xem có giá của kích thước nào không
                                if (!empty($sameRow['size_prices'])) {
                                    echo $sameRow['size_prices'];
                                } else {
                                    echo $sameRow['product_price'];
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
                            echo "Không có sản phẩm cùng category.";
                        }

                        $sameCategorySql->close();
                    } else {
                        echo "Không tìm thấy sản phẩm.";
                    }

                    $detailSql->close();
                } else {
                    echo "Không có thông tin sản phẩm.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </main>
</body>
<style>
    .link-nav-page {
        display: flex;
        gap: 10px;
        align-items: center;
        width: 80%;
        margin: 20px auto;
        padding: 10px 15px;
    }

    .link-nav-page a {
        position: relative;
        transition: all ease-in-out 0.3s;
        padding: 10px 0;
        color: #221F20;
    }

    .link-nav-page a::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #221F20;
        transition: all ease-in-out 0.3s;
        transform: translateX(-50%);
    }

    .link-nav-page a:hover:after {
        width: 100%;
    }

    #main-page {
        margin: 20px;
    }

    .container-same-prduct {
        width: 90%;
        margin: 0px auto;
        margin-top: 20px;
        padding: 20px 0;
        border-top: 1px solid #221F20;
    }

    .comment-container {
        width: 90%;
        margin: 0px auto;
        margin-top: 30px;
        padding: 20px 0;
        border-top: 1px solid #221F20;
    }

    .container-same-prduct h3,
    .comment-container h3 {
        font-size: 35px;
        text-align: center;
    }

    .container-same-prduct h3 span,
    .comment-container h3 span {
        color: #ffd400;
    }
</style>

</html>

<script>
    function showCart(event) {
        event.preventDefault();
        var showCart = document.getElementById('show-cart');
        var iconCart = event.currentTarget;
        var cartLengthElement = document.getElementById('lenght-cart');

        if (showCart.classList.contains('show')) {
            showCart.classList.remove('show');
            iconCart.style.color = '#221F20';
            cartLengthElement.style.color = '#221F20';
        } else {
            showCart.classList.add('show');
            iconCart.style.color = '#fff';
            cartLengthElement.style.color = '#fff';
        }
    }
</script>

<style>
    .quantity-input {
        width: 35px;
    }

    .quantity-decrement,
    .quantity-increment {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
</style>

<script src="js/add-.js"></script>

<script src="js/add---detail.js"></script>