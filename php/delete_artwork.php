<!DOCTYPE html>
<html>
<head>
    <title>刪除作品</title>
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

        .delete-form {
            width: 400px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #696969;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-actions {
            text-align: center;
        }

        .form-actions button {
            padding: 10px 20px;
            background-color: #008080;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-actions button:hover {
            background-color: #005959;
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
    <h1>刪除作品</h1>
    <?php
        // start the session
        session_start();

        // check if the user is logged in as admin
        if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            // check if the artwork ID is provided
            if(isset($_GET['artwork_id'])) {
                $artworkID = $_GET['artwork_id'];

                // connect to the database
                $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
                if(!$link) {
                    die('Failed to connect to the database.');
                }

                // check if the form is submitted
                if(isset($_POST['submit'])) {
                    // delete the artwork from the database
                    $deleteCollection="DELETE FROM collection_detail WHERE artwork_ID = '$artworkID'";
                    $deleteResult = mysqli_query($link, $deleteCollection);

                    $deleteQuery = "DELETE FROM artwork WHERE artwork_ID = '$artworkID'";
                    $deleteResult = mysqli_query($link, $deleteQuery);

                    if($deleteResult) {
                        echo "<div class='form-group'>作品已成功刪除。</div>";
                        // Redirect to manage_artwork.php after successful deletion
                        header('Location: manage_artwork.php');
                        exit;

                    } else {
                        echo "<div class='form-group'>刪除作品時發生錯誤。</div>";
                    }
                }

                // retrieve the artwork details from the database
                $query = "SELECT * FROM artwork WHERE artwork_ID = '$artworkID'";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_assoc($result);

                // display the delete artwork form
                echo "<div class='delete-form'>";
                echo "<form method='POST'>";
                echo "<div class='form-group'>";
                echo "<label>作品編號:</label>";
                echo "<input type='text' value='" . $row['artwork_ID'] . "' disabled>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>作品名稱:</label>";
                echo "<input type='text' value='" . $row['artwork_name'] . "' disabled>";
                echo "</div>";
                echo "<div class='form-actions'>";
                echo "<button type='submit' name='submit'>刪除作品</button>";
                echo "</div>";
                echo "</form>";
                echo "</div>";

                mysqli_free_result($result);
                mysqli_close($link);
            } else {
                echo "<p>未提供作品編號。</p>";
            }
        } else {
            echo "<p>您沒有權限訪問此頁面。</p>";
        }
    ?>
    <div class="back-arrow" onclick="goBack()">&#8592;</div>
    <script>
        function goBack() {
            window.location.href = 'manage_artwork.php';
        }
    </script>
</body>
</html>
