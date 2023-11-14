<script>
function click(id){
    let div=document.getElementById(id);
    div.click();
}
</script>

<?php
session_start();
$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");

if(isset($_GET['type'])){
    $type=$_GET['type'];
}

//$_SESSION['viewer_user_ID']=1; //這裡調整觀看者ID
if(isset($_SESSION['viewer_user_ID'])){
    $viewer_user_ID=$_SESSION['viewer_user_ID'];
    $SQL="SELECT* FROM uuser WHERE user_ID='$viewer_user_ID'"; //確認瀏覽者ID session確認
    if(@$result=mysqli_query($link, $SQL)){
        $row=mysqli_fetch_assoc($result);
        $_SESSION['viewer_role']=$row['user_role'];//確認觀看者身分
    }
    if($_SESSION['viewer_role']=='admin'){
        header("location:admin.php");
    }
}
else{
    $viewer_user_ID=0;
    $_SESSION['viewer_role']='guest';
}

if(isset($_GET['owner_user_ID'])){
    $owner_user_ID=$_GET['owner_user_ID'];
}
else{
    if($viewer_user_ID==0){
        $owner_user_ID=$viewer_user_ID;
        if($owner_user_ID==0){
            header("location:login.php");
        }
    }
    else{
        $owner_user_ID=$viewer_user_ID;
    }
}
//$_SESSION['role']='collector';
$SQL="SELECT* FROM uuser WHERE user_ID='$owner_user_ID'"; //該主頁擁有者ID 點擊連接時傳值 這裡調整該網頁用戶ID
if(@$result=mysqli_query($link, $SQL)){
    $row=mysqli_fetch_assoc($result);
    $own_user_ID=$row['user_ID'];
    $_SESSION['owner_role'] =$row['user_role'];//確認網頁用戶身分
}

?>

<html>
<head>
<link rel="stylesheet" href="artist_style.css?v=<?=time()?>">
<meta charset="utf-8">

<title>藝術家頁面</title>    
</head>
<body style="background-color: white;">
    <header style="background: black;">
<?php
echo "<text>";
echo "<a href='index.php' >首頁</a>";
echo "</text>";
echo "<text>";
echo "<a href='artwork.php' >藝術商品頁面</a>";
echo "</text>";
if($viewer_user_ID==0){
    echo "<text>";
    echo "<a href='purchase_history.php' >購買紀錄</a>";
    echo "</text>";
    echo "<text>";
    echo "<a href='artist.php' >我的主頁</a>";
    echo "</text>";
}
else{
    echo "<text>";
    echo "<a href='purchase_history.php' >購買紀錄</a>";
    echo "</text>";
    echo "<text>";
    echo "<a href='artist.php' >我的主頁</a>";
    echo "</text>";
    $SQL="SELECT* FROM uuser WHERE user_ID='$viewer_user_ID'";
    if(@$result=mysqli_query($link, $SQL)){
        $row=mysqli_fetch_assoc($result);
        echo "<div class=profile>";
        echo "<div class=c>";
        echo "<text>";
        echo "<a href='logout.php' ><font color='white'>登出</font></a>";
        echo "</text>";
        echo "<a href='artist.php'><IMG SRC='".$row['user_icon']."' class=round_icon2></IMG></a>";
        echo "</div>";
        echo "</div>";
    }
    echo "</br>";
}
?>
    </header>
<div class=block>
    <img src="long.png" alt="Artist Photo">
</div>
<section id="user-profile">
  <div class="left-section">
    <?php
    $SQL="SELECT* FROM uuser WHERE user_ID='$own_user_ID'";
    if(@$result=mysqli_query($link, $SQL)){
        $row=mysqli_fetch_assoc($result);
        echo "<div class=c>";
        echo "<IMG SRC='".$row['user_icon']."' class=round_icon></IMG>";
        echo "</div>";
    if(@$result=mysqli_query($link, $SQL)){
        while($row=mysqli_fetch_assoc($result)){
        $Username=$row['user_name'];
        echo "<B><font size='6'>".$Username."</font></B></br></br>";
        }
    }
    }

    ?>
    </div>
<div class="right-section">
    <div class="bio">
    <?php
        $SQL="SELECT* FROM uuser WHERE user_ID='$own_user_ID'";
        if(@$result=mysqli_query($link, $SQL)){
            while($row=mysqli_fetch_assoc($result)){
            $bio=$row['user_introduce_html'];
            echo "<font size='3'>".$bio."</font></br></br>";
            }
        }
        ?>
    </div>
    <div class="edit">
        <?php
        $SQL="SELECT* FROM uuser WHERE user_ID='$own_user_ID'";
        if($viewer_user_ID==$own_user_ID){
            echo '<a href="edit.php?user_ID='.$viewer_user_ID.'" class="button1">Edit profile</a><br/>';
        }
        ?>
    </div>
 </div>
