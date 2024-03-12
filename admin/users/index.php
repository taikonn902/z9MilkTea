<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">
    <title>Z9 | Người Dùng</title>

    <?php
    include "../public/header-admin.php";
    ?>
</head>

<body>
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
                <a href="../logout.php">Đăng Xuất</a>
            </li>
        </nav>
    </div>

    <div class="container-action-orders-page">
        <button class="return-index-btn">
            <a href="javascript:history.back()">Trở lại</a>
        </button>

        <form action="" class="container-filter" method="POST">
            <input type="text" name="filter-txt" placeholder="Nhập Tên Người Dùng, Email..." class="filter-txt" required>
            <div class="container-filter-orders-btn">
                <button type="submit" class="filter-btn">Lọc</button>
            </div>
        </form>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "z9milktea";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $searchTerm = isset($_POST["filter-txt"]) ? $_POST["filter-txt"] : "";

    if (!empty($searchTerm)) {
        $sql = "SELECT * FROM users
                    WHERE user_name LIKE '%$searchTerm%'
                    OR email LIKE '%$searchTerm%'
                    ORDER BY user_name";
    } else {
        $sql = "SELECT * FROM users ORDER BY user_id DESC";
    }

    $result = $conn->query($sql);

    echo '<table class="user-table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th class="title-colum">ID Người Dùng</th>';
    echo '<th class="title-column">Tên Người Dùng</th>';
    echo '<th class="title-column">Email</th>';
    echo '<th class="title-column">Vai Trò</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td class="id-column">' . $row["user_id"] . '</td>';
            echo '<td class="name-column">' . $row["user_name"] . '</td>';
            echo '<td class="email-column">' . $row["email"] . '</td>';

            echo '<td class="role-column">' . ($row["role"] == 0 ? 'Quản trị' : 'Khách Hàng') . '</td>';

            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="4">Không có kết quả nào phù hợp.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';

    $conn->close();
    ?>
</body>

</html>

<style>
    .user-table {
        border-collapse: collapse;
        margin: 30px auto;
        width: 95%;
    }

    .user-table th,
    .user-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    .user-table th {
        background-color: #FFD400;
    }

    .title-column {
        color: #221F20;
    }
</style>

<style>
    .container-action-orders-page {
        width: 95%;
        margin: 30px auto;
        display: flex;
        justify-content: space-between;
    }

    .return-index-btn {
        padding: 15px 50px;
        background-color: #FFD400;
        border: none;
        cursor: pointer;
        transition: all ease-in-out 0.5s;
    }

    .return-index-btn a {
        font-weight: 700;
        color: #221F20;
    }

    .return-index-btn:hover {
        background-color: #221F20;
    }

    .return-index-btn:hover a {
        color: #FFD400;
    }

    .container-filter {
        display: flex;
        box-shadow: 0 8px 10px 0 rgb(0 0 0 / 10%);
    }

    .filter-txt {
        padding: 0 15px;
        width: 250px;
        outline: none;
        border: 1px solid #eee;
        border-right: none;
    }

    .filter-btn {
        height: 100%;
        width: 50px;
        border: none;
        background-color: #FFD400;
        color: #221F20;
        font-weight: 700;
        border: 1px solid #eee;
        border-left: none;
        cursor: pointer;
        transition: all 0.5s ease-in-out;
    }

    .filter-btn:hover {
        background-color: #221F20;
        color: #FFD400;
    }
</style>