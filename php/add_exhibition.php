<script type="text/javascript">
function goBack(){
    window.history.go(-1);
}
</script>


<!DOCTYPE html>
<html>
<head>
    <title>新增展覽</title>
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

        .add-form {
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
    <h1>新增展覽</h1>
    <div class="add-form">
    <?php
// start the session
session_start();

// check if the user is logged in as admin
if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
    // check if the form is submitted
    if (isset($_POST['submit'])) {
        // retrieve form data
        $exhibitionName = $_POST['exhibition_name'];
        $exhibitionIntroduce = $_POST['exhibition_introduce'];
        $exhibitionStartTime = $_POST['exhibition_start_time'];
        $exhibitionEndTime = $_POST['exhibition_end_time'];
        $exhibitionPlace = $_POST['exhibition_place'];
        $exhibitionPrice = $_POST['exhibition_price'];
        $ticketStock = $_POST['ticketSTOCK'];
        $artistID = $_POST['artist_id'];
        $exhibition_alert = $_POST['exhibition_alert'];

        // connect to the database
        $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
        if (!$link) {
            die('Failed to connect to the database.');
        }

        // insert exhibition data into the database
        $exhibitionquery = "INSERT INTO exhibition (exhibition_name, exhibition_introduce, exhibition_start_time, exhibition_end_time, exhibition_place, exhibition_price,exhibition_alert, exhibition_status) VALUES ('$exhibitionName', '$exhibitionIntroduce', '$exhibitionStartTime', '$exhibitionEndTime', '$exhibitionPlace', '$exhibitionPrice','$exhibition_alert', '未開始')";
        $exhibitionresult = mysqli_query($link, $exhibitionquery);
        $ticketquery = "INSERT INTO ticket (ticket_stock, exhibition_ID) SELECT '$ticketStock', exhibition_ID FROM exhibition WHERE exhibition_name = '$exhibitionName'";
        $ticketresult = mysqli_query($link, $ticketquery);
        
        

        if ($exhibitionresult) {
            echo "<p>展覽已成功新增。</p>";
        
        
            // Update the artwork's exhibition_ID
            // Update the artwork's exhibition_ID
            if (isset($_POST['selected_artworks'])) {
                $selectedArtworks = $_POST['selected_artworks'];
            foreach ($selectedArtworks as $artworkID) {
            // Update the artwork's exhibition_ID
                $updateQuery = "UPDATE artwork SET exhibition_ID = (SELECT exhibition_ID FROM exhibition WHERE exhibition_name='$exhibitionName' ) WHERE artwork_ID = '$artworkID'";
                mysqli_query($link, $updateQuery);
            }
        }

        } else {
            echo "<p>新增展覽時發生錯誤。</p>";
        }

        mysqli_close($link);
    } else {
        // Retrieve artists from the database
        $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
        if (!$link) {
            die('Failed to connect to the database.');
        }
        $artistQuery = "SELECT * FROM uuser WHERE user_role='artist'";
        $artistResult = mysqli_query($link, $artistQuery);
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>展覽名稱:</label>
                <input type="text" name="exhibition_name" required>
            </div>
            <div class="form-group">
                <label>展覽介紹:</label>
                <textarea name="exhibition_introduce" required></textarea>
            </div>
            <div class="form-group">
                <label>展覽開始時間:</label>
                <input type="datetime-local" name="exhibition_start_time" required>
            </div>
            <div class="form-group">
                <label>展覽結束時間:</label>
                <input type="datetime-local" name="exhibition_end_time" required>
            </div>
            <div class="form-group">
                <label>展覽地點:</label>
                <input type="text" name="exhibition_place" required>
            </div>
            <div class="form-group">
                <label>展覽價格:</label>
                <input type="number" name="exhibition_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label>門票發售量:</label>
                <input type="number" name="ticketSTOCK" step="0.01" required>
            </div>
            <div class="form-group">
                <label>展覽是否限制18歲以上觀眾:</label>
                <input type="checkbox" name="exhibition_alert" value="1">
            </div>
            
            <div class="form-group">
                <label>藝術家:</label>
                <select name="artist_id" id="artist-select" required>
                    <option value="">請選擇藝術家</option>
                    <?php while ($artist = mysqli_fetch_assoc($artistResult)) { ?>
                        <option value="<?php echo $artist['user_ID']; ?>"><?php echo $artist['user_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>作品:</label>
                <select name="selected_artworks[]" id="artwork-select" multiple required>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit">新增展覽</button>
            </div>
        </form>
        <?php
    }
} else {
    echo "<p>您沒有權限訪問此頁面。</p>";
}
?>


    </div>
    <div class="back-arrow" onclick="goBack()">&#8592;</div>
    <script>
    // Load artworks based on selected artist
    document.getElementById('artist-select').addEventListener('change', function() {
        var artistID = this.value;
        var artworkSelect = document.getElementById('artwork-select');
        artworkSelect.innerHTML = ''; // Clear previous options

        if(artistID !== '') {
            // Send AJAX request to retrieve artworks
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_artworks.php?artist_id=' + artistID, true);
            xhr.onload = function() {
                if(xhr.status === 200) {
                    var artworks = JSON.parse(xhr.responseText);
                    for(var i = 0; i < artworks.length; i++) {
                        var option = document.createElement('option');
                        option.value = artworks[i].artwork_ID;
                        option.textContent = artworks[i].artwork_name;
                        artworkSelect.appendChild(option);
                    }
                }
            };
            xhr.send();
        }
    });
</script>
</body>
</html>
