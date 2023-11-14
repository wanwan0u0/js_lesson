<script type="text/javascript">
function goBack(){
    window.history.back();
}

function click(){
    let div=document.getElementById("div");
    div.click();
}
</script>
<meta charset="uft-8">
<?php

$viewer_user_ID=$_GET['viewer_user_ID'];
$artwork_ID=$_GET['artwork_ID'];
$link=@mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");

$SQL="DELETE FROM collection_detail WHERE artwork_ID=$artwork_ID AND user_ID=$viewer_user_ID";

if($result=mysqli_query($link,$SQL)){
    echo "<input type='hidden' value='返回' onclick='goBack()' id='div'>";
    echo "<script type='text/javascript'>click();</script>";
}
?>
