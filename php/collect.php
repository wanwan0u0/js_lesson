<script type="text/javascript">
function goBack(){
    window.history.back();
}

function click(){
    let div=document.getElementById("div");
    div.click();
}
</script>
<?php
$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");
$artwork_ID=$_GET['artwork_ID'];
$viewer_user_ID=$_GET['viewer_user_ID'];
$SQL="INSERT INTO collection_detail(user_ID, artwork_ID) VALUES('$viewer_user_ID','$artwork_ID')";

if($result=mysqli_query($link,$SQL)){
    echo "<input type='hidden' value='返回' onclick='goBack()' id='div'>";
    echo "<script type='text/javascript'>click();</script>";
}
?>
