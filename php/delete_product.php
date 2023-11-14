<script type="text/javascript">
function goBack(){
    window.history.go(-1);
}

function click(){
    let div=document.getElementById("div");
    div.click();
}
</script>
<meta charset="uft-8">
<?php
$order_ID=$_GET['order_ID'];
$artwork_ID=$_GET['artwork_ID'];
$boolean=0;
$link=@mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");

$order_artwork_detail_SQL="DELETE FROM order_artwork_detail WHERE order_ID='$order_ID' AND artwork_ID='$artwork_ID'";
if($order_artwork_detail_result=mysqli_query($link,$order_artwork_detail_SQL)){
    $checkSQL="SELECT order_ID FROM order_artwork_detail";
    $checkresult=mysqli_query($link,$checkSQL);
    while($row=mysqli_fetch_assoc($checkresult)){
        if($row['order_ID']==$order_ID){
            $boolean=1;
        }
    }
    if($boolean==0){    
        $order_SQL="DELETE FROM oorder WHERE order_ID=$order_ID";
        $result=mysqli_query($link,$order_SQL);
    }
    echo "<input type='button' value='返回' onclick='goBack()' id='div'>";
    echo "<script type='text/javascript'>click();</script>";
}
?>
