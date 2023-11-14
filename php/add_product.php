<!DOCTYPE html>
<html>
<head>
    <title>新增產品</title>
    <style>
        /* CSS样式代码 */
    </style>
</head>
<body>
    <h1>新增產品</h1>
    <?php
        // Start the session
        session_start();

        // Check if the user is logged in as admin
        if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
            // Connect to the database
            $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
            if (!$link) {
                die('Failed to connect to the database.');
            }

            // Check if the form is submitted
            if (isset($_POST['submit'])) {
                // Get the form data
                $productName = $_POST['product_name'];
                $productPrice = $_POST['product_price'];
                $productType = $_POST['product_type'];
                $productInformation = $_POST['product_information'];
                $productClass = '周邊商品'; // 默认类别为'周邊商品'
                $artistID = $_POST['artist_id'];
                $productStock = $_POST['product_stock'];

                // Upload the artwork file
                $targetDirectory = ''; // 上传文件存储目录
                $targetFile = $targetDirectory . basename($_FILES['artwork_file']['name']);
                $uploadSuccess = move_uploaded_file($_FILES['artwork_file']['tmp_name'], $targetFile);

                if ($uploadSuccess) {
                    // Insert the product into the database
                    $insertQuery = "INSERT INTO artwork (artwork_name, artwork_price, artwork_type, artwork_information, artwork_class, artwork_file, user_ID, artwork_stock) VALUES ('$productName', '$productPrice', '$productType', '$productInformation', '$productClass', '$targetFile', '$artistID', '$productStock')";
                    $insertResult = mysqli_query($link, $insertQuery);

                    if ($insertResult) {
                        echo "<div class='form-group'>產品已成功新增。</div>";
                    } else {
                        echo "<div class='form-group'>新增產品時發生錯誤。</div>";
                    }
                } else {
                    echo "<div class='form-group'>圖片上傳失敗。</div>";
                }
            }

            // Display the add product form
            echo "<div class='add-form'>";
            echo "<form method='POST' enctype='multipart/form-data'>";
            echo "<div class='form-group'>";
            echo "<label>產品名稱:</label>";
            echo "<input type='text' name='product_name'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label>產品價格:</label>";
            echo "<input type='text' name='product_price'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label>產品種類:</label>";
            echo "<input type='text' name='product_type'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label>產品介紹:</label>";
            echo "<textarea name='product_information'></textarea>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label>藝術家:</label>";
            echo "<select name='artist_id'>";
            
            // Retrieve the list of artists from the database
            $artistQuery = "SELECT * FROM uuser where user_role='artist'";
            $artistResult = mysqli_query($link, $artistQuery);

            while ($artistRow = mysqli_fetch_assoc($artistResult)) {
                echo "<option value='" . $artistRow['user_ID'] . "'>" . $artistRow['user_name'] . "</option>";
            }
            
            echo "</select>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label>產品圖片:</label>";
            echo "<input type='file' name='artwork_file'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label>庫存量:</label>";
            echo "<input type='text' name='product_stock'>";
            echo "</div>";
            echo "<div class='form-actions'>";
            echo "<button type='submit' name='submit'>新增產品</button>";
            echo "</div>";
            echo "</form>";
            echo "</div>";

            mysqli_close($link);
        } else {
            echo "<p>您沒有權限訪問此頁面。</p>";
        }
    ?>
    <div class="back-arrow" onclick="goBack()">&#8592;</div>
    <script>
        function goBack() {
            window.location.href = 'admin.php';
        }
    </script>
</body>
</html>
