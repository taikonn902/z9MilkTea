<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo-ico.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/custom-scrol.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Z9 - MilkTea For Your Life</title>
</head>

<body>
    <?php
    include "./public/header.php";
    ?>

    <div class="container-main">
        <main id="content-page">
            <?php
            include "./public/banner.php";
            ?>

            <h1 class="slogan-page">Cảm Nhận Vị Ng<span>ọt Và Sự Tinh Tế</span></h1>

            <div class="container-let-item">
                <div class="hand-down"><i class="fa-regular fa-hand-point-right"></i></div>
                <button type="button" class="let-item" onclick="scrollDown()">
                    Khám Phá Ngay
                </button>
                <div class="hand-up"><i class="fa-regular fa-hand-point-left"></i></div>
            </div>

            <section class="new-item" id="NewItems">
                <div class="top-new-items">
                    <h1>Sản Ph<span>ẩm Mới</span></h1>

                    <div class="see-all">
                        <button type="button" class="see-add-btn">
                            <a href="show-list-item.php">Xem Tất Cả Sản Phẩm</a>
                        </button>
                    </div>

                    <style>
                        button a {
                            color: #221F20;
                            text-decoration: none;
                        }

                        button:hover a {
                            color: #FFD400;
                        }

                        .slogan-page {
                            text-align: center;
                            margin: 20px 0 10px 0;
                            padding: 20px;
                            border-top: 1px solid #FFD400;
                        }
                        .slogan-page span{
                            color: #FFD400;
                        }
                    </style>
                </div>

                <div class="product-list">
                    <?php
                    include "./public/new-item.php";
                    ?>
                </div>
            </section>

            <section class="new-item">
                <div class="top-new-items">
                    <h1>Best S<span>ellers</span></h1>
                </div>
                <div class="product-list">
                    <?php
                    include "./public/best-sale.php";
                    ?>
                </div>
            </section>
        </main>
    </div>

    <div class="container-footer">

    </div>
</body>

<script src="js/app.js"></script>
<script src="js/add-.js"></script>

</html>