<html>
<head>
    <title>藝術家介紹</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="artistinfo.css?v=<?=time()?>">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/ad45004b60.js" crossorigin="anonymous"></script>

    <meta charset="utf-8">
  
</head>
<body>
<header style="background: black;">
        <div class="container" >
            <nav class="navbar navbar-expand-lg navbar-light ">
                <a class="navbar-brand" href="index.php">
                    <img src="logo1.png" >
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
                    <i class="fa-solid fa-bars" style="color: #ffffff;"></i>
                </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <ul class="navbar-nav mr-auto">
                
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" style="color:white;">首頁</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="exhibition.php" style="color:white;">展覽活動</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="artwork.php" style="color:white;">藝術作品</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="newticket.php" style="color:white;">購票服務</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" style="color:white;">會員中心</a>
                    </li>

                
                 </ul>
            </div>
            </nav>
        </div>
    </header>
    <h1>探索更多藝術家</h1>
    <HR width=100% color='#dddddd'>
    <br/>
    <br/>
    <br/>
<?php
$link = @mysqli_connect(
    'localhost',  // MySQL主機名稱
    'root',       // 使用者名稱
    'phpproject',  // 密碼
    'wanwan'  // 預設使用的資料庫名稱
);

if (!mysqli_select_db($link, 'wanwan')) {
    die("無法打開資料庫");
} else {
     "資料庫開啟成功!<br>";
}
$query = "SELECT * 
          FROM uuser U 
          WHERE U.user_role = 'artist'";

$result = mysqli_query($link, $query);

if ($result) {
    // 檢查是否有符合條件的紀錄
    if (mysqli_num_rows($result) > 0) {
        $count = 0; // 用於計算藝術家數量
        echo "<div class='row'>"; // 新增一個容器來包含每行的藝術家
        // 輸出每個藝術家的資訊
        while ($row = mysqli_fetch_assoc($result)) {
            $username = $row['user_name'];
            $userintro = $row['user_introduce'];
            $user_ID=$row['user_ID'];
            $usericon = $row['user_icon']; // 藝術家頭像

            // 顯示藝術家資訊
            echo "<a href='artist.php?owner_user_ID=$user_ID'>";
            echo "<div class='artist'>";
            echo "<div class='avatar' style='background-image: url($usericon)'></div>"; // 藝術家頭像
            echo "<h2>$username</h2>";
            echo "<p>介紹: $userintro</p>";

            // 查詢藝術家的作品
            $uuser_id = $row['user_ID'];
            $artworkQuery = "SELECT artwork_name, artwork_file 
                            FROM Artwork 
                            WHERE Artwork.user_id = '$uuser_id'
                            ORDER BY artwork_id DESC
                            LIMIT 1";

            $artworkResult = mysqli_query($link, $artworkQuery);

            if ($artworkResult && mysqli_num_rows($artworkResult) > 0) {
                // 輸出作品圖片
                echo "<div class='artwork'>";
                while ($artworkRow = mysqli_fetch_assoc($artworkResult)) {
                    $artworkName = $artworkRow['artwork_name'];
                    $artworkFile = $artworkRow['artwork_file'];

                    echo "<img src='$artworkFile' alt='$artworkName'>";
                }
                echo "</div>";
            } else {
                echo "<p>沒有作品可顯示。</p>";
            }

            echo "</div>"; // 分隔每個藝術家的資訊
            echo "</a>";

            $count++;
            // 如果藝術家數量達到3個，關閉當前行並開啟新行
            if ($count % 4 == 0) {
                echo "</div>"; // 關閉當前行
                echo "<div class='row'>"; // 開啟新行
            }
        }
        echo "</div>"; // 關閉最後一行的容器
    } else {
        echo "<p>沒有符合條件的藝術家紀錄。</p>";
    }
} else {
    echo "查詢失敗: " . mysqli_error($link);
}

// 關閉資料庫連接
mysqli_close($link);
?>
    <div class="back">
    <center>
        <a href="index.php"><button>返回藝廊首頁</button></a>
    </center>
</div>
        

</body>
</html>