</section>
<section id="artcollect">
<?php
if(!isset($_GET['type'])){
    if(@$_SESSION['owner_role'] == 'artist'){
        echo "<div class='whole'>";
        echo "<div class='left'>";
        echo "<a href='artist.php?type=artwork&owner_user_ID=$owner_user_ID' style='text-decoration:none;' id='artwork'><b><font size='5' >作品</font></B></a>";
        echo "<HR width=100% color='#dddddd'>";
        echo "<script>click('artwork');</script>";
        echo "</div>";
        
        if($viewer_user_ID==$own_user_ID){
            echo "<div class='right'>";
            echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >我的收藏</font></B></a>";
            echo "<HR width=100% color='#dddddd'>";
            echo "</div>";
            echo "</div>";
        }
        else{
            echo "<div class='right'>";
            echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >收藏</font></B></a>";
            echo "<HR width=100% color='#dddddd'>";
            echo "</div>";
            echo "</div>";
        }
    }
    else{
        echo "<div class='whole'>";
        echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;' id='collection'><b><font size='5' onclick='collection()' >收藏</font></B></a>";
        echo "<HR width=100% color='#dddddd'>";
        echo "<script>click('collection');</script>";
        echo "</div>";
    }
}
if (@$type == 'artwork') {
    if(@$_SESSION['owner_role'] == 'artist'){
        echo "<div class='whole'>";
        echo "<div class='left'>";
        echo "<a href='artist.php?type=artwork&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' >作品</font></B></a>";
        echo "<HR width=100% color='#dddddd'>";
        echo "</div>";
        if($viewer_user_ID==$own_user_ID){
            echo "<div class='right'>";
            echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >我的收藏</font></B></a>";
            echo "</div>";
            echo "</div>";
        }
        else{
            echo "<div class='right'>";
            echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >收藏</font></B></a>";
            echo "</div>";
            echo "</div>";
        }
    }
    else{
        echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >收藏</font></B></a>";
        echo "<HR width=100% color='#dddddd'>";
    }
    echo "<b><font size='6'>作品</font></B>";
    $SQL = "SELECT * FROM uuser u JOIN artwork a ON u.user_ID=a.user_ID WHERE a.user_ID='$own_user_ID'";
    if (@$result = mysqli_query($link, $SQL)) {
        $count = 0; // 計數變數
        echo "<div class='content'>";
        echo "<div class='row'  style='width: 1500px;'>"; // 開始新的 row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-sm-3' style='display: inline-block;'>"; // 將 col-sm 改為 col-sm-4
            echo "<div class='c'>";
            echo "<div class='artwork-box'>"; // 加入作品框的容器
            echo "<a href='artwork_detail.php?artwork_ID=" . $row['artwork_ID'] . "' class='modal_button'><img src='" . $row['artwork_file'] . "'></a>";
            echo"<br/>";
            echo "<font>" . $row['artwork_name'] . "</font>";
            echo "</div>";
            echo "</div>";
            if (@$viewer_user_ID != $own_user_ID) {
                if($viewer_user_ID==0){
                    echo "<a href='login.php'><button type='button'>收藏</button></a>";
                }
                else{
                    $checkSQL = "SELECT * FROM collection_detail WHERE artwork_ID=" . $row['artwork_ID'] . " AND user_ID='$viewer_user_ID'";
                    $checkresult = mysqli_query($link, $checkSQL);
                    $checkrow = mysqli_fetch_assoc($checkresult);
                    if (@$checkrow['artwork_ID'] == null && @$checkrow['user_ID'] == null) {
                        echo"<br/>";
                        echo "<a href='collect.php?artwork_ID=" . $row['artwork_ID'] . "&viewer_user_ID=" . $viewer_user_ID . "'><button type='button'>收藏</button></a>";
                    } else if (@$checkrow['artwork_ID'] != null && @$checkrow['user_ID'] != null) {
                        echo"<br/>";
                        echo "<a href='delete_collection.php?artwork_ID=" . $row['artwork_ID'] . "&viewer_user_ID=" . $viewer_user_ID . "'><button type='button'>取消收藏</button></a>";
                    }
                }
            } else if (@$viewer_user_ID == $own_user_ID) {
                echo"<br/>";
                echo "<a href='edit_artwork(2).php?artwork_ID=" . $row['artwork_ID'] . "'><button type='button'>修改</button></a>";
            }
            echo "</div>";
            $count++; // 增加計數
            if ($count % 4 === 0) {
                echo "</div><div class='row'>"; // 插入新的 row
            }
        }
        echo "</div>"; // 結束最後一個 row
        echo "</div>";
    }
    if (@$_SESSION['viewer_role'] == 'artist' && $viewer_user_ID == $own_user_ID) {
        echo "<p style=margin:5%;>";
        echo "<button><a href='upload.php?user_ID=" . $viewer_user_ID . "'><b><font size='5' style='color: rgb(247,247,237);'>upload</font></B></a></button>";
        echo "</p>";
    }
}

