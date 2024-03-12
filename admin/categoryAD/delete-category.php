<link rel="stylesheet" href="../css/category.css">
<link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">
<title>Z9 | Xoá Loại Sản Phẩm</title>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$category_id = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];

        $sqlDeleteProducts = "DELETE FROM products WHERE category_id = '$category_id'";
        echo "SQL Delete Products: $sqlDeleteProducts";

        if (!mysqli_query($conn, $sqlDeleteProducts)) {
            $errorMessage = "Lỗi SQL khi xoá sản phẩm: " . mysqli_error($conn);
            error_log($errorMessage);
            echo "Xóa sản phẩm không thành công. Vui lòng kiểm tra tệp log để biết chi tiết.";
            exit();
        }

        $sqlDeleteCategory = "DELETE FROM categorys WHERE category_id = '$category_id'";
        echo "SQL Delete Category: $sqlDeleteCategory";

        if (mysqli_query($conn, $sqlDeleteCategory)) {
            header("Location: index.php");
            exit();
        } else {
            $errorMessage = "Lỗi SQL khi xoá danh mục: " . mysqli_error($conn);
            error_log($errorMessage);
            echo "Xóa danh mục không thành công. Vui lòng kiểm tra tệp log để biết chi tiết.";
        }
    } else {
        echo "Thiếu thông tin category_id.";
    }
}
?>

<body>
    <fieldset class="container-delete-form">
        <legend>Xoá Danh Mục</legend>

        <p>Bạn có chắc muốn xoá danh mục đã chọn?</p>
        <form method="post" action="">
            <input type="hidden" name="category_id" value="<?php echo isset($_GET['category_id']) ? $_GET['category_id'] : ''; ?>">
            <input type="hidden" name="deleteConfirmed" value="true">

            <div class="container-btn-delete">
                <button class="yes-btn" type="submit">Yes</button>
            </div>
        </form>
        <div class="container-btn-delete-no">
            <button class="no-btn" onclick="confirmDelete('no')">No</button>
        </div>
    </fieldset>
</body>

<!-- ======================================= delete-category-css ================================ -->
<style>
    body {
        position: relative;
    }

    fieldset {
        border: 2px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 8px 10px 0 rgb(0 0 0 / 10%);
    }

    .container-delete-form {
        font-size: 20px;
        display: inline-block;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -100%);
    }

    .container-delete-form legend {
        text-align: center;
        padding: 0px 20px;
        font-weight: 800;
    }

    .container-delete-form p,
    form,
    button {
        text-align: center;
        margin: 20px 30px;
    }

    .container-btn-delete-no {
        text-align: center;
        margin-top: -30px;
    }

    .yes-btn,
    .no-btn {
        width: 150px;
        background-color: #FFD400;
        color: #221F20;
        padding: 10px 40px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        overflow: hidden;
        position: relative;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .yes-btn::before,
    .no-btn::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, #221F20);
        transition: left 0.5s ease-in-out;
    }

    .yes-btn:hover::before,
    .no-btn:hover::before {
        left: 100%;
        background: linear-gradient(to right, #000000, #221F20);
    }

    .yes-btn:hover,
    .no-btn:hover {
        color: #FFD400;
        background-color: #221F20;
    }
</style>

<script>
    function confirmDelete(choice) {
        if (choice === 'no') {
            window.location = "index.php";
        }
    }
</script>
</html>