<!DOCTYPE html>
<html>
<head>
    <title>編輯作品</title>
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

        .form-group .error {
            color: red;
        }

        .form-group .success {
            color: green;
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
    <h1>編輯作品</h1>
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
                    // retrieve the form data
                    $artworkName = $_POST['artwork_name'];
                    $artworkPrice = $_POST['artwork_price'];
                    $artworkInfo = $_POST['artwork_information'];

                    // check if a new image is uploaded
                    if($_FILES['artwork_image']['name'] !== '') {
                        $artworkImage = $_FILES['artwork_image']['name'];
                        $artworkImageTmp = $_FILES['artwork_image']['tmp_name'];

                        // move the uploaded image to the desired location
                        move_uploaded_file($artworkImageTmp, 'images/' . $artworkImage);
                    } else {
                        // if no new image is uploaded, retain the existing image
                        $query = "SELECT artwork_file FROM artwork WHERE artwork_ID = '$artworkID'";
                        $result = mysqli_query($link, $query);
                        $row = mysqli_fetch_assoc($result);
                        $artworkImage = $row['artwork_file'];
                    }

                    // update the artwork details in the database
                    $updateQuery = "UPDATE artwork SET artwork_name='$artworkName', artwork_information='$artworkInfo', artwork_price='$artworkPrice', artwork_information_html='".nl2br(strip_tags($artworkInfo))."' WHERE artwork_ID='$artworkID'";
                    $updateResult = mysqli_query($link, $updateQuery);

                    if($updateResult) {
                        echo "<div class='form-group success'>作品已成功更新。</div>";
                    } else {
                        echo "<div class='form-group error'>更新作品時發生錯誤。</div>";
                    }
                }

                // retrieve the artwork details from the database
                $query = "SELECT * FROM artwork WHERE artwork_ID = '$artworkID'";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_assoc($result);

                // display the edit artwork form
                echo "<div class='edit-form'>";
                echo "<form method='POST' enctype='multipart/form-data'>";
                echo "<div class='form-group'>";
                echo "<label>作品編號:</label>";
                echo "<input type='text' value='" . $row['artwork_ID'] . "' disabled>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>作品名稱:</label>";
                echo "<input type='text' name='artwork_name' value='" . $row['artwork_name'] . "'>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>作品價格:</label>";
                echo "<input type='text' name='artwork_price' value='" . $row['artwork_price'] . "'>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>作品資訊:</label>";
                echo "<textarea name='artwork_information'>" . $row['artwork_information'] . "</textarea>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>作品圖片:</label>";
                echo "<input type='file' name='artwork_image'>";
                echo "</div>";
                echo "<div class='form-actions'>";
                echo "<button type='submit' name='submit'>更新作品</button>";
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
