<script type="text/javascript">
function goBack(){
    window.history.go(-2);
}

function click(){
    let div=document.getElementById("div");
    div.click();
}
</script>
<meta charset="uft-8">
<?php

$artwork_ID=$_GET['artwork_ID'];
$link=@mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");

$artwork_SQL="DELETE FROM artwork WHERE artwork_ID=$artwork_ID";
$collection_detail_SQL="DELETE FROM collection_detail WHERE artwork_ID=$artwork_ID ";
if($collection_detail_result=mysqli_query($link,$collection_detail_SQL) && $artwork_result=mysqli_query($link,$artwork_SQL)){
    echo "<input type='hidden' value='返回' onclick='goBack()' id='div'>";
    echo "<script type='text/javascript'>click();</script>";
}
?>
