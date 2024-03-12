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
        echo '<img src="' . $web_image_path . '" alt="img-user">';
    } else {
        echo "Image not found.";
    }
} else {
    echo "User ID is not set in session.";
}

?>

<style>
    img {
        border-radius: 50%;
    }
</style>