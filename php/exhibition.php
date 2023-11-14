<?php
    $link=mysqli_connect('localhost','root','phpproject','wanwan');
    $exhibition = "SELECT * FROM exhibition WHERE exhibition_status='進行中'";
    $result = mysqli_query($link,$exhibition);
?>
<html>
    <head>  
        <meta charset="utf-8">
        <title>展覽活動頁面</title>
        <link rel="stylesheet" href="exhibition.css?v=<?=time()?>">
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
            <li class = "nav-item">
                展覽活動頁面
            </li>
        </header>
        <section id="background-section">
        <?php
            echo "<div class='container'>";
            echo "<center>";
                echo "<table border=3 style:'font=blod'>";
                echo "<tr><td>藝術家</td><td>活動名稱</td><td>活動日期</td><td>活動地點</td><td>活動票價</td><td>活動詳情</td><td>活動連結</td><td>購票連結</td></tr>";
                $exhibition = "SELECT * FROM exhibition e JOIN (SELECT DISTINCT exhibition_ID,user_ID FROM artwork ) a ON a.exhibition_ID = e.exhibition_ID JOIN uuser u ON u.user_ID = a.user_id WHERE exhibition_status='進行中'";
                $result = mysqli_query($link,$exhibition);
                while( $row = mysqli_fetch_assoc($result) ){
                    echo "<tr><td>";
                    echo "<a href= 'artist.php?owner_user_ID=".$row["user_ID"]."' style='text-decoration: none; color:black'>".$row['user_name']."</a></td><td>";
                    echo "<a href= 'artwork_exhibition_detail.php?exhibition_ID=".$row["exhibition_ID"]."' style='text-decoration: none; color:black'>".$row['exhibition_name']."</a></td><td>";
                    echo $row['exhibition_start_time']."至".$row['exhibition_end_time']."</td><td>";
                    echo $row['exhibition_place']."</td><td>";
                    echo $row['exhibition_price']."</td><td>";
                    echo $row['exhibition_introduce']."</td><td>";
                    echo "<a href= 'artwork_exhibition_detail.php?exhibition_ID=".$row['exhibition_ID']."' style='text-decoration: none; color:black'>"."歡迎進入參觀"."</a></td><td>";
                    echo "<a href = 'newticket.php' style='text-decoration: none; color:black'>"."前往購票"."</a></td><td>";
                    echo "</td></tr>";
                }
                echo "</table>";
            echo "</center>";
            echo "</div>";
        ?>
        </section>
       <div class="back">
        <center>
        <a href="index.php"><button>返回藝廊首頁</button></a>
        </center>
    </body>
</html>
