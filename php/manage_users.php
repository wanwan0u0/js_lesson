<script type="text/javascript">
function goBack(){
    window.history.go(-1);
}
</script>

<!DOCTYPE html>
<html>
<head>
    <title>管理使用者</title>
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

        .user-table {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-collapse: collapse;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-table th,
        .user-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .user-table th {
            background-color: #F5F5F5;
        }

        .user-table tr:hover {
            background-color: #F0F0F0;
        }

        .back-btn {
            display: inline-block;
            background-color: #ccc;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>管理使用者</h1>

    <?php
        // Start the session
        session_start();

        // Check if the user is logged in as admin
        if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            // Connect to the database
            $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
            if(!$link) {
                die('Failed to connect to the database.');
            }

            // Retrieve users from the database
            $query = "SELECT * FROM uuser";
            $result = mysqli_query($link, $query);

            if(mysqli_num_rows($result) > 0) {
                echo "<table class='user-table'>";
                echo "<tr>
                        <th>使用者名稱</th>
                        <th>角色</th>
                        <th>操作</th>
                    </tr>";

                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['user_name'] . "</td>";
                    echo "<td>" . $row['user_role'] . "</td>";
                    echo "<td>
                            <a href='edit_user.php?user_ID=" . $row['user_ID'] . "'>編輯</a> |
                            <a href='delete_user.php?user_ID=" . $row['user_ID'] . "'>刪除</a>
                        </td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>找不到使用者。</p>";
            }

            mysqli_free_result($result);
            mysqli_close($link);

            echo "<a class='back-btn' href='admin.php'>返回</a>";
        } else {
            echo "<p>您沒有權限訪問此頁面。</p>";
        }
    ?>
</body>
</html>
