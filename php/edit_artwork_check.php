<script type="text/javascript">
function goBack(){
    window.history.go(-2);
}

function click(){
    let div=document.getElementById("div");
    div.click();
}
</script>
<?php
$artwork_ID=$_POST['artwork_ID'];
$artwork_name=$_POST['artwork_name'];
$descript=$_POST['descript'];

$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");

$SQL="UPDATE artwork SET artwork_name='$artwork_name' ,artwork_information='$descript', artwork_information_html='".nl2br(strip_tags($descript))."' WHERE artwork_ID='$artwork_ID'";
if($result=mysqli_query($link,$SQL)){
    echo "<input type='hidden' value='返回' onclick='goBack()' id='div'>";
    echo "<script type='text/javascript'>click();</script>";
}
?>

