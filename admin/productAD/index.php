<link rel="stylesheet" href="../css/product.css">
<link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">
<title>Z9 | Sản Phẩm</title>

<?php
include "../DB-connect/connectDB.php";
include "../public/header-admin.php";
?>

<div class="container-nav">
    <nav class="nav-admin-page">
        <li class="nav-item">
            <i class="fa-solid fa-house"></i>
            <a href="../index.php">Trang Chủ</a>
        </li>
        <li class="dropdown">
            <i class="fa-solid fa-wine-glass"></i>
            <a href="#">Cửa Hàng</a>
            <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="../categoryAD/index.php">Loại Sản Phẩm</a></li>
                <li class="dropdown-item"><a href="#">Sản Phẩm</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <i class="fa-regular fa-calendar"></i>
            <a href="../orders/index.php">Đơn Hàng</a>
        </li>
        <li class="nav-item">
            <i class="fa-solid fa-comments"></i>
            <a href="#">Bình Luận</a>
        </li>
        <li class="nav-item">
            <i class="fa-solid fa-users"></i>
            <a href="../users/index.php">Người Dùng</a>
        </li>

        <li class="nav-item">
            <i class="fa-solid fa-gears"></i>
            <a href="../settings/edit-avt.php">Cài Đặt</a>
        </li>

        <li class="nav-item">
            <i class="fa-solid fa-rotate-left"></i>
            <a href="../../index.php">về Trang Web</a>
        </li>

        <li class="nav-item">
            <i class="fa-solid fa-right-from-bracket"></i>
            <a href="../logout.php">Đăng Xuất</a>
        </li>
    </nav>
</div>

