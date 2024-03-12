<title>Z9 | Sửa Sản Phẩm</title>
<link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>

<?php
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row['product_name'];
        $category_id = $row['category_id'];
        $product_img = $row['product_img'];
        $product_price = $row['product_price'];
        $product_des = $row['product_des'];
        $image_path = 'uploads/' . $product_img;
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID not provided.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>

<body>
    <fieldset class="container-add-new-product">
        <legend>Sửa Thông Tin Sản Phẩm</legend>

        <form class="add-new-form" action="" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

            <section class="choose-category">
                <?php
                $sql = "SELECT * FROM categorys";
                $result = mysqli_query($conn, $sql);

                $options = '';
                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['category_id'] == $category_id) ? 'selected' : '';
                    $options .= "<option value='{$row['category_id']}' $selected>{$row['category_name']}</option>";
                }
                ?>
                <label class="label-form-add" for="">Loại Sản Phẩm:</label>
                <select class="category-id" name="category_id" id="category_id" disabled>
                    <?php echo $options; ?>
                </select>
            </section>

            <section class="enter-product-name">
                <label class="label-form-add" for="">Tên Sản Phẩm:</label>

                <div class="container-input-form">
                    <input class="product-name" type="text" name="product_name" value="<?php echo $product_name; ?>" required>
                </div>
            </section>

            <section class="choose-size-product">
                <label class="label-form-add" for="">Kích Thước:</label>

                <?php
                $sqlSizes = "SELECT * FROM sizes";
                $resultSizes = mysqli_query($conn, $sqlSizes);

                // Lấy danh sách các size đã chọn của sản phẩm
                $selectedSizes = array();
                $sqlSelectedSizes = "SELECT size_id FROM product_sizes WHERE product_id = '$product_id'";
                $resultSelectedSizes = $conn->query($sqlSelectedSizes);

                if ($resultSelectedSizes->num_rows > 0) {
                    while ($rowSelectedSizes = $resultSelectedSizes->fetch_assoc()) {
                        $selectedSizes[] = $rowSelectedSizes['size_id'];
                    }
                }

                while ($row = mysqli_fetch_assoc($resultSizes)) {
                    $sizeId = $row['size_id'];
                    $sizeName = $row['size_name'];

                    echo "<label class='label-size' for='size_$sizeId'>$sizeName</label>";
                    echo "<input class='input-check-box' type='checkbox' name='sizes[]' id='size_$sizeId' value='$sizeId'";

                    // Nếu size hiện tại có trong danh sách đã chọn, tích vào checkbox
                    if (in_array($sizeId, $selectedSizes)) {
                        echo " checked";
                    }

                    echo ">";
                }
                ?>
            </section>

            <section class="enter-product-price">
                <label class="label-form-add" for="">Giá:</label>
                <div class="container-input-form">
                    <input class="product-price" type="text" name="product_price" value="<?php echo $product_price; ?>" required>
                </div>
            </section>

            <section class="enter-description">
                <label class="label-form-add" for="">Mô Tả:</label>
                <div class="container-input-form">
                    <textarea class="product-des" name="product_des" id="" cols="20" rows="10" required><?php echo $product_des; ?></textarea>
                </div>
            </section>

            <section class="choose-product-img">
                <label class="label-form-add" for="">Hình Ảnh:</label>
                <div class="container-input-form">
                    <div class="container-img-old-new">
                        <img src="<?php echo $image_path; ?>" alt="<?php echo $product_name; ?>">
                        <input type="hidden" name="old_img" value="<?php echo $product_img; ?>">
                        <input type="file" name="product_img" id="inputImage">
                        <img id="previewImage" name="new-img" src="" alt="Hình Ảnh Mới">
                    </div>
                </div>
            </section>

            <div class="container-add-btn">
                <button class="return-product">
                    <a href="index.php">Trở Về</a>
                </button>
                <button class="add-category-btn" type="submit" name="add">Lưu Lại</button>
            </div>
        </form>
    </fieldset>
</body>

<style>
    .container-input-form img {
        width: 150px;
        height: 150px;
    }

    .container-img-old-new {
        display: flex;
        justify-content: space-between
    }

    #previewImage {
        width: 150px;
        height: 150px;
    }

    #inputImage {
        width: 50%;
        padding: 0px 20px;
        cursor: pointer;
    }

    .return-product {
        background-color: #FFD400;
        padding: 10px 60px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 800;
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease-in-out;
    }

    .return-product a {
        color: #221F20;
        list-style: none;
        text-decoration: none
    }

    .return-product:hover {
        background-color: #221F20;
    }

    .return-product:hover a {
        color: #FFD400
    }
