<link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">
<link rel="stylesheet" href="../css/category.css">
<title>Z9 | Loại Sản Phẩm</title>

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
                <li class="dropdown-item"><a href="#">Loại Sản Phẩm</a></li>
                <li class="dropdown-item"><a href="../productAD/index.php">Sản Phẩm</a></li>
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
            <a href="">Đăng Xuất</a>
        </li>
    </nav>
</div>

<div class="container-category">
    <main id="content-page">
        <fieldset class="container-add-new-category">
            <legend>Thêm Loại Sản Phẩm Mới</legend>

            <form class="ad-new-form" action="" method="POST">
                <input class="add-category-text" type="text" name="category_name" placeholder="Nhập tên loại sản phẩm mới..." required>

                <div class="container-add-btn">
                    <button class="add-category-btn" type="submit">Thêm</button>
                </div>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $category_name = $_POST["category_name"];

                if (empty($category_name)) {
                    echo "Vui lòng nhập tên loại sản phẩm.";
                } else {
                    $check_sql = "SELECT * FROM categorys WHERE category_name = '$category_name'";
                    $check_result = $conn->query($check_sql);

                    if ($check_result === FALSE) {
                        die("Lỗi truy vấn: " . $conn->error);
                    }

                    if ($check_result->num_rows > 0) {
                        echo "<div id='error-message'>Loại sản phẩm đã tồn tại.</div>";
                    } else {
                        $next_id_sql = "SELECT MAX(SUBSTRING(category_id, 3)) AS max_id FROM categorys";
                        $next_id_result = $conn->query($next_id_sql);

                        if ($next_id_result === FALSE) {
                            die("Lỗi truy vấn: " . $conn->error);
                        }

                        $next_id_row = $next_id_result->fetch_assoc();
                        $next_id = intval($next_id_row["max_id"]) + 1;

                        if ($next_id < 10) {
                            $category_id = "CT00" . $next_id;
                        } elseif ($next_id < 100) {
                            $category_id = "CT0" . $next_id;
                        } else {
                            $category_id = "CT" . $next_id;
                        }

                        $insert_sql = "INSERT INTO categorys (category_id, category_name) VALUES ('$category_id', '$category_name')";

                        if ($conn->query($insert_sql) === TRUE) {
                            echo "<div id='success-message'>Thêm loại sản phẩm thành công.</div>";
                        } else {
                            echo "Lỗi: " . $insert_sql . "<br>" . $conn->error;
                        }
                    }

                    $query = "SELECT COUNT(*) as total FROM categorys";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $totalCategories = $row['total'];
                        echo "<script>document.getElementById('category-count').innerText = '$totalCategories';</script>";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                }
                $conn->close();
            }
            ?>
        </fieldset>

        <fieldset class="container-list-category">
            <legend>Danh Sách Loại Sản Phẩm</legend>

            <table>
                <thead>
                    <tr>
                        <th>Mã loại sản phẩm</th>
                        <th>Tên loại sản phẩm</th>
                        <th>Tuỳ Chỉnh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "z9milktea";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM categorys ORDER BY category_id DESC";
                    $result = $conn->query($sql);

                    if ($result === FALSE) {
                        die("Lỗi truy vấn: " . $conn->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["category_id"] . "</td>";
                            echo "<td>" . $row["category_name"] . "</td>";
                            echo '<td class="action-category">
                                            <button type="button" class="edit-btn">
                                                <a href="edit-category.php?id=' . $row["category_id"] . '"><i class="fa-solid fa-pencil"></i></a>
                                            </button>

                                            <button type="button" class="delete-btn">
                                                <a href="delete-category.php?category_id=' . $row["category_id"] . '"><i class="fa-solid fa-trash-can"></i></a>
                                            </button>
                                        </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<p class='message-show-list-category'> Không có loại sản phẩm nào trong cơ sở dữ liệu. </p>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </fieldset>
    </main>
</div>

<script>
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
        successMessage.style.display = 'block';

        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000);
    }

    var errorMessage = document.getElementById('error-message');
    if (errorMessage) {
        errorMessage.style.display = 'block';

        setTimeout(function() {
            errorMessage.style.display = 'none';
        }, 3000);
    }
</script>