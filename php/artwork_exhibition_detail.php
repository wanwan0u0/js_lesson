<?php
    $link=mysqli_connect('localhost','root','phpproject','wanwan');
    $exhibition_id=$_GET['exhibition_ID'];
?>
<html>
<head>
    <meta charset="utf-8">
    <title>展覽資訊</title>
    <link rel="stylesheet" href="aedetail_style.css?v=<?=time()?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Open+Sans&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/ad45004b60.js" crossorigin="anonymous"></script>
</head>
<body>
<header style="background: black;">
    <a href="index.php" style='text-decoration: none;'>
        <img src="logo1.png">
    </a>

    <?php
        $exhibition="SELECT * FROM exhibition WHERE exhibition_ID = $exhibition_id";
        $ex=mysqli_query($link,$exhibition);
        $row = mysqli_fetch_assoc($ex);
            echo "<font size=50 style = 'color: antiquewhite;'>";
            echo $row['exhibition_name'];
            echo "</font>";
    ?>

</header>
    <div class = 'container' style="margin-top: 140px;">
        <?php
            $exhibition="SELECT DISTINCT artwork_file FROM exhibition JOIN artwork WHERE artwork.exhibition_ID = $exhibition_id";
            $ex=mysqli_query($link,$exhibition);
            echo "<nav class = 'left-side'>";
                echo "<div class='scroll-container'>";
                    while($row = mysqli_fetch_assoc($ex)){
                        echo "<img src='".$row['artwork_file']."' ></IMG>";
                    }
                echo "</div>";
            echo "</nav>";
            
            $exhibition="SELECT exhibition_introduce,exhibition_start_time,exhibition_end_time FROM exhibition where exhibition_ID='$exhibition_id'";
            $ex=mysqli_query($link,$exhibition);
            
            echo "<nav class ='right-side'>";
            $row = mysqli_fetch_assoc($ex);
                echo "<h3>展覽介紹</h3>";
                echo "<HR width=80% color='#dddddd'>";
                echo "<li>";
                echo $row['exhibition_introduce'];
                echo "</li>";
                echo "</br>";
                echo "<h3>展覽時間</h3>";
                echo "<HR width=80% color='#dddddd'>";
                echo "<li>";
                echo $row['exhibition_start_time']."至".$row['exhibition_end_time']."</td><td>";
                echo "</li>";
                echo "</br>";
                echo "<li>";
                echo "<a href='newticket.php'><button>前往購票</button></a></td><td>";
                echo "</li>";
                echo "</br>";
            
            echo "</nav>";

        ?>
    </div>
    <p>您可以點擊「了解更多」按鈕來查看詳細介紹。
    <a href="artistinfo.php"><button onclick="showMore('work1')">了解更多</button></a>
    <a href="exhibition.php"><button onclick="goBack('work1')">返回活動頁面</button></a>
    <br/>
    <br/>
    <br/>
    </p>
    <footer>
        <font color=black>&copy; 2023 資管系萬哥首展</font>
    </footer>
</body>
</html>
