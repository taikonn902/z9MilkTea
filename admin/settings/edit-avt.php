<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

session_start();

// Kiểm tra xem đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    echo "Người dùng chưa đăng nhập.";
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {

        $allowed_formats = ['jpg', 'jpeg', 'png', 'gif'];
        $file_info = pathinfo($_FILES['avatar']['name']);
        $file_extension = strtolower($file_info['extension']);

        if (in_array($file_extension, $allowed_formats)) {
            $new_image = $_FILES['avatar']['name'];
            $image_path = 'uploads/' . basename($new_image);
            $target_path = 'uploads/' . basename($new_image);

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_path)) {
                $sqlCheckPath = "SELECT path FROM user_path WHERE user_id = '$user_id'";
                $resultCheckPath = $conn->query($sqlCheckPath);

                if ($resultCheckPath->num_rows > 0) {
                    $row = $resultCheckPath->fetch_assoc();
                    $old_image_path = 'uploads/' . $row['path'];

                    // Xoá hình ảnh cũ nếu tồn tại
                    if (!empty($old_image_path) && file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }

                // Cập nhật tên file mới vào bảng user_path
                $sqlUpdatePath = "UPDATE user_path SET path = '$new_image' WHERE user_id = '$user_id'";
                if ($conn->query($sqlUpdatePath) === TRUE) {
                    echo '<script>alert("Cập Nhật Ảnh Thành Công."); window.location.href = "../index.php";</script>';
                } else {
                    echo "Lỗi khi cập nhật ảnh đại diện: " . $conn->error;
                }
            } else {
                echo "Không thể tải lên ảnh mới.";
            }
        } else {
            echo "Định dạng tệp không hợp lệ. Chỉ JPG, JPEG, PNG và GIF được phép.";
        }
    } else {
        header("Location: ../index.php");
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">
    <title>Z9 | Đổi Avatar</title>
</head>

<body>
    <fieldset>
        <legend>Chọn Ảnh Mới</legend>
        <form action="" method="POST" enctype="multipart/form-data">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "z9milktea";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];

                $sqlGetImagePath = "SELECT path FROM user_path WHERE user_id = '$user_id'";
                $resultGetImagePath = $conn->query($sqlGetImagePath);

                if ($resultGetImagePath->num_rows > 0) {
                    $rowImagePath = $resultGetImagePath->fetch_assoc();
                    $imagePath = 'uploads/' . $rowImagePath['path'];

                    $web_image_path = 'http://localhost/z9milktea/admin/settings/' . $imagePath;

                    echo '<img class="user-setting-img" src="' . $web_image_path . '" alt="img-user">';
                } else {
                    echo '<p>Không có ảnh hiện tại</p>';
                }
            }
            ?>
            <input type="file" name="avatar" id="avatar" accept="image/*">
            <br>
            <button type="submit">Cập Nhật</button>
        </form>
    </fieldset>

</body>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Rethink+Sans:wght@400;500;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
    }
    body{
        margin-top: 100px;
    }

    fieldset {
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        max-width: 400px;
        margin: auto;
        text-align: center;
    }

    legend {
        font-size: 25px;
        text-align: center;
        padding: 0 20px;
        font-weight: 800;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .user-setting-img {
        width: 200px;
        height: 200px;
        margin: 10px 0;
        border-radius: 50%;
        border: 2px solid #000;
    }

    input[type="file"] {
        padding: 10px;
        margin-bottom: 15px;
        cursor: pointer;
    }

    button {
        background-color: #FFD400;
        color: #221F20;
        padding: 10px 50px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        font-weight: 700;
        transition: all 0.5s ease-in-out;
    }

    button:hover {
        background-color: #221F20;
        color: #FFD400;
    }
</style>

</html>