<script type="text/javascript">
function goBack(){
    window.history.go(-1);
}

function click(){
    let div=document.getElementById("div");
    div.click();
}
</script>

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

<link rel="stylesheet" href="edit_artwork(2).css?v=<?=time()?>"> 
<?php
$artwork_ID=$_GET['artwork_ID'];
$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");

$SQL="SELECT * FROM artwork WHERE artwork_ID='$artwork_ID'";
if($result=mysqli_query($link,$SQL)){
    $row=mysqli_fetch_assoc($result);
    $artwork_name=$row['artwork_name'];
    $artwork_file=$row['artwork_file'];
    $artwork_information=$row['artwork_information'];
}

echo "<h1>Edit artwork</h1>";
echo "<form action='edit_artwork_check.php' method='post'";
echo "art name:</br>";
echo "<div class=block>";
echo "<IMG SRC='".$artwork_file."'></IMG>";
echo "<div class=test>";
echo "<div class=text_content>";
echo "<h2>Name</h2>";
echo "<input type='text' name='artwork_name' value='".$artwork_name."'></br>";
echo "<h2>About</h2>";
echo "<div class=text_block>";
echo "<textarea name='descript' cols='58' rows='18' >";
echo $artwork_information;
echo "</textarea></br>";
echo "</div>";
echo "<input type='hidden' name='artwork_ID' value='".$artwork_ID."'>";
echo "<div class=delete>";
echo "<a href='delete_artwork(2).php?artwork_ID=".$artwork_ID."'><b><font size='3.5' color='red''>刪除作品</font></B></a>";
echo "</div>";
echo "<input type='submit'>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "<input type='hidden' value='返回' onclick='goBack()' id='div'>";
?>