else if (@$type == 'collection') {
    if(@$_SESSION['owner_role'] == 'artist'){
        echo "<div class='whole'>";
        echo "<div class='left'>";
        echo "<a href='artist.php?type=artwork&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' >作品</font></B></a>";
        echo "</div>";
        echo "<div class='right'>";
        if($viewer_user_ID==$own_user_ID){
            echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >我的收藏</font></B></a>";
            echo "<HR width=100% color='#dddddd'>";
            echo "</div>";
            echo "</div>";
        }
        else{
            echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >收藏</font></B></a>";
            echo "<HR width=100% color='#dddddd'>";
            echo "</div>";
            echo "</div>";
        }
    }
    else{
        if($viewer_user_ID==$own_user_ID){
            echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >我的收藏</font></B></a>";
            echo "<HR width=100% color='#dddddd'>";
        }
        else{
            echo "<a href='artist.php?type=collection&owner_user_ID=$owner_user_ID' style='text-decoration:none;'><b><font size='5' onclick='collection()' >收藏</font></B></a>";
            echo "<HR width=100% color='#dddddd'>";            
        }
    }
    echo "<b><font size='6' >收藏</font></B>";
    $SQL = "SELECT* FROM uuser u JOIN collection_detail c ON u.user_ID=c.user_ID JOIN artwork a ON a.artwork_ID=c.artwork_ID WHERE c.user_ID='$own_user_ID'";
    if (@$result = mysqli_query($link, $SQL)) {
        $count = 0; // 計數器
        echo "<div class='content'>";
        echo "<div class='row' style='width: 1500px;'>"; // 開始新的一行
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-sm-3' style='display: inline-block;'>"; // 每個元素的容器
            echo "<div class='artwork-container'>";
            echo "<div class='c'>";
            echo "<a href='artwork_detail.php?artwork_ID=" . $row['artwork_ID'] . "' class='modal button'><img src='" . $row['artwork_file'] . "'></a>";
            echo "</div>";

            $ownerSQL = "SELECT* FROM artwork a JOIN uuser u ON a.user_ID=u.user_ID  WHERE artwork_ID=" . $row['artwork_ID'] . "";
            $ownerresult = mysqli_query($link, $ownerSQL);
            $ownerrow = mysqli_fetch_assoc($ownerresult);

            echo "<div class='c1'>";
            echo "<a href='artist.php?owner_user_ID=" . $ownerrow['user_ID'] . "'><img src='" . $ownerrow['user_icon'] . "' class='round_icon2'></a>";
            echo "</div>";
            echo "<div class='word'>";
            echo "<font >" . $row['artwork_name'] . "</font>";
            echo "</div>";
            
            $checkSQL = "SELECT* FROM collection_detail WHERE artwork_ID=" . $row['artwork_ID'] . " AND user_ID='$viewer_user_ID'";
            $checkresult = mysqli_query($link, $checkSQL);
            $checkrow = mysqli_fetch_assoc($checkresult);

            $ifownSQL = "SELECT* FROM artwork WHERE artwork_ID=" . $row['artwork_ID'] . " AND user_id='$viewer_user_ID'";
            $ifownresult = mysqli_query($link, $ifownSQL);
            $ifownrow = mysqli_fetch_assoc($ifownresult);
            if($viewer_user_ID==0){
                echo "<a href='login.php'><button type='button'>收藏</button></a>";
            }
            else{
                if (@$ifownrow['artwork_ID'] != null && @$ifownrow['user_id'] != null) {
                    

                } else if (@$checkrow['artwork_ID'] == null && @$checkrow['user_ID'] == null) {
                    
                    echo "<a href='collect.php?artwork_ID=" . $row['artwork_ID'] . "&viewer_user_ID=" . $viewer_user_ID . "'><button type='button' onclick=collect();>收藏</button></a>";
                } else if (@$checkrow['artwork_ID'] != null && @$checkrow['user_ID'] != null) {
                    
                    echo "<a href='delete_collection.php?artwork_ID=" . $row['artwork_ID'] . "&viewer_user_ID=" . $viewer_user_ID . "'><button type='button'>取消收藏</button></a>";
                }
            }

            echo "</div>";
            
            $count++; // 計數器遞增

            if ($count % 4 === 0) {
                echo "</div><div class='row' style='width: 1500px;'>"; // 插入新的一行
            }
            echo "</div>";
        }
        echo "</div>"; // 結束最後一行
        
    }
    
    
}


?>
</section>
</body>
</html>
