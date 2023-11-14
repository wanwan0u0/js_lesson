<?php
    $link=mysqli_connect('localhost','root','phpproject','wanwan');
    $artwork_ID=$_GET['artwork_ID'];    
    @$order_ID = $_GET['order_ID'];
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="product.css?v=<?=time()?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Open+Sans&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ad45004b60.js" crossorigin="anonymous"></script>
    </head>
    <body style="background-color: white;">
        <header style="background: black;">
            <a href="index.php">
                <img src="logo1.png">
            </a>
            <li class="nav-item">
            <?php
                $uuser="SELECT * FROM oorder o JOIN uuser u on o.user_ID=u.user_ID";
                $user_reslut=mysqli_query($link,$uuser);
                $row = mysqli_fetch_assoc($user_reslut);
                if(isset($_SESSION['username'])){
                    //需要order_ID
                    echo "<a href= 'cart.php' style='color:white; text-decoration: none;'><span class='title'>購物車</span></a>";
                }else{
                    echo "<a href= 'login.php'".$order_ID."'' style='color:white; text-decoration: none;'><span class='title'>購物車</span></a>";
                }
            ?>
            </li>
        </header>

        <?php
            $AW_infor='SELECT * FROM artwork WHERE artwork_ID = '.$artwork_ID;  //當artwork table 中的artwork_ID=GET到的值，把所有資訊抓出來
            $artworkinformation=mysqli_query($link,$AW_infor);
            while( $row = mysqli_fetch_assoc($artworkinformation) ){
                echo "<ul>";
                echo "<nav class = 'left-side'>";
                echo "<img src='".$row['artwork_file']."' ></IMG>";

                echo "</nav>";

                echo "<nav class ='right-side'>";

                    echo "<br/>"."<li>"."商品名稱：";
                    echo $row['artwork_name'];
                    echo "</li>"."<br/>"."<li>"."商品資訊：";
                    echo $row['artwork_information'];
                    echo "</li>"."<br/><li>"."單價：NT$";
                    echo $row['artwork_price'];
                    echo "</li>"."<br/><li>"."庫存數量：";
                    echo $row ['artwork_stock'];
                    echo "</li>";
                    echo "<br/>";
                    echo "<form action = 'order_procession.php' method = 'post'>";
                    echo "<div class = 'button' style='margin-top: 20px; border-radius: 25px; color=black'>";
                    if(isset($_SESSION['username'])){   //有登入的使用者
                        //需要傳值: artwork_ID、order_ID
                        echo "<br/>";
                        echo "<form action = 'order_procession.php' method = 'post'>";  //傳值給order_procession
                        echo "<div class = 'button' style='margin-top: 20px; border-radius: 25px; color=black'>";

                        if($row['artwork_stock']!=0){
                            echo "數量";
                            echo "<input name = 'quantity' type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        }else{
                            echo "商品已售完";
                        }
                        //echo "<input type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        echo "</div>";
                        echo "<br/>";
                        if($row['artwork_stock']!=0){
                            echo "<input name = 'cart' type= 'submit' value='加入購物車' style='margin-top: 20px; border-radius: 25px; color=black'>";
                        }
                        else{
                        }
                        echo "<input name = 'artwork_ID' type='hidden' value='".$row["artwork_ID"]."'>";
                        echo "<input name = 'order_ID' type = 'hidden' value='$order_ID'>";
                        echo "</form>";

                    }else{
                        echo "<br/>";
                        echo "<div action = 'button' style='margin-top: 20px; border-radius: 25px; color=black'>";

                        if($row['artwork_stock']!=0){
                            echo "購買數量：";
                            echo "<input type='number' name = 'quantity' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        }else{
                            echo "<span style='color: red;'>商品已售完</span>";
                        }
                        echo "</div>";
                        echo "<div class=detail>";
                        echo "<button style='margin-top: 20px; border-radius: 25px;'>"."<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."'>"."詳細資訊"."</a>"."</button>";
                        echo "</div>";
                        if($row['artwork_stock']!=0){
                            echo "<div class=add>";
                            echo "<style='margin-top: 20px; border-radius: 5px; color=black'><a href = login.php>加入購物車</a></style>";
                            echo "</div>";
                        }
                        else{
                        }
                        echo "</div>";
                    }

                    echo "<button style='margin-top: 20px; border-radius: 25px;'><a href = 'artwork.php'>"."返回上一頁"."</a></button>";
                echo "</nav>";
                }
        ?>
    </body>
</html>
