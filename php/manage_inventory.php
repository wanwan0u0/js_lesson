<script type="text/javascript">
function goBack(){
    window.history.go(-1);
}
</script>

<!DOCTYPE html>
<html>
<head>
    <title>庫存管理</title>
    <style>
        body {
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #008080;
            margin-top: 50px;
        }

        .inventory-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }

        .inventory-item {
            width: 300px;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .inventory-title {
            font-size: 18px;
            color: #008080;
            margin-bottom: 5px;
        }

        .inventory-info {
            font-size: 14px;
            color: #696969;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #008080;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #005F5F;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            display: inline-block;
            padding: 5px 10px;
            background-color: #008080;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #005F5F;
        }

        .artist-name {
            font-size: 14px;
            color: #696969;
            margin-bottom: 5px;
        }

        .manage-btns {
            display: flex;
            justify-content: space-between;
        }

        .edit-btn,
        .delete-btn {
            padding: 5px 10px;
            background-color: #008080;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover,
        .delete-btn:hover {
            background-color: #005F5F;
        }
    </style>
</head>
<body>
    <h1>庫存管理</h1>
    <a href="javascript:history.go(-1)" class="back-btn">返回上一頁</a>
    <?php
        // Start the session
        session_start();

        // Check if the user is logged in as admin
        if(isset($_SESSION['username']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'artist')) {
            // Connect to the database
            $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
            if(!$link) {
                die('Failed to connect to the database.');
            }

            // Query the database to retrieve inventory
            $query = "SELECT * FROM artwork JOIN uuser ON artwork.user_id = uuser.user_id where artwork_class='周邊商品' ORDER BY artwork.artwork_ID ASC";
            $result = mysqli_query($link, $query);

            if(mysqli_num_rows($result) > 0) {
                echo "<div class='inventory-section'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='inventory-item'>";
                    echo "<h3 class='inventory-title'>" . $row['artwork_name'] . "</h3>";
                    echo "<p class='artist-name'>藝術家：" . $row['user_name'] . "</p>";
                    echo "<p class='inventory-info'>類別：" . $row['artwork_type'] . "</p>";
                    echo "<p class='inventory-info'>庫存：" . $row['artwork_stock'] . "</p>";
                    echo "<div class='manage-btns'>";
                    echo "<a href='edit_inventory.php?artwork_id=" . $row['artwork_ID'] . "' class='edit-btn'>編輯</a>";
                    echo "<a href='delete_inventory.php?artwork_id=" . $row['artwork_ID'] . "' class='delete-btn'>刪除</a>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>目前庫存為空。</p>";
            }

            mysqli_free_result($result);
            mysqli_close($link);
        } else {
            echo "<p>您沒有權限訪問此頁面。</p>";
        }
    ?>
</body>
</html>
