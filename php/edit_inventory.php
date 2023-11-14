<!DOCTYPE html>
<html>
<head>
    <title>編輯庫存</title>
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
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            color: #696969;
            margin-bottom: 5px;
        }

        .form-input {
            width: 100%;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #008080;
            color: #fff;
            text-decoration: none;
            text-align: center;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #005F5F;
        }
    </style>
</head>
<body>
    <h1>編輯庫存</h1>
    <?php
        // Start the session
        session_start();

        // Check if the user is logged in as admin or seller
        if(isset($_SESSION['username']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'seller')) {
            // Check if the artwork_id is provided
            if(isset($_GET['artwork_id'])) {
                // Get the artwork_id from the URL
                $artwork_id = $_GET['artwork_id'];

                // Connect to the database
                $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
                if(!$link) {
                    die('Failed to connect to the database.');
                }

                // Retrieve the artwork information
                $query = "SELECT * FROM artwork WHERE artwork_ID = '$artwork_id'";
                $result = mysqli_query($link, $query);

                if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="edit-form">
                        <form action="update_inventory.php" method="POST">
                            <input type="hidden" name="artwork_id" value="<?php echo $row['artwork_ID']; ?>">
                            <div class="form-group">
                                <label class="form-label">庫存數量</label>
                                <input type="number" name="artwork_stock" value="<?php echo $row['artwork_stock']; ?>" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">藝術品類型</label>
                                <input type="text" name="artwork_type" value="<?php echo $row['artwork_type']; ?>" class="form-input" required>
                            </div>
                            <input type="submit" value="儲存" class="submit-btn">
                        </form>
                    </div>
                    <?php
                } else {
                    echo "<p>找不到指定的作品。</p>";
                }

                mysqli_free_result($result);
                mysqli_close($link);
            } else {
                echo "<p>未提供作品編號。</p>";
            }
        } else {
            echo "<p>您沒有權限訪問此頁面。</p>";
        }
    ?>
</body>
</html>
