<title>Z9 | Tìm Kiếm</title>
<link rel="shortcut icon" href="images/logo-ico.png" type="image/x-icon">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/custom-scrol.css">
<?php
include "./public/header.php";
?>

<!-- items -->
<style>
    .container-content-list-product {
        margin: 0px 20px 0px 20px;
    }

    .list-product-all-item {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        margin-right: -55px;
        margin-left: -15px;
    }

    .list-product-all-item .product-item {
        width: 23%;
        margin: 0px 10px 30px 10px;

    }
</style>

<style>
    .container-list-product {
        width: 90%;
        margin: 0px auto;
    }

    .link-nav-page {
        display: flex;
        gap: 10px;
        align-items: center;
        margin: 20px auto;
        padding: 10px 15px;
        position: relative;
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

    #show-hide-bar-btn {
        position: absolute;
        left: -75px;
    }

    #show-hide-bar-btn i {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        padding: 10px;
        background-color: #ffd400;
        transition: all ease-in-out 0.3s;
    }

    #show-hide-bar-btn:hover i {
        background-color: #221F20;
        color: #ffd400;
    }
</style>

<style>
    .value-search-txt {
        text-transform: uppercase;
        color: #1E90FF;
    }
</style>

<div class="container-list-product">
    <h3 class="link-nav-page">
        <p><a href="index.php">Trang Chủ</a></p> <i class="fa-solid fa-circle-right"></i>
        <p><a href="show-list-item.php">Tất Cả Sản Phẩm</a></p> <i class="fa-solid fa-circle-right"></i>
        <p>Kết Quả Tìm Kiếm Cho <span class="value-search-txt"><?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?></span></p>
    </h3>

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

            $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

            $sql = "SELECT products.*, categorys.category_name FROM products 
            LEFT JOIN categorys ON products.category_id = categorys.category_id
            WHERE products.product_name LIKE '%$searchKeyword%' OR categorys.category_name LIKE '%$searchKeyword%'";
            $result = $conn->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-item">';
                    echo '<a href="show-detail.php?product_id=' . $row['product_id'] . '" class="container-img">';
                    echo "<img class='product-img' src='admin/productAD/uploads/" . htmlspecialchars($row['product_img']) . "' alt='Image of " . htmlspecialchars($row["product_name"]) . "'>";
                    echo '</a>';
                    echo '<p class="product-name">' . $row['product_name'] . '</p>';
                    echo '<div class="product-des">' . $row['product_des'] . '</div>';

                    // echo '<p class="hot-filter"><i class="far fa-copy"></p>';

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
                echo "Không có sản phẩm phù hợp.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</div>

<div class="contianer-sallers">
    <section class="new-item">
        <div class="top-new-items">
            <h1>Best S<span>ellers</span></h1>
        </div>
        <div class="product-list">
            <?php
            include "./public/best-sale.php";
            ?>
        </div>
    </section>
</div>

<style>
    .contianer-sallers {
        width: 88%;
        margin: 0px auto;
    }
</style>

<script src="js/add.js"></script>

<!-- show-cart -->
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

<!-- fixed header -->
<script>
    
</script>