<script>
function click(id){
    let div=document.getElementById(id);
    div.click();
}
</script>

<link rel="stylesheet" href="history.css?v=<?=time()?>"> 
<?php
session_start();
$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");

if(isset($_SESSION['viewer_user_ID'])){
    $user_ID=$_SESSION['viewer_user_ID'];
    $SQL="SELECT* FROM uuser WHERE user_ID='$user_ID'"; 
    if(@$result=mysqli_query($link, $SQL)){
        $row=mysqli_fetch_assoc($result);
        $_SESSION['viewer_role']=$row['user_role'];
    }
}
else{
    $user_ID=0;
    $_SESSION['viewer_role']='guest';
}
?>
<body style="background-color: white;">
    <header style="background: black;">
<?php
echo "<text>";
echo "<a href='index.php' >首頁</a>";
echo "</text>";
echo "<text>";
echo "<a href='artwork.php' >藝術商品頁面</a>";
echo "</text>";
if($user_ID==0){
    echo "<text>";
    echo "<a href='purchase_history.php' >購買紀錄</a>";
    echo "</text>";
    echo "<text>";
    echo "<a href='login.php' >我的主頁</a>";
    echo "</text>";
}
else{
    echo "<text>";
    echo "<a href='purchase_history.php' >購買紀錄</a>";
    echo "</text>";
    echo "<text>";
    echo "<a href='artist.php' >我的主頁</a>";
    echo "</text>";
    $SQL="SELECT* FROM uuser WHERE user_ID='$user_ID'";
    if(@$result=mysqli_query($link, $SQL)){
        $row=mysqli_fetch_assoc($result);
        echo "<div class=profile>";
        echo "<div class=c>";
        echo "<text>";
        echo "<a href='logout.php' ><font color='white'>登出</font></a>";
        echo "</text>";
        echo "<IMG SRC='".$row['user_icon']."' class=round_icon2></IMG>";
        echo "</div>";
        echo "</div>";
    }
    echo "</br>";
}
?>
    </header>

<?php
if(isset($_GET['type'])){
    $type=$_GET['type'];
}

