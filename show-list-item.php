<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="shortcut icon" href="images/logo-ico.png" type="image/x-icon">
    <title>Z9 | Tất Cả Sản Phẩm</title>
</head>

<body>
    <?php
    include "./public/header.php";
    ?>

    <div class="container-list-product">
        <h3 class="link-nav-page">
            <button id="show-hide-bar-btn" type="button"><i class="fa-solid fa-bars"></i></button>
            <p><a href="index.php">Trang Chủ</a></p> <i class="fa-solid fa-circle-right"></i>
            <p><a href="#">Tất Cả Sản Phẩm</a></p>
        </h3>

        <section id="bar-container">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "z9milktea";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Kết nối CSDL thất bại: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM categorys";
            $result = $conn->query($sql);

            if ($result === false) {
                echo "Lỗi truy vấn: " . $conn->error;
                exit;
            }

            if ($result->num_rows > 0) {
                echo '<ul id="container-bar">';
                echo '<li data-category-id="all" data-php-file="all-item.php"><i class="fa-solid fa-tag"></i>Tất Cả Sản Phẩm</li>';

                while ($row = $result->fetch_assoc()) {
                    $category_id = $row["category_id"];
                    $category_name = $row["category_name"];
                    $php_file_name = strtolower(str_replace(' ', '', $category_name)) . ".php";

                    echo '<li data-category-id="' . $category_id . '" data-php-file="' . $php_file_name . '"><i class="fa-solid fa-tag"></i>' . $category_name . '</li>';
                }
                echo '</ul>';
            } else {
                echo "Không có danh mục sản phẩm.";
            }

            $conn->close();
            ?>
        </section>

        <section id="content-list-product">
            <!-- <div class="loading-container hidden">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div> -->

            <div class="container-content-list-product ">
                <div class="list-product-all-item">
                    <?php
                    include "./public/all-item.php";
                    ?>
                </div>
            </div>
        </section>
    </div>
</body>

<!-- filter -->
<style>
    .hidden{
        display: none;
    }

    .loading-container {
        text-align: center;
        position: absolute;
        justify-content: center;
        margin: 0;
        width: 100%;
        display: flex;
        align-items: center;
        height: 100%;
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

<!-- filter -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var categoryItems = document.querySelectorAll('#container-bar li');

        categoryItems.forEach(function(item) {
            item.addEventListener('click', function() {
                var categoryId = this.getAttribute('data-category-id');
                var phpFile = this.getAttribute('data-php-file');

                if (categoryId === 'all') {
                    loadContentAndDisplay('public/all-item.php');
                } else {
                    loadContentAndDisplay('public/filter-page/' + phpFile);
                }
            });
        });

        function loadContentAndDisplay(phpFile) {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;

                    document.getElementById('content-list-product').innerHTML = response;
                }
            };

            xhr.open('GET', phpFile, true);

            xhr.send();
        }
    });
</script>

<!-- show-hide slibar -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const barContainer = document.getElementById("bar-container");
        const contentListProduct = document.getElementById("content-list-product");
        const showHideBarButton = document.getElementById("show-hide-bar-btn");

        showHideBarButton.addEventListener("click", function() {
            const isOpen = barContainer.style.width === "20%";

            if (isOpen) {
                barContainer.style.width = "0";
                contentListProduct.style.width = "100%";
            } else {
                barContainer.style.width = "20%";
                contentListProduct.style.width = "80%";
            }

            showHideBarButton.classList.toggle("close", isOpen);
        });
    });
</script>

<style>
    .container-content-list-product {
        margin: 0px 20px 0px 20px;
    }

    .list-product-all-item {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        margin-right: -25px;
        margin-left: -15px;
    }

    .list-product-all-item .product-item {
        width: 23%;
        margin: 0px 10px 30px 10px;

    }
</style>

<style>
    .container-list-product {
        width: 95%;
        margin: 0px auto;
    }

    .link-nav-page {
        display: flex;
        gap: 10px;
        align-items: center;
        width: 80%;
        margin: 20px auto;
        padding: 10px 15px;
        position: relative;
    }

    .link-nav-page a {
        position: relative;
        transition: all ease-in-out 0.3s;
        padding: 10px 0;
        color: #221F20;
    }

    .link-nav-page a::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #221F20;
        transition: all ease-in-out 0.3s;
        transform: translateX(-50%);
    }

    .link-nav-page a:hover:after {
        width: 100%;
    }

    #show-hide-bar-btn {
        position: absolute;
        left: -75px;
    }

    #show-hide-bar-btn i {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        padding: 10px;
        background-color: #ffd400;
        transition: all ease-in-out 0.3s;
    }

    #show-hide-bar-btn:hover i {
        background-color: #221F20;
        color: #ffd400;
    }
</style>

<!-- nav-barr -->
<style>
    #bar-container {
        width: 20%;
        height: auto;
        background-color: #ffd400;
        position: fixed;
        transition: 0.5s;
        font-size: 18px;

    }

    #container-bar {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    #container-bar li {
        align-items: center;
        padding: 15px 15px;
        cursor: pointer;
        border-bottom: 1px solid #221f22;
        font-weight: 600;
        overflow: hidden;
        position: relative;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    #container-bar li:last-child {
        border-bottom: none;
    }

    #container-bar li::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, #221F20);
        transition: left 0.5s ease-in-out;
    }

    #container-bar li:hover::before {
        left: 100%;
        background: linear-gradient(to right, #000000, #221F20);
    }

    #container-bar li:hover {
        color: #FFD400;
        background-color: #221F20;
    }

    #container-bar li i {
        margin-right: 10px;
    }

    #content-list-product {
        width: 80%;
        float: right;
        height: 73vh;
        background-color: #ffffff;
        overflow-x: hidden;
        position: relative;
        transition: 0.5s;
        position: relative;
    }

    #content-list-product::-webkit-scrollbar {
        width: 0px;
    }

    #show-hide-bar-btn {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    #show-hide-bar-btn i {
        color: #333;
    }
</style>

<script src="js/add-.js"></script>

<!-- show-cart -->
<script>
    function showCart(event) {
        event.preventDefault();
        var showCart = document.getElementById('show-cart');
        var iconCart = event.currentTarget;
        var cartLengthElement = document.getElementById('lenght-cart');

        if (showCart.classList.contains('show')) {
            showCart.classList.remove('show');
            iconCart.style.color = '#221F20';
            cartLengthElement.style.color = '#221F20';
        } else {
            showCart.classList.add('show');
            iconCart.style.color = '#fff';
            cartLengthElement.style.color = '#fff';
        }
    }
</script>

</html>