<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z9 | Cập Nhật Thông Tin</title>

    <link rel="shortcut icon" href="./images/logo-ico.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Rethink+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<style>
    * {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        text-align: center;
        width: 80%;
        margin: 0px auto;
        /* background: linear-gradient(to right, #e2e2e2, #c9d6ff); */
    }

    fieldset {
        display: inline-block;
        padding: 20px 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin: 50px 0 20px 0;
        width: calc(50% - 20px);
        box-sizing: border-box;
        position: relative;
        background-color: #FFF;
    }

    legend {
        font-size: 20px;
        font-weight: bold;
        color: #221F20;
        padding: 0 20px;
    }

    form {
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .container-user-name,
    .container-email,
    .container-pass,
    .container-address-top,
    .container-address {
        margin-bottom: 15px;
        width: 100%;
    }

    .container-user-name,
    .container-email,
    .container-pass,
    .container-address-top>div,
    .container-address>div {
        width: 80%;
        margin: 0px auto;
        display: flex;
        flex-direction: column;
    }

    .container-user-name label,
    .container-email label,
    .container-pass label,
    .container-address-top>div>label,
    .container-address>div>label {
        margin: 10px 0 5px 0;
        font-weight: 600;
        text-align: left;
    }

    input {
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
    }

    .container-btn-edit-profile {
        display: block;
    }

    button a {
        color: #221F20;
        text-decoration: none;
    }

    button {
        background-color: #FFD400;
        color: #221F20;
        padding: 10px 30px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        margin-top: 20px;
        transition: color 0.3s ease, background-color 0.3s ease;
        overflow: hidden;
        position: relative;
        margin: 20px 20px;
    }

    button::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, #221F20);
        transition: left 0.5s ease-in-out;
    }

    button:hover::before {
        left: 100%;
        background: linear-gradient(to right, #000000, #221F20);
    }

    button:hover {
        color: #FFD400;
        background-color: #221F20;
    }

    button:hover a {
        color: #FFD400;
    }
</style>

<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user_id'])) {
        $loggedInUserId = $_SESSION['user_id'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "z9milktea";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $selectQuery = "SELECT * FROM user_des WHERE user_id = '$loggedInUserId'";
        $result = $conn->query($selectQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $soDienThoaiValue = $row['SDT'];
            $soNhaTenDuongValue = $row['soNhaTenDuong'];
            $phuongXaValue = $row['phuongXa'];
            $quanHuyenValue = $row['quanHuyen'];
            $tinhTPValue = $row['tinhTP'];

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $soDienThoai = $_POST['SDT'];
                $soNhaTenDuong = $_POST['soNhaTenDuong'];
                $phuongXa = $_POST['phuongXa'];
                $quanHuyen = $_POST['quanHuyen'];
                $tinhTP = $_POST['tinhTP'];

                // Thực hiện câu lệnh UPDATE
                $updateQuery = "UPDATE user_des SET SDT = '$soDienThoai', soNhaTenDuong = '$soNhaTenDuong', phuongXa = '$phuongXa', quanHuyen = '$quanHuyen', tinhTP = '$tinhTP' WHERE user_id = '$loggedInUserId'";

                if ($conn->query($updateQuery) === TRUE) {
                    echo "<script>alert('Cập nhật thông tin giao hàng thành công !!!'); window.location.href = 'index.php';</script>";
                    exit();
                } else {
                    echo "Lỗi: " . $updateQuery . "<br>" . $conn->error;
                }
            }
        } else {
            $soDienThoaiValue = "";
            $soNhaTenDuongValue = "";
            $phuongXaValue = "";
            $quanHuyenValue = "";
            $tinhTPValue = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $soDienThoai = $_POST['SDT'];
                $soNhaTenDuong = $_POST['soNhaTenDuong'];
                $phuongXa = $_POST['phuongXa'];
                $quanHuyen = $_POST['quanHuyen'];
                $tinhTP = $_POST['tinhTP'];

                $insertQuery = "INSERT INTO user_des (user_id, SDT, soNhaTenDuong, phuongXa, quanHuyen, tinhTP) VALUES ('$loggedInUserId', '$soDienThoai', '$soNhaTenDuong', '$phuongXa', '$quanHuyen', '$tinhTP')";

                if ($conn->query($insertQuery) === TRUE) {
                    echo "<script>alert('Thêm thông tin giao hàng thành công !!!'); window.location.href = 'index.php';</script>";
                    exit();
                } else {
                    echo "Lỗi: " . $insertQuery . "<br>" . $conn->error;
                }
            }
        }

        $conn->close();
    }
    ?>

    <fieldset>
        <legend>Thông Tin Giao Hàng</legend>
        <form method="POST">
            <div class="container-address-top">
                <div>
                    <label for="">Số Điện Thoại:</label>
                    <input type="text" name="SDT" required value="<?php echo $soDienThoaiValue; ?>">
                </div>

                <div>
                    <label for="">Số nhà / Tên đường:</label>
                    <input type="text" name="soNhaTenDuong" required value="<?php echo $soNhaTenDuongValue; ?>">
                </div>

                <div>
                    <label for="">Phường / Xã:</label>
                    <input type="text" name="phuongXa" required value="<?php echo $phuongXaValue; ?>">
                </div>

                <div>
                    <label for="">Quận / Huyện:</label>
                    <input type="text" name="quanHuyen" required value="<?php echo $quanHuyenValue; ?>">
                </div>

                <div>
                    <label for="">Tỉnh / TP:</label>
                    <input type="text" name="tinhTP" required value="<?php echo $tinhTPValue; ?>">
                </div>
            </div>
            <div class="container-btn-edit-profile ">
                <button type="button"><a href="index.php">Về Trang Chủ</a></button>
                <button type="submit">Lưu Thay Đổi</button>
            </div>
        </form>
    </fieldset>
</body>

</html>