mysqli_set_charset($link,"utf8");
$SQL="SELECT * FROM oorder O JOIN order_artwork_detail OAD ON OAD.order_ID=O.order_ID JOIN artwork A ON OAD.artwork_ID=A.artwork_ID WHERE O.user_ID=$user_ID AND OAD.order_ID in (SELECT order_ID from oorder where user_ID=$user_ID AND order_total_price!=0) order by OAD.order_ID";
$result=mysqli_query($link,$SQL);
$total=0;
$count=0;
if(!isset($_GET['type'])){
echo "<div class=whole>";
echo "<div class='left'>";
echo "<a href='purchase_history.php?type=product' style='text-decoration:none;' id='product'><b><font size='5' >商品購買紀錄</font></B></a>";
echo "<HR width=50% color='#dddddd'>";
echo "</div>";
echo "<div class='right'>";
echo "<a href='purchase_history.php?type=ticket' style='text-decoration:none;'><b><font size='5' >票券購買紀錄</font></B></a>";
echo "<HR width=100% color='#dddddd'>";
echo "</div>";
echo "</div>";
echo "<script>click('product');</script>";
}
if(@$type=='product'){
    echo "<div class=whole>";
    echo "<div class='left'>";
    echo "<a href='purchase_history.php?type=product' style='text-decoration:none;' id='product'><b><font size='5' >商品購買紀錄</font></B></a>";
    echo "<HR width=45% color='#dddddd'>";
    echo "</div>";
    echo "<div class='right'>";
    echo "<a href='purchase_history.php?type=ticket' style='text-decoration:none;'><b><font size='5' >票券購買紀錄</font></B></a>";
    echo "</div>";
    echo "</div>";
    while($row=mysqli_fetch_assoc($result)){
        if($count==0){
            $o_order_ID=$row['order_ID'];
            $total+=$row['OAD_Amount'];
        }
        else{
            $new_order_ID=$row['order_ID'];
            if($new_order_ID==$o_order_ID){
                $total+=$row['OAD_Amount'];
            }
            else{
                $o_order_ID=$new_order_ID;
                echo "<div class=total-block>";
                echo "<div class=total>";
                echo "總計:<span id='Total' >".$total."元</span></br>";;
                echo "</div>";
                echo "</div>";
                echo "</br>";
                $total=0;
                $total+=$row['OAD_Amount'];
            }
        }
        echo "<div class=cart>";
        echo "<IMG SRC='".$row['artwork_file']."'></IMG>";
        echo "<text>";
        echo "<font size=6>商品名稱:".$row['artwork_name']."</font></br>";
        echo "數量:".$row['OAD_Quantity']."</br>";
        echo "小計:".$row['OAD_Amount']."</br>";
        echo "</text>";
        echo "</div>";
        $count++;
    }
echo "<div class=total-block>";
echo "<div class=total>";
echo "總計:<span id='Total' >".$total."元</span></br>";;
echo "</div>";
echo"<div class='back'>";
    echo"<center>";
        echo"<a href='index.php'><button>返回商品首頁</button></a>";
    echo"</center>";
echo"</div>";
echo "</div>";
}
if(@$type=='ticket'){
    echo "<div class=whole>";
    echo "<div class='left'>";
    echo "<a href='purchase_history.php?type=product' style='text-decoration:none;' id='product'><b><font size='5' >商品購買紀錄</font></B></a>";
    echo "</div>";
    echo "<div class='right'>";
    echo "<a href='purchase_history.php?type=ticket' style='text-decoration:none;'><b><font size='5' >票券購買紀錄</font></B></a>";
    echo "<HR width=100% color='#dddddd'>";
    echo "</div>";
    echo "</div>";
    $SQL="SELECT * FROM oorder O JOIN order_ticket_detail OTD ON OTD.order_ID=O.order_ID JOIN ticket T ON OTD.ticket_ID=T.ticket_ID JOIN exhibition E ON E.exhibition_ID=T.exhibition_ID JOIN (SELECT * FROM artwork A where exhibition_ID in (SELECT exhibition_ID FROM exhibition) limit 1) A ON A.exhibition_ID=E.exhibition_ID WHERE O.user_ID=$user_ID AND OTD.order_ID in (SELECT order_ID from oorder where user_ID=$user_ID AND order_total_price!=0) order by OTD.order_ID";
    $result=mysqli_query($link,$SQL);
    $total=0;
    $count=0;
    while($row=mysqli_fetch_assoc($result)){
        if($count==0){
            $o_order_ID=$row['order_ID'];
            $total+=$row['OTD_Amount'];
        }
        else{
            $new_order_ID=$row['order_ID'];
            if($new_order_ID==$o_order_ID){
                $total+=$row['OTD_Amount'];
            }
            else{
                $o_order_ID=$new_order_ID;
                echo "<div class=total-block>";
                echo "<div class=total>";
                echo "總計:<span id='Total' >".$total."元</span></br>";;
                echo "</div>";
                echo "</div>";
                echo "</br>";
                $total=0;
                $total+=$row['OTD_Amount'];
            }
        }
    
        echo "<div class=cart>";
        echo "<IMG SRC='".$row['artwork_file']."'></IMG>";
        echo "<text>";
        echo "<font size=6>展覽名稱:".$row['exhibition_name']."</font></br>";
        echo "數量:".$row['OTD_Quantity']."</br>";
        echo "小計:".$row['OTD_Amount']."</br>";
        echo "</text>";
        echo "</div>";
        $count++;
    }
echo "<div class=total-block>";
echo "<div class=total>";
echo "總計:<span id='Total' >".$total."元</span></br>";;
echo "</div>";
echo"<div class='back'>";
    echo"<center>";
        echo"<a href='index.php'><button>返回商品首頁</button></a>";
    echo"</center>";
echo"</div>";
echo "</div>";
}
?>

