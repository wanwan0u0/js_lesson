<!DOCTYPE html>
<html>
<head>
    <title>編輯使用者</title>
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

        .edit-form {
            width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input[type="submit"] {
            background-color: #008080;
            color: #fff;
            cursor: pointer;
        }

        .form-group .back-btn {
            background-color: #ccc;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>編輯使用者</h1>

    <?php
        // Start the session
        session_start();

        // Check if the user is logged in as admin
        if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            // Check if user ID is provided in the URL
            if(isset($_GET['user_ID'])) {
                $userID = $_GET['user_ID'];

                // Connect to the database
                $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
                if(!$link) {
                    die('Failed to connect to the database.');
                }

                // Retrieve user information from the database
                $query = "SELECT * FROM uuser WHERE user_ID = '$userID'";
                $result = mysqli_query($link, $query);

                if(mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $userName = $row['user_name'];
                    $userRole = $row['user_role'];

                    // Handle form submission
                    if($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $newUserName = $_POST['user_name'];
                        $newUserRole = $_POST['user_role'];

                        // Update user information in the database
                        $updateQuery = "UPDATE uuser SET user_name = '$newUserName', user_role = '$newUserRole' WHERE user_ID = '$userID'";
                        $updateResult = mysqli_query($link, $updateQuery);

                        if($updateResult) {
                            echo "<p>使用者資訊已成功更新。</p>";
                        } else {
                            echo "<p>更新使用者資訊時發生錯誤。</p>";
                        }
                    }
                } else {
                    echo "<p>找不到該使用者。</p>";
                }

                mysqli_free_result($result);
                mysqli_close($link);
            } else {
                echo "<p>未提供使用者編號。</p>";
            }
        } else {
            echo "<p>您沒有權限訪問此頁面。</p>";
        }
    ?>

    <div class="edit-form">
        <form method="POST" action="">
            <div class="form-group">
                <label for="user_name">使用者名稱:</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo $userName; ?>" required>
            </div>
            <div class="form-group">
                <label for="user_role">角色:</label>
                <select id="user_role" name="user_role" required>
                    <option value="admin" <?php if($userRole == 'admin') echo 'selected'; ?>>管理員</option>
                    <option value="seller" <?php if($userRole == 'user') echo 'selected'; ?>>使用者</option>
                    <option value="artist" <?php if($userRole == 'artist') echo 'selected'; ?>>藝術家</option>
                    <option value="banned" <?php if($userRole == 'banned') echo 'selected'; ?>>封鎖</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="更新">
                <a class="back-btn" href="manage_users.php">返回</a>
            </div>
        </form>
    </div>
</body>
</html>
