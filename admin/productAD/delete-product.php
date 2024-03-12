<link rel="shortcut icon" href="../images/logo-ico.png" type="image/x-icon">
<title>Z9 | Xoá Sản Phẩm</title>

<body>
    <fieldset class="container-delete-form">
        <legend>Xoá Sản Phẩm</legend>

        <p>Bạn có chắc muốn xoá sản phẩm đã chọn?</p>
        <form method="POST" action="">
            <input type="hidden" name="product_id" value="<?php echo isset($_GET['product_id']) ? $_GET['product_id'] : ''; ?>">
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

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z9milktea";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteConfirmed']) && $_POST['deleteConfirmed'] == 'true') {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

        if (!empty($product_id)) {
            $sqlGetImage = "SELECT product_img FROM products WHERE product_id = '$product_id'";
            $resultGetImage = $conn->query($sqlGetImage);

            if ($resultGetImage->num_rows > 0) {
                $row = $resultGetImage->fetch_assoc();
                $product_img = $row['product_img'];

                if (!empty($product_img) && file_exists('uploads/' . $product_img)) {
                    unlink('uploads/' . $product_img);
                }

                $sqlDeleteSizes = "DELETE FROM product_sizes WHERE product_id = '$product_id'";
                $conn->query($sqlDeleteSizes);

                $sqlDeleteProduct = "DELETE FROM products WHERE product_id = '$product_id'";
                if ($conn->query($sqlDeleteProduct) === TRUE) {
                    echo '<script>window.location.href = "index.php";</script>';
                } else {
                    echo "Error deleting product: " . $conn->error;
                }
            } else {
                echo "Error retrieving product image information: " . $conn->error;
            }
        } else {
            echo "Product ID is empty.";
        }
    } else {
        echo "Delete not confirmed.";
    }
}

$conn->close();
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Rethink+Sans:wght@400;500;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
    }

    ul,
    li,
    a {
        text-decoration: none;
        list-style: none;
    }

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