<div class="container-product">
    <main id="content-page">
        <fieldset class="container-add-new-product">
            <legend>Thêm Sản Phẩm Mới</legend>

            <form class="add-new-form" action="" method="POST" enctype="multipart/form-data">
                <section class="choose-category">
                    <?php
                    $sql = "SELECT * FROM categorys";
                    $result = mysqli_query($conn, $sql);

                    $options = '';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $options .= "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                    }
                    ?>
                    <label class="label-form-add" for="">Loại Sản Phẩm:</label>
                    <select class="category-id" name="category_id" id="id">
                        <option value="">----- Chọn -----</option>
                        <?php echo $options; ?>
                    </select>
                </section>

                <section class="enter-product-name">
                    <label class="label-form-add" for="">Tên Sản Phẩm:</label>

                    <div class="container-input-form">
                        <input class="product-name" type="text" name="product_name" placeholder="Nhập tên sản phẩm..." required>
                    </div>
                </section>

                <section class="choose-size-product">
                    <label class="label-form-add" for="">Kích Thước:</label>
                    <?php
                    $sql = "SELECT * FROM sizes";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<label class='label-size' for='size_" . $row['size_id'] . "'>" . $row['size_name'] . "</label>";
                        echo "<input class='input-check-box' type='checkbox' name='sizes[]' id='size_" . $row['size_id'] . "' value='" . $row['size_id'] . "'>";
                    }
                    ?>
                </section>

                <section class="enter-product-price">
                    <label class="label-form-add" for="">Giá:</label>
                    <div class="container-input-form">
                        <input class="product-price" type="text" name="product_price" placeholder="Nhập giá sản phẩm..." required>
                    </div>
                </section>

                <section class="enter-description">
                    <label class="label-form-add" for="">Mô Tả:</label>
                    <div class="container-input-form">
                        <textarea class="product-des" name="product_des" id="" cols="20" rows="10" placeholder="Mô tả sản phẩm..." required></textarea>
                    </div>
                </section>

                <section class="choose-product-img">
                    <label class="label-form-add" for="">Hình Ảnh:</label>
                    <div class="container-input-form">
                        <input type="file" name="product_img">
                    </div>
                </section>

                <div class="container-add-btn">
                    <button class="add-category-btn" type="submit" name="add">Thêm</button>
                </div>
            </form>
        </fieldset>

        <fieldset class="container-list-product">
            <legend>Danh Sách Sản Phẩm</legend>

            <table id="product-table">
                <thead>
                    <tr>
                        <th>Hình Ảnh</th>
                        <th>Mã SP</th>
                        <th>Tên Loại</th>
                        <th>Tên</th>
                        <th>Giá </th>
                        <th>Mô Tả</th>
                        <th>Tuỳ Chỉnh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT p.*, c.category_name, GROUP_CONCAT(ps.product_price ORDER BY ps.size_id SEPARATOR ' - ') AS size_prices
                            FROM products p 
                            JOIN categorys c ON p.category_id = c.category_id 
                            LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
                            GROUP BY p.product_id
                            ORDER BY p.product_id DESC";

                    $result = $conn->query($sql);

                    if ($result === false) {
                        // Kiểm tra lỗi truy vấn SQL
                        die("Error executing the query: " . $conn->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><img class='product-img' src='uploads/" . $row['product_img'] . "' alt='Product Image'></td>";
                            echo "<td>" . $row['product_id'] . "</td>";
                            echo "<td>" . $row['category_name'] . "</td>";
                            echo "<td class='product-name-cell'>" . $row['product_name'] . "</td>";

                            // Hiển thị giá sản phẩm
                            echo "<td class='product-price-cell'>";

                            // Kiểm tra xem có giá của kích thước nào không
                            if (!empty($row['size_prices'])) {
                                echo $row['size_prices'];
                            } else {
                                echo $row['product_price'];
                            }

                            echo "</td>";

                            echo "<td class='product-des-cell'>" . $row['product_des'] . "</td>";
                            echo '<td class="action-product">
                                        <button type="button" class="edit-btn">
                                            <a href="edit-product.php?product_id=' . $row["product_id"] . '"><i class="fa-solid fa-pencil"></i></a>
                                        </button>
                                        <button type="button" class="delete-btn">
                                            <a href="delete-product.php?product_id=' . $row["product_id"] . '"><i class="fa-solid fa-trash-can"></i></a>
                                        </button>
                                </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Không có sản phẩm nào.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </fieldset>
    </main>

    <!-- ======================================= message-submit-script ======================================= -->
    <script>
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.opacity = '1';
            successMessage.style.top = '25%';
            successMessage.style.transition = 'all ease-in-out 0.3s';
            successMessage.style.visibility = 'visible';
            successMessage.style.pointerEvents = 'auto';

            setTimeout(function() {
                successMessage.style.opacity = '0';
                successMessage.style.top = '10%';
            }, 3000);
        }

        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.opacity = '1';
            errorMessage.style.top = '25%';
            errorMessage.style.transition = 'all ease-in-out 0.3s';
            errorMessage.style.visibility = 'visible';
            errorMessage.style.pointerEvents = 'auto';

            setTimeout(function() {
                errorMessage.style.opacity = '0';
                errorMessage.style.top = '10%';
            }, 3000);
        }
    </script>

    <style>
        .product-price-cell {
            width: 170px;
        }
    </style>

    <!-- ======================================= php-add-new-products-code ================================ -->
    <?php
        if (isset($_POST['add'])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "z9milktea";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Kết nối không thành công: " . $conn->connect_error);
            }

            $product_name = $_POST['product_name'];

            $checkExistQuery = "SELECT * FROM products WHERE product_name = '$product_name'";
            $resultExist = $conn->query($checkExistQuery);

            if ($resultExist->num_rows > 0) {
                echo "<div id='error-message'>Sản phẩm đã tồn tại !!!</div>";
            } else {
                //tạo id 
                $sqlCount = "SELECT COUNT(*) as count FROM products";
                $resultCount = $conn->query($sqlCount);

                if ($resultCount->num_rows > 0) {
                    $row = $resultCount->fetch_assoc();
                    $productCount = $row['count'] + 1;

                    if ($productCount < 10) {
                        $productCode = "SP00" . $productCount;
                    } elseif ($productCount < 100) {
                        $productCode = "SP0" . $productCount;
                    } else {
                        $productCode = "SP" . $productCount;
                    }

                    $category_id = $_POST['category_id'];
                    $product_des = $_POST['product_des'];

                    $product_price_input = $_POST['product_price'];

                    $selected_sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];

                    // nếu là giá kép thì tách nó ra
                    if (strpos($product_price_input, '-') !== false) {
                        $prices = explode('-', $product_price_input);

                        $price_M = isset($prices[0]) ? trim($prices[0]) : null;
                        $price_L = isset($prices[1]) ? trim($prices[1]) : null;
                    } else {
                        if (in_array(1, $selected_sizes)) {
                            $price_M = $product_price_input;
                            $price_L = null;
                        } elseif (in_array(2, $selected_sizes)) {
                            $price_M = null;
                            $price_L = $product_price_input;
                        } else {
                            // Trường hợp không có size nào được chọn, có thể làm gì đó khác tùy theo logic của bạn
                            // Ví dụ: Hiển thị thông báo lỗi hoặc xử lý khác
                        }
                    }

                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["product_img"]["name"]);
                    move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file);
                    $product_img = basename($_FILES["product_img"]["name"]);

                    $sql_products = "INSERT INTO products (product_id, category_id, product_name, product_img,product_des) VALUES ('$productCode', '$category_id', '$product_name', '$product_img','$product_des')";

                    // thêm giá theo size_id
                    if ($conn->query($sql_products) === TRUE) {
                        echo "<div id='success-message'>Thêm sản phẩm thành công !!!</div>";

                        if ($price_M !== null) {
                            $sql_size_M = "INSERT INTO product_sizes (product_id, size_id, product_price) VALUES ('$productCode', 1, '$price_M')";
                            if ($conn->query($sql_size_M) !== TRUE) {
                                echo "Lỗi khi thêm giá size M: " . $conn->error;
                            }
                        }

                        if ($price_L !== null && in_array(2, $selected_sizes)) {
                            $sql_size_L = "INSERT INTO product_sizes (product_id, size_id, product_price) VALUES ('$productCode', 2, '$price_L')";
                            if (!$conn->query($sql_size_L)) {
                                echo "Lỗi khi thêm giá size L: " . $conn->error;
                            }
                        }
                    } else {
                        echo "Lỗi khi thêm sản phẩm: " . $conn->error;
                    }
                } else {
                    echo "Lỗi khi lấy số lượng sản phẩm.";
                }

                echo "<script>window.location.reload();</script>";
            }
            $conn->close();
        }
    ?>