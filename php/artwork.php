<?php
    session_start();
    $link=mysqli_connect('localhost','root','phpproject','wanwan');

    $order='SELECT * FROM oorder';
    $order_result=mysqli_query($link,$order);
    while($row = mysqli_fetch_assoc($order_result)){
        $order_ID = $row['order_ID'];
    }

    $order="SELECT * FROM order_artwork_detail where order_ID=$order_ID";
    $order_result=mysqli_query($link,$order);
    $row = mysqli_fetch_assoc($order_result);
    if(@$row['OAD_status']=='0'){

    }else{
        $order_ID++;
    }
    $artwork_data = array(); // 建立空的關聯陣列 $artwork_data

$result = mysqli_query($link, "SELECT DISTINCT artwork_class, artwork_type FROM artwork WHERE artwork_type != '下架'");
$test= mysqli_query($link,"SELECT DISTINCT artwork_class FROM artwork where artwork_class!='' ");
    if (mysqli_num_rows($result) > 0) {
        while($more = mysqli_fetch_assoc($test)){
            $artwork_class[] = $more['artwork_class'];
            while ($row = mysqli_fetch_assoc($result)) {
            $artwork_type = $row['artwork_type'];
            if($artwork_type==""){

            }
            else{ 
            // 將 artwork_type 添加到對應的 artwork_class 陣列中
            $artwork_data[$row['artwork_class']][] = $artwork_type;
            }
        }
        }
    }
