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
$user_ID=$_SESSION['viewer_user_ID'];
$order_ID=$_POST['order_ID'];
$artwork_ID=$_POST['artwork_ID'];
$quantity=$_POST['quantity'];
$priceSQL="SELECT * FROM artwork WHERE artwork_ID=$artwork_ID";
$priceresult=mysqli_query($link,$priceSQL);
$pricerow=mysqli_fetch_assoc($priceresult);
$price=$pricerow['artwork_price'];
$amount=$quantity * $price;

$checkSQL="SELECT * FROM oorder WHERE order_ID=$order_ID";
$checkresult=mysqli_query($link,$checkSQL);
$checkrow=mysqli_fetch_assoc($checkresult);

if(@$checkrow['order_ID']!=null){
}
else{
    $SQL="INSERT INTO oorder(order_ID, user_ID) VALUES('$order_ID','$user_ID')";
    $result=mysqli_query($link,$SQL);
}

$detailSQL="SELECT * FROM order_artwork_detail WHERE order_ID=$order_ID AND artwork_ID=$artwork_ID";
$detailresult=mysqli_query($link,$detailSQL);
$detailrow=mysqli_fetch_assoc($detailresult);

if(@$detailrow['order_ID']!=null && @$artwork_ID==$detailrow['artwork_ID']){
    $newquantity=$detailrow['OAD_Quantity']+$quantity;
    $price_SQL="SELECT artwork_price,artwork_stock FROM artwork where artwork_ID=$artwork_ID";
    $price_result=mysqli_query($link,$price_SQL);
    $price_row=mysqli_fetch_assoc($price_result);
    $fixquantity=($newquantity>$price_row['artwork_stock']?$price_row['artwork_stock']:$newquantity);
    $newamount=$fixquantity*$price;
    $SQL="UPDATE order_artwork_detail SET OAD_Quantity='$fixquantity' , OAD_Amount='$newamount' where order_ID=$order_ID AND artwork_ID=$artwork_ID";
    if($result=mysqli_query($link,$SQL)){
        echo "<input type='button' value='返回' onclick='goBack()' id='div'>";
        echo "<script type='text/javascript'>click();</script>";
    }
}
else{
    $SQL="INSERT INTO order_artwork_detail(artwork_ID, order_ID,OAD_Quantity,OAD_Amount,OAD_status) VALUES('$artwork_ID','$order_ID','$quantity','$amount',0)";
    if($result=mysqli_query($link,$SQL)){
        echo "<input type='button' value='返回' onclick='goBack()' id='div'>";
        echo "<script type='text/javascript'>click();</script>";
    }
}

?>

