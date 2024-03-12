<!-- Thêm id cho form để dễ truy cập trong JavaScript -->
<div class="container-form-cmt-list-cmt">
    <form class="container-user-comment" method="POST" id="commentForm">
        <div class="name-comment">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<span>' . $_SESSION['user_name'] . '</span>';
            }
            ?>
        </div>

        <div class="content-comment">
            <textarea name="comment" id="commentInput" placeholder="Nhập nội dung bạn muốn thảo luận..." required></textarea>
        </div>

        <div class="container-button-comment">
            <button type="submit">Đăng</button>
        </div>
    </form>

    <div id="commentListContainer" class="comment-list-container">
        <div id="commentList" class="comment-list">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "z9milktea";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if (isset($_GET['product_id'])) {
                $product_id_show = $_GET['product_id'];
            }

            // Lấy dữ liệu từ bảng comments
            $sql = "SELECT user_name, content, create_time FROM comments WHERE product_id = '$product_id_show' ORDER BY create_time DESC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $user_name = $row['user_name'];
                    $content = $row['content'];
                    $create_time = $row['create_time'];

                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    
                    $time_ago = strtotime($create_time);
                    $current_time = strtotime(date("Y-m-d H:i:s"));
                    $time_difference = $current_time - $time_ago;
                  
                    if ($time_difference < 60) {
                        $minutes = round($time_difference / 60);
                        $time_message = ($minutes == 0 || $minutes == 1) ? "Vừa tức thì" : "$minutes phút trước";
                    } elseif ($time_difference < 3600) {
                        $hours = round($time_difference / 3600);
                        $time_message = ($hours == 1) ? "1 giờ trước" : "$hours giờ trước";
                    } elseif ($time_difference < 86400) {
                        $hours = floor($time_difference / 3600);
                        $time_message = ($hours == 1) ? "1 giờ trước" : "$hours giờ trước";
                    } elseif ($time_difference < 604800) {
                        $days = floor($time_difference / 86400);
                        $time_message = ($days == 1) ? "Yesterday" : "$days ngày trước";
                    } elseif ($time_difference < 2419200) {
                        $weeks = floor($time_difference / 604800);
                        $time_message = ($weeks == 1) ? "A week ago" : "$weeks tuần trước";
                    } elseif ($time_difference < 29030400) {
                        $months = floor($time_difference / 2419200);
                        $time_message = ($months == 1) ? "A month ago" : "$months tháng trước";
                    } else {
                        $years = floor($time_difference / 29030400);
                        $time_message = ($years == 1) ? "A year ago" : "$years năm trước";
                    }
                    
                    echo '<div class="comment-item">';
                    echo '<div class="comment-info">';
                    echo '<span class="user-name">' . $user_name . '</span>';
                    echo '<span class="comment-time">' . $time_message . '</span>';
                    echo '</div>';
                    echo '<p class="comment-content">' . $content . '</p>';
                    echo '<div class="comment-buttons">';
                    echo '<button class="like-btn"><i class="fa-solid fa-thumbs-up"></i></button>';
                    echo '<button class="replace-btn">Phản hồi</button>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Chưa có bình luận nào cho sản phẩm này.";
            }

            mysqli_close($conn);
            ?>
        </div>
    </div>

    <style>
        .container-form-cmt-list-cmt {
            display: flex;
            height: auto;
            max-height: 500px;
        }

        .container-user-comment {
            display: inline-block;
            height: 420px;
            background-color: #EAD6EE;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .name-comment {
            margin-bottom: 10px;
        }

        .name-comment span {
            font-weight: bold;
        }

        .content-comment textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
            height: 300px;
            outline: none;
        }

        .container-button-comment button {
            padding: 10px;
            background-color: #A0F1EA;
            color: #221F20;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 700;
            transition: all ease-in-out 0.4s;
        }

        .container-button-comment button:hover {
            background-color: #221F20;
            color: #EAD6EE;
        }
    </style>

    <style>
        .comment-list-container {
            width: 100%;
            margin: 30px 0 0 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow-y: auto;
            max-height: 650px;
            scrollbar-width: thin;
            scrollbar-color: #888 #f2f2f2;
        }

        .comment-list-container::-webkit-scrollbar {
            width: 4px;
        }

        .comment-list-container::-webkit-scrollbar-thumb {
            background-color: #888;
        }

        .comment-list-container::-webkit-scrollbar-track {
            background-color: #f2f2f2;
        }

        .comment-list {
            display: flex;
            flex-direction: column;
        }

        .comment-item {
            margin-bottom: 10px;
        }

        .comment-info {
            display: flex;
            gap: 30px;
            margin-bottom: 10px;
        }

        .user-name {
            font-weight: bold;
            color: #333;
        }

        .comment-time {
            color: #1E90FF;
        }

        .comment-content {
            margin-bottom: 10px;
            color: #221F20;
            background-color: #A0F1EA;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <style>
        .comment-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .like-btn,
        .replace-btn {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .like-btn:hover,
        .replace-btn:hover {
            background-color: #0056b3;
        }
    </style>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "z9milktea";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            echo "User not logged in!";
            exit;
        }

        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
        } else {
            echo "Invalid request!";
            exit;
        }

        $user_name = $_SESSION['user_name'];
        $content = $_POST['comment'];

        $query = "INSERT INTO comments (product_id, user_name, content) VALUES ('$product_id', '$user_name', '$content')";

        if ($conn->query($query) === TRUE) {
            echo "<script></script>";
        } else {
            echo "Lỗi khi thêm bình luận: " . $conn->error;
        }

        mysqli_close($conn);
    } else {
        // echo "Invalid request!";
    }
    ?>