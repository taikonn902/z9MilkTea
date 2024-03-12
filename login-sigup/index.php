
<?php
session_start();

include "../connectDB/connectDB.php";

// Đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["pass_word"];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }

    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $row = mysqli_fetch_assoc($result);
        $passwordFromDB = $row['pass_word'];

        if ($password == $passwordFromDB) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            header("Location: ../index.php");
            exit();
        } else {
            echo "Đăng nhập thất bại. Vui lòng kiểm tra lại tài khoản và mật khẩu.";
        }
    } else {
        echo "Tài khoản không tồn tại. Vui lòng đăng ký trước.";
    }
}

// Đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $userName = $_POST["user_name"];
    $email = $_POST["email"];
    $password = $_POST["pass_word"];

    // Kiểm tra email
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $checkEmailStmt = mysqli_prepare($conn, $checkEmailQuery);
    mysqli_stmt_bind_param($checkEmailStmt, "s", $email);
    mysqli_stmt_execute($checkEmailStmt);
    $checkEmailResult = mysqli_stmt_get_result($checkEmailStmt);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        echo "Email đã tồn tại. Vui lòng sử dụng email khác.";
    } else {
        // Tính toán user_id
        $getUserCountQuery = "SELECT COUNT(*) AS user_count FROM users";
        $getUserCountResult = mysqli_query($conn, $getUserCountQuery);
        $userCount = mysqli_fetch_assoc($getUserCountResult)['user_count'];

        if ($userCount < 10) {
            $user_id = "US00" . ($userCount + 1);
        } elseif ($userCount < 100) {
            $user_id = "US0" . ceil(($userCount + 1) / 10) . ($userCount + 1);
        } else {
            $user_id = "US" . ceil(($userCount + 1) / 100) . ($userCount + 1);
        }

        // Thêm người dùng mới
        $registerQuery = "INSERT INTO users (user_id, user_name, email, pass_word) VALUES (?, ?, ?, ?)";
        $registerStmt = mysqli_prepare($conn, $registerQuery);
        mysqli_stmt_bind_param($registerStmt, "ssss", $user_id, $userName, $email, $password);
        mysqli_stmt_execute($registerStmt);

        echo "Đăng ký thành công!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/login-signup.css">
    <title>Z9 | Login - Register</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST">
                <h1>Tạo Tài Khoản</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>    
                </div>
                <span>Hoặc sử dụng email và mật khẩu của bạn</span>
                <input name="user_name" type="text" placeholder="Name" required>
                <input name="email" type="email" placeholder="Email" required>
                <input name="pass_word" type="password" placeholder="Password" required>
                <button type="submit" name="register">Đăng Ký</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST">
                <h1>Đăng Nhập</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <span>Hoặc sử dụng email và mật khẩu của bạn</span>
                <input name="email" type="email" placeholder="Email" required>
                <input name="pass_word" type="password" placeholder="Password" required>
                <a href="#">Bạn quên mật khẩu?</a>
                <button type="submit" name="login">Đăng Nhập</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Chào Mừng Trở Lại</h1>
                    <p>Đăng nhập bằng tài khoản và mật khẩu của bạn</p>
                    <button class="hidden" id="login">Đăng Nhập</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Chào bạn!!</h1>
                    <p>Đăng ký tài khoản để sử dụng nhiều hơn các dịch vụ</p>
                    <button class="hidden" id="register">Đăng Ký</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-back-home">
        <button type="button">
            <a href="../index.php">Trở Về Trang Chủ</a>
        </button>
    </div>
</body>
<style>
    .container-back-home{
        position: absolute;
        top: 50px;
    }
    .container-back-home button{
        background: linear-gradient(to bottom right, #221f20, #5a5758, #d2bd53, #FFD400);
        padding: 15px 45px;
        border: none;
        border-radius: 10px;
    }

    .container-back-home button a{
        color: #fff;
        list-style: none;
        text-decoration: none;
        font-weight: 600;
    }
</style>

<script src="../js/login-signup.js"></script>
</html>

<script>
//     document.querySelector('.form-container.sign-in form').addEventListener('submit', function(e) {
//         e.preventDefault();

//         var loadingContainer = document.createElement('section');
//         loadingContainer.classList.add('loading-container');
//         loadingContainer.innerHTML = `
//         <div class="circle"></div>
//         <div class="circle"></div>
//         <div class="circle"></div>
//     `;
//         document.body.appendChild(loadingContainer);

//         setTimeout(function() {
//             window.location.href = '../index.php';
//         }, 2000);

    
// });
</script>

<style>
    .loading-container {
        position: fixed;
        justify-content: center;
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .circle {
        width: 20px;
        height: 20px;
        margin: 0 10px;
        border: 3px solid #000;
        border-radius: 50%;
        animation: bounce 0.5s infinite alternate;
    }
    
    .circle:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .circle:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes bounce {
        to {
            transform: translateY(-10px);
            border-color: #ffdb58;
        }
    }
</style>