</style>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Rethink+Sans:wght@400;500;600;700;800&display=swap');

    * {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        width: 40%;
        margin: 0px auto;
    }

    fieldset {
        margin-top: 20px;
        border: 2px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 8px 10px 0 rgb(0 0 0 / 10%);
    }

    .container-add-new-product legend {
        font-size: 25px;
        font-weight: 800;
        text-align: center;
        display: block;
        padding: 0px 15px;
    }

    .add-new-form {
        margin-top: 10px;
        font-size: 14px;
    }

    .label-form-add {
        font-weight: 600;
        text-align: left;
        margin: 0 20px 0 20px;
    }

    .label-size {
        font-weight: 600;
        text-align: left;
        margin: 0px 10px 0px;
    }

    .container-input-form {
        margin: 10px 20px 0px 20px;
    }

    .input-check-box {
        font-size: 20px;
        margin-right: 20px;
        cursor: pointer;
    }

    .product-des {
        width: 100%;
        height: 80px;
        margin-right: 20px;
        padding: 10px 10px;
    }

    .choose-category,
    .enter-product-name,
    .choose-size-product,
    .enter-product-price,
    .choose-product-img,
    .enter-description {
        margin-top: 18px;
    }

    .choose-category .category-id {
        height: 30px;
        padding: 0 10px;
        cursor: pointer;
    }

    .product-name,
    .product-price {
        height: 30px;
        width: 100%;
        padding: 0 10px;
    }

    .container-add-btn {
        margin: 30px 50px 30px 50px;
        justify-content: space-around;
        display: flex;
        gap: 100px;
    }

    .add-category-btn {
        background-color: #FFD400;
        color: #221F20;
        padding: 10px 60px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 800;
        overflow: hidden;
        position: relative;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .add-category-btn::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, #221F20);
        transition: left 0.5s ease-in-out;
    }

    .add-category-btn:hover::before {
        left: 100%;
        background: linear-gradient(to right, #000000, #221F20);
    }

    .add-category-btn:hover {
        color: #FFD400;
        background-color: #221F20;
    }

    #success-message,
    #error-message {
        opacity: 0;
        position: absolute;
        width: auto;
        color: #221F20;
        border-radius: 10px;
        padding: 10px 74px;
        top: 10%;
        left: 40px;
        transition: all 0.5s ease-in-out;
        visibility: hidden;
        pointer-events: none;
    }

    #success-message {
        border: 2px solid #32CD32;
        background-color: #32CD32;
        color: #FFD400;
    }

    #error-message {
        border: 2px solid #f80000;
        background-color: #221F20;
        color: #FFD400;
    }
</style>

</html>

<script>
    document.getElementById('inputImage').addEventListener('change', previewImage);

    function previewImage() {
        var preview = document.getElementById('previewImage');
        var input = document.getElementById('inputImage');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            // Clear the preview if no file is selected
            preview.src = '';
        }
    }
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_des = $_POST['product_des'];

    if (!empty($_FILES['product_img']['name'])) {
        // Lưu tên hình ảnh cũ vào $old_img để xoá
        $old_img = $_POST['old_img'];

        // tải lên hình ảnh mới
        $new_image = $_FILES['product_img']['name'];
        $image_path = 'uploads/' . $new_image;
        $target_path = 'uploads/' . basename($new_image);

        // Xoá hình ảnh cũ nếu tồn tại
        if (!empty($old_img) && file_exists('uploads/' . $old_img)) {
            unlink('uploads/' . $old_img);
        }

        if (move_uploaded_file($_FILES['product_img']['tmp_name'], $target_path)) {
            $sql = "UPDATE products SET 
                product_name = '$product_name',
                product_img = '$new_image',
                product_price = '$product_price',
                product_des = '$product_des'
                WHERE product_id = '$product_id'";
        } else {
            echo "Failed to upload the new image.";
        }
    } else {
        // Nếu không có hình ảnh mới
        $sql = "UPDATE products SET 
            product_name = '$product_name',
            product_price = '$product_price',
            product_des = '$product_des'
            WHERE product_id = '$product_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Cập Nhật Thông Tin Sản Phẩm Thành Công."); window.location.href = "index.php";</script>';
    } else {
        echo "Error updating product: " . $conn->error;
    }

    if (isset($_POST['sizes'])) {
        $selectedSizes = $_POST['sizes'];

        $deleteSizesQuery = "DELETE FROM product_sizes WHERE product_id = '$product_id'";
        $conn->query($deleteSizesQuery);

        foreach ($selectedSizes as $sizeId) {
            $addSizeQuery = "INSERT INTO product_sizes (product_id, size_id) VALUES ('$product_id', '$sizeId')";
            $conn->query($addSizeQuery);
        }
    }
}
?>
