<script type="text/javascript">
function goBack(){
    window.history.go(-1);
}
</script>

<!DOCTYPE html>
<html>
<head>
    <title>管理展覽</title>
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

        .exhibition-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }

        .exhibition-item {
            width: 300px;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .exhibition-title {
            font-size: 18px;
            color: #008080;
            margin-bottom: 5px;
        }

        .exhibition-info {
            font-size: 14px;
            color: #696969;
        }

        .edit-button {
            background-color: #008080;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button {
            background-color: #FF0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-arrow {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 20px;
            color: #008080;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>管理展覽</h1>
    <?php
    // start the session
    session_start();

    // check if the user is logged in as admin
    if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
        // connect to the database
        $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
        if(!$link) {
            die('Failed to connect to the database.');
        }

        // query the database to retrieve exhibitions
        $query = "SELECT * FROM exhibition";
        $result = mysqli_query($link, $query);

        if(mysqli_num_rows($result) > 0) {
            echo "<div class='exhibition-section'>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='exhibition-item'>";
                echo "<h3 class='exhibition-title'>" . $row['exhibition_name'] . "</h3>";
                echo "<p class='exhibition-info'>開始時間: " . $row['exhibition_start_time'] . "</p>";
                echo "<p class='exhibition-info'>結束時間: " . $row['exhibition_end_time'] . "</p>";
                echo "<p class='exhibition-info'>地點: " . $row['exhibition_place'] . "</p>";
                echo "<p class='exhibition-info'>價格: " . $row['exhibition_price'] . "</p>";
                echo "<p class='exhibition-info'>狀態: " . $row['exhibition_status'] . "</p>";
                echo "<a href='edit_exhibition.php?exhibition_ID=" . $row['exhibition_ID'] . "' class='edit-button'>編輯</a>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>目前沒有展覽。</p>";
        }

        mysqli_free_result($result);
        mysqli_close($link);
    } else {
        echo "<p>您沒有權限訪問此頁面。</p>";
    }
    ?>
    <div class="back-arrow" onclick="goBack()">&#8592;</div>
</body>
</html>
