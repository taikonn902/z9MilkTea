<title>Z9 | Sửa Loại Sản Phẩm</title>
<link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">
<link rel="stylesheet" href="../css/category.css">

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "z9milktea";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        $category_id = mysqli_real_escape_string($conn, $_GET['id']);

        $sql = "SELECT category_name FROM categorys WHERE category_id = '$category_id'";
        $result = mysqli_query($conn, $sql);

        $category_name = '';

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $category_name = $row['category_name'];
            } else {
                echo "Không tìm thấy danh mục.";
            }
        } else {
            echo "Lỗi truy vấn: " . mysqli_error($conn);
        }
    } else {
        echo "Thiếu thông tin danh mục.";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_changes'])) {
            $new_category_name = mysqli_real_escape_string($conn, $_POST['new_category_name']);
            $category_id = mysqli_real_escape_string($conn, $_POST['selected_category_id']);

            $sql = "UPDATE categorys SET category_name = '$new_category_name' WHERE category_id = '$category_id'";
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php");
                exit();
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }
        }
    }
?>

<fieldset class="container-form-edit">
    <legend>Sửa Loại Sản Phẩm</legend>
    <form action="" class="form-category-add" method="POST">
        <div class="old-category">
            <label for="selected_category_id">Loại Sản Phẩm Đã Chọn:</label>
            <input type="text" value="<?php echo $category_name; ?>" disabled>
        </div>

        <div class="new-category">
            <label for="new_category_name">Tên Loại Sản Phẩm Mới:</label>
            <input class="new_category_name" type="text" name="new_category_name" required>
        </div>

        <input type="hidden" name="selected_category_id" value="<?php echo $category_id; ?>">

        <div class="container-action">
            <div class="container-return">
                <a class="return-category-list" href="index.php">Trở Lại</a>
            </div>

            <div class="container-btn-save">
                <button class="save-category" name="save_changes" type="submit">Lưu Lại</button>
            </div>
        </div>
    </form>
</fieldset>

<!-- ======================================= edit-category-css ================================ -->
<style>
    fieldset {
        border: 2px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 8px 10px 0 rgb(0 0 0 / 10%);
        padding: 30px;
    }

    .container-form-edit {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -100%);
    }

    .container-form-edit legend {
        text-align: center;
        padding: 0px 20px;
        font-weight: 800;
        font-size: 25px;
    }

    .new_category_name {
        margin-top: 30px;
    }

    label {
        font-size: 18px;
    }

    input {
        height: 25px;
        padding: 15px 10px;
        margin-left: 10px;
    }

    .container-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 30px 0 0 0;
    }

    .return-category-list,
    .save-category {
        padding: 10px 60px;
        cursor: pointer;
        border: none;
        background-color: #FFD400;
        font-weight: 600;
        color: #221F20;
        font-size: 16px;
        transition: all ease-in-out 0.5s;
        overflow: hidden;
        position: relative;
    }

    .save-category::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, #221F20);
        transition: left 0.5s ease-in-out;
    }

    .save-category:hover::before {
        left: 100%;
        background: linear-gradient(to right, #000000, #221F20);
    }


    .return-category-list:hover,
    .save-category:hover {
        color: #FFD400;
        background-color: #221F20;
    }
</style>