else {
        echo "沒有找到匹配的記錄。";
}

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>藝術商品頁面</title>
        <link rel="stylesheet" href="artwork.css?v=<?=time()?>">
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
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="index.php">
                    <img src="logo1.png">
                </a>    
                <a href="#" style="text-decoration: none;">
                    <h1>藝術商品頁面</h1>
                </a>
                <ul class="navbar-nav ">
                    <li class="nav-item">
                        <span class="title"><a href="#section0">所有商品</span>
                        <ul class="sub-nav">
                        <?php
                            for ($i = 0; $i < count($artwork_class); $i++) {
                                echo "<li><a href='#" . $artwork_class[$i] . "'>" . $artwork_class[$i] . "</a></li>";
                            }
                        ?>

                        </ul>
                    </li>

                    
                    <?php
                        echo "<ul class='navbar-nav '>";            
                        
                        for ($i = 0; $i < count($artwork_class); $i++) {
                            echo "<li class='nav-item'>";
                            echo '<span class="title"><a href="#' . $artwork_class[$i] . '">' . $artwork_class[$i] . '</a></span>';
                            echo '<ul class="sub-nav">';
                            for ($n = 0; $n < count($artwork_data[$artwork_class[$i]]); $n++) {
                                
                                echo '<li><a href="#' . $artwork_data[$artwork_class[$i]][$n] . '">' . $artwork_data[$artwork_class[$i]][$n] . '</a></li>';
                                
                            }
                            echo '</ul>';
                            echo '</li>';
                        }
                        echo "</ul>";
                    ?>

                    <li class="nav-item">
                        <?php
                        $uuser="SELECT * FROM oorder o JOIN uuser u on o.user_ID=u.user_ID";
                        $user_reslut=mysqli_query($link,$uuser);
                        $row = mysqli_fetch_assoc($user_reslut);
                        if(isset($_SESSION['username'])){
                            //需要order_ID
                            echo "<a href= 'cart.php' style='text-decoration: none;'><span class='title'>購物車</span></a>";
                        }else{
                            echo "<a href= 'login.php' style='text-decoration: none;'".$order_ID."''><span class='title'>購物車</span></a>";
                            
                        }
                        ?>
                    </li>
                </ul>
            </nav>
        </header>
    <?php
        echo "<p id='section1'>熱門商品";
        echo "<HR width=100% color='#dddddd'>";
            echo "<div class=scroll-container>";
                $hot_work="SELECT *, SUM(order_artwork_detail.OAD_Quantity) AS all_art FROM artwork JOIN order_artwork_detail ON artwork.artwork_ID = order_artwork_detail.artwork_ID WHERE OAD_status!=0 GROUP BY artwork.artwork_ID ORDER BY all_art DESC	LIMIT 3";
                $hot_art=mysqli_query($link,$hot_work);
                while( $row = mysqli_fetch_assoc($hot_art) ){
                    if($row ['artwork_price']!=null){
                        echo "<ul>";
                        echo "<a href= 'product.php?artwork_ID=".$row['artwork_ID']."&order_ID=".$order_ID."'><img src='".$row['artwork_file']."' ></IMG></a>";
                        echo "<br/>";
                        echo "<br/><span><i class='fa-solid fa-pen-fancy'></i></span>"."<span style='font-size: 20px;'>商品名稱：";
                        echo $row['artwork_name'];
                        echo "</span>";
                        echo "<br/>";
                        echo "<span><i class='fa-solid fa-hand-holding-dollar'></i></span>"."<span style='font-size: 20px;'>單價：NT$";
                        echo $row['artwork_price'];
                        echo "</span>";
                        echo "<br/>";
                        
                        if(isset($_SESSION['username'])){   //有登入的使用者
                            //需要傳值: artwork_ID、order_ID
                            echo "<br/>";
                            echo "<form action = 'order_procession.php' method = 'post'>";  //傳值給order_procession
                            echo "<div = 'button' style='margin-top: 20px; border-radius: 25px; color=black'>";
    
                            if($row['artwork_stock']!=0){
                                echo "購買數量：";
                                echo "<input name = 'quantity' type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                            }else{
                                echo "<span style='color: red;'>商品已售完</span>";
                            }
                            //echo "<input type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                            echo "</div>";
                            echo "<div class=detail>";
                                echo "<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."&order_ID='$order_ID''>";
                                echo "<button style='margin-top: 20px; border-radius: 25px; color:black'>";
                                echo "詳細資訊";
                                echo "</button>";
                                echo "</a>";
                            echo "</div>";
                            if($row['artwork_stock']!=0){
                                echo "<div class=add>";
                                    echo "<input name = 'cart' type= 'submit' value='加入購物車' style='margin-top: 20px; border-radius: 5px; color=black'>";
                                echo "</div>";
                            }
                            echo "<input name = 'artwork_ID' type='hidden' value='".$row["artwork_ID"]."'>";
                            echo "<input name = 'order_ID' type = 'hidden' value='$order_ID'>";
                            echo "</form>";
                        }else{
                            echo "<br/>";
    
                            if($row['artwork_stock']!=0){
                                echo "購買數量：";
                                echo "<input type='number' name = 'quantity' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                            }else{
                                echo "<span style='color: red;'>商品已售完</span>";
                            }
                            echo "<div class=detail>";
                                echo "<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."&order_ID='$order_ID''>";
                                echo "<button style='margin-top: 20px; border-radius: 25px; color:black'>";
                                echo "詳細資訊";
                                echo "</button>";
                                echo "</a>";
                            echo "</div>";
                            if($row['artwork_stock']!=0){
                                echo "<div class=add>";
                                echo "<a href = login.php>";
                                echo "<button style='margin-top: 20px; border-radius: 5px; color=black'>";
                                echo "加入購物車";
                                echo "</a>";
                                echo "</style>";
                                echo "</div>";
                            }                        
                        }
                        
                        echo "</ul>";
                    }
                }
            echo "</div>";
        echo "</p>";


        echo "<p id='section0'>所有商品";
        echo "<HR width=100% color='#dddddd'>";
            echo "<div class=scroll-container>";
                $AW_infor="SELECT * FROM artwork";
                $artworkinformation=mysqli_query($link,$AW_infor);
                while( $row = mysqli_fetch_assoc($artworkinformation) ){
                    if($row ['artwork_price']!=null){
                        echo "<ul>";
                        echo "<a href= 'product.php?artwork_ID=".$row['artwork_ID']."&order_ID=".$order_ID."'><img src='".$row['artwork_file']."' ></IMG></a>";
                        echo "<br/>";
                        echo "<br/><span><i class='fa-solid fa-pen-fancy'></i></span>"."<span style='font-size: 20px;'>商品名稱：";
                        echo $row['artwork_name'];
                        echo "</span>";
                        echo "<br/>";
                        echo "<span><i class='fa-solid fa-hand-holding-dollar'></i></span>"."<span style='font-size: 20px;'>單價：NT$";
                        echo $row['artwork_price'];
                        echo "</span>";
                        echo "<br/>";
                        
                        if(isset($_SESSION['username'])){   //有登入的使用者
                            //需要傳值: artwork_ID、order_ID
                            echo "<br/>";
                            echo "<form action = 'order_procession.php' method = 'post'>";  //傳值給order_procession
                            echo "<div = 'button' style='margin-top: 20px; border-radius: 25px; color=black'>";
    
                            if($row['artwork_stock']!=0){
                                echo "購買數量：";
                                echo "<input name = 'quantity' type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                            }else{
                                echo "<span style='color: red;'>商品已售完</span>";
                            }
                            //echo "<input type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                            echo "</div>";
                            echo "<div class=detail>";
                                echo "<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."&order_ID='$order_ID''>";
                                echo "<button style='margin-top: 20px; border-radius: 25px; color:black'>";
                                echo "詳細資訊";
                                echo "</button>";
                                echo "</a>";
                            echo "</div>";
                            if($row['artwork_stock']!=0){
                                echo "<div class=add>";
                                    echo "<input name = 'cart' type= 'submit' value='加入購物車' style='margin-top: 20px; border-radius: 5px; color=black'>";
                                echo "</div>";
                            }
                            echo "<input name = 'artwork_ID' type='hidden' value='".$row["artwork_ID"]."'>";
                            echo "<input name = 'order_ID' type = 'hidden' value='$order_ID'>";
                            echo "</form>";
                        }else{
                            echo "<br/>";
    
                            if($row['artwork_stock']!=0){
                                echo "購買數量：";
                                echo "<input type='number' name = 'quantity' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                            }else{
                                echo "<span style='color: red;'>商品已售完</span>";
                            }
                            echo "<div class=detail>";
                                echo "<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."&order_ID='$order_ID''>";
                                echo "<button style='margin-top: 20px; border-radius: 25px; color:black'>";
                                echo "詳細資訊";
                                echo "</button>";
                                echo "</a>";
                            echo "</div>";
                            if($row['artwork_stock']!=0){
                                echo "<div class=add>";
                                echo "<a href = login.php>";
                                echo "<button style='margin-top: 20px; border-radius: 5px; color=black'>";
                                echo "加入購物車";
                                echo "</a>";
                                echo "</style>";
                                echo "</div>";
                            }                        
                        }
                        
                        echo "</ul>";
                    }
                }
            echo "</div>";
        echo "</p>";

        for($i=0;$i<count($artwork_class);$i++){
            echo '<p id="' . $artwork_class[$i] . '">' . $artwork_class[$i] . '</p>';
            echo "<HR width=100% color='#dddddd'>";
            echo "<div class='scroll-container'>";
            $AW_wancreat = "SELECT * FROM artwork WHERE artwork_class='" . $artwork_class[$i] . "'";    //artwork_class(藝術家創作、周邊商品、不可以瑟瑟)
            $AW_wanwancreat=mysqli_query($link,$AW_wancreat);
                while( $row = mysqli_fetch_assoc($AW_wanwancreat) ){
                    echo "<ul>";
                    echo "<a href= 'product.php?artwork_ID=".$row['artwork_ID']."&order_ID=".$order_ID."'><img src='".$row['artwork_file']."' ></IMG></a>";
                    echo "<br/>";
                    echo "<br/><span><i class='fa-solid fa-pen-fancy'></i></span>"."<span style='font-size: 20px;'>商品名稱：";
                    echo $row['artwork_name'];
                    echo "</span>";
                    echo "<br/>";
                    echo "<span><i class='fa-solid fa-hand-holding-dollar'></i></span>"."<span style='font-size: 20px;'>單價：NT$";
                    echo $row['artwork_price'];
                    echo "</span>";
                    echo "<br/>";
                    
                    if(isset($_SESSION['username'])){   //有登入的使用者
                        //需要傳值: artwork_ID、order_ID
                        echo "<br/>";
                        echo "<form action = 'order_procession.php' method = 'post'>";  //傳值給order_procession
                        echo "<div = 'button' style='margin-top: 20px; border-radius: 25px; color=black'>";

                        if($row['artwork_stock']!=0){
                            echo "購買數量：";
                            echo "<input name = 'quantity' type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        }else{
                            echo "<span style='color: red;'>商品已售完</span>";
                        }
                        //echo "<input type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        echo "</div>";
                        echo "<div class=detail>";
                            echo "<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."&order_ID='$order_ID''>";
                            echo "<button style='margin-top: 20px; border-radius: 25px; color:black'>";
                            echo "詳細資訊";
                            echo "</button>";
                            echo "</a>";
                        echo "</div>";
                        if($row['artwork_stock']!=0){
                            echo "<div class=add>";
                                echo "<input name = 'cart' type= 'submit' value='加入購物車' style='margin-top: 20px; border-radius: 5px; color=black'>";
                            echo "</div>";
                        }
                        echo "<input name = 'artwork_ID' type='hidden' value='".$row["artwork_ID"]."'>";
                        echo "<input name = 'order_ID' type = 'hidden' value='$order_ID'>";
                        echo "</form>";
                    }else{
                        echo "<br/>";

                        if($row['artwork_stock']!=0){
                            echo "購買數量：";
                            echo "<input type='number' name = 'quantity' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        }else{
                            echo "<span style='color: red;'>商品已售完</span>";
                        }
                        echo "<div class=detail>";
                            echo "<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."&order_ID='$order_ID''>";
                            echo "<button style='margin-top: 20px; border-radius: 25px; color:black'>";
                            echo "詳細資訊";
                            echo "</button>";
                            echo "</a>";
                        echo "</div>";
                        if($row['artwork_stock']!=0){
                            echo "<div class=add>";
                            echo "<a href = login.php>";
                            echo "<button style='margin-top: 20px; border-radius: 5px; color=black'>";
                            echo "加入購物車";
                            echo "</a>";
                            echo "</style>";
                            echo "</div>";
                        }                        
                    }

                    echo "</ul>";
                }
                echo "</div>";
            for($n=0;$n<count($artwork_data[$artwork_class[$i]]);$n++){
                echo "<p id='" . $artwork_data[$artwork_class[$i]][$n] . "'>". $artwork_data[$artwork_class[$i]][$n] ."</p>";   //artwork_type(萬哥創作、萬哥公仔、萬哥明信片、萬哥鑰匙圈、...)
                echo "<HR width=100% color='#dddddd'>";
                echo "<div class='scroll-container'>";
                $AW_wancreat = "SELECT * FROM artwork WHERE artwork_class = '" . $artwork_class[$i] . "' AND artwork_type = '" . $artwork_data[$artwork_class[$i]][$n] . "'";
                $AW_wanwancreat=mysqli_query($link,$AW_wancreat);
                while( $row = mysqli_fetch_assoc($AW_wanwancreat) ){
                    echo "<ul>";
                    echo "<a href= 'product.php?artwork_ID=".$row['artwork_ID']."&order_ID=".$order_ID."'><img src='".$row['artwork_file']."' ></IMG></a>";
                    echo "<br/>";
                    echo "<br/><span><i class='fa-solid fa-pen-fancy'></i></span>"."<span style='font-size: 20px;'>商品名稱：";
                    echo $row['artwork_name'];
                    echo "</span>";
                    echo "<br/>";
                    echo "<span><i class='fa-solid fa-hand-holding-dollar'></i></span>"."<span style='font-size: 20px;'>單價：NT$";
                    echo $row['artwork_price'];
                    echo "</span>";
                    echo "<br/>";
                    
                    if(isset($_SESSION['username'])){   //有登入的使用者
                        //需要傳值: artwork_ID、order_ID
                        echo "<br/>";
                        echo "<form action = 'order_procession.php' method = 'post'>";  //傳值給order_procession
                        echo "<div = 'button' style='margin-top: 20px; border-radius: 25px; color=black'>";

                        if($row['artwork_stock']!=0){
                            echo "購買數量：";
                            echo "<input name = 'quantity' type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        }else{
                            echo "<span style='color: red;'>商品已售完</span>";
                        }
                        //echo "<input type='number' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        echo "</div>";
                        echo "<div class=detail>";
                            echo "<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."&order_ID='$order_ID''>";
                            echo "<button style='margin-top: 20px; border-radius: 25px; color:black'>";
                            echo "詳細資訊";
                            echo "</button>";
                            echo "</a>";
                        echo "</div>";
                        if($row['artwork_stock']!=0){
                            echo "<div class=add>";
                                echo "<input name = 'cart' type= 'submit' value='加入購物車' style='margin-top: 20px; border-radius: 5px; color=black'>";
                            echo "</div>";
                        }
                        echo "<input name = 'artwork_ID' type='hidden' value='".$row["artwork_ID"]."'>";
                        echo "<input name = 'order_ID' type = 'hidden' value='$order_ID'>";
                        echo "</form>";
                    }else{
                        echo "<br/>";

                        if($row['artwork_stock']!=0){
                            echo "購買數量：";
                            echo "<input type='number' name = 'quantity' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='1'>";
                        }else{
                            echo "<span style='color: red;'>商品已售完</span>";
                        }
                        echo "<div class=detail>";
                            echo "<a href= 'product.php?artwork_ID=".$row["artwork_ID"]."&order_ID='$order_ID''>";
                            echo "<button style='margin-top: 20px; border-radius: 25px; color:black'>";
                            echo "詳細資訊";
                            echo "</button>";
                            echo "</a>";
                        echo "</div>";
                        if($row['artwork_stock']!=0){
                            echo "<div class=add>";
                            echo "<a href = login.php>";
                            echo "<button style='margin-top: 20px; border-radius: 5px; color=black'>";
                            echo "加入購物車";
                            echo "</a>";
                            echo "</style>";
                            echo "</div>";
                        }                        
                    }

                    echo "</ul>";
                }
                echo "</div>";
            }
        }   
        echo "<br/>";
        ?> 
    </section>
    
    <a href="artwork.php" class="back-to-top">
    <i class="fa-regular fa-circle-up" style="color: #7e4730;"></i>
    </a>
    <div class="back">
    <center>
        <a href="index.php"><button>返回藝廊首頁</button></a>
    </center>
</div>
           
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var backToTopButton = document.querySelector(".back-to-top");
  
    window.addEventListener("scroll", function() {
      if (window.pageYOffset > 200) {
        backToTopButton.classList.add("show");
      } else {
        backToTopButton.classList.remove("show");
      }
    });
  
    backToTopButton.addEventListener("click", function(e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });
</script>

    </body>
</html>
