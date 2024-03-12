<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="../css/style.css">

<?php
session_start();
?>

<div class="container-header">
    <header id="header-admin">
        <section class="header-admin-left">
            <img src="../images/logo.jpg" alt="logo">
        </section>

        <section class="header-admin-mid">
            <h1>TRANG QUẢN TRỊ</h1>
        </section>

        <section class="header-admin-right">
            <div class="container-title-hello-user">
                <p>Xin chào</p>

                <!-- php hello user -->
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

                        $sql = "SELECT user_name, role FROM users WHERE user_id = '$user_id'";

                        $result = $conn->query($sql);

                        if (!$result) {
                            die("Lỗi truy vấn: " . $conn->error);
                        }

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $user_name = $row['user_name'];
                            $user_role = $row['role'];

                            if ($user_role == 0) {
                                echo '<div class="container-title-hello-user">
                                    <span>' . $user_name . '</span>
                                </div>';
                            } else {
                                header('Location: /z9milktea/');
                                exit();
                            }
                        } else {
                            echo "Không tìm thấy thông tin người dùng.";
                        }
                    } else {
                        header('Location: /z9milktea/login-sigup/');
                        exit();
                    }

                    $conn->close();
                ?>
            </div>

            <div class="container-img-user">
                <a href="settings/edit-avt.php?user_id='. $user_id .'">
                    <?php
                    include "show-avt.php";
                    ?>
                </a>
            </div>
        </section>
    </header>
</div>

<style>
    .hidden {
        display: none;
    }

    ul,
    li,
    a {
        text-decoration: none;
        list-style: none;
    }

    .container-header {
        background: linear-gradient(to bottom right, #221f20, #5a5758, #d2bd53, #FFD400);
    }

    #header-admin {
        width: 85%;
        margin: 0px auto;
        display: flex;
        justify-content: space-between;
        position: relative;
        padding: 10px 0px 7px 0;
        align-items: center;
        z-index: 10;
    }

    .header-admin-left img {
        width: 80px;
        height: 80px;
        transition: transform 0.5s ease;
    }

    .header-admin-left img:hover {
        transform: translate(0) rotate(360deg);
    }

    .header-admin-mid {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
    }

    .header-admin-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .container-title-hello-user p {
        font-size: 13px;
        margin-bottom: 10px;
    }

    .container-title-hello-user span {
        font-size: 18px;
        font-weight: 700;
    }

    .container-img-user a img {
        width: 75px;
        height: 75px;
        cursor: pointer;
        transition: transform 0.5s;
        /* Thêm hiệu ứng chuyển động */
    }

    .container-img-user a:hover img {
        transform: rotate(-360deg);
    }
</style>