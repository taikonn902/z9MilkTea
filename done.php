<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/logo-ico.png" type="image/x-icon">

    <title>Z9 | Thanh Toán</title>
</head>

<body>
    <div class="container-done">
        <img src="images/done.png" alt="done">
        <h1> Đặt hàng thành công!!!</h1>
        <h2> Vòng kiểm tra tình trạng đơn hàng trong trang chủ.</h2>
        <div class="container-return">
            <button class="return-index" type="button" onclick="returnIndex()">Trở Về Trang Chủ</button>
        </div>
    </div>
</body>

<style>
    body {
        font-family: 'montserrat';
        background: linear-gradient(to right, #221f20, #5a5758, #d2bd53, #FFD400);
        position: relative;
    }

    .container-done {
        width: 700px;
        height: auto;
        padding: 50px;
        position: fixed;
        text-align: center;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
    }

    .container-done img {
        width: 300px;
    }

    .container-done h1,
    .container-done h2 {
        color: #fff;
    }

    .return-index {
        font-family: 'montserrat';
        margin-top: 20px;
        padding: 15px 50px;
        border: none;
        background-color: #FFD400;
        font-weight: 700;
        font-size: 20px;
        cursor: pointer;
        border-radius: 10px;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .return-index:hover {
        color: #FFD400;
        background-color: #221F20;
    }
</style>

<script>
    function returnIndex() {
        localStorage.removeItem('cartItems');
        window.location.href = 'index.php';
    }
</script>

</html>