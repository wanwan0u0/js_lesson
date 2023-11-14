<?php
date_default_timezone_set('Asia/Taipei');
$checkout_date=date("Y-m-d H:i:s",time());
session_start();
$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");
$totalquantity=0;
$totalamount=0;
$user_ID=$_SESSION['viewer_user_ID'];
$order_ID=$_POST['order'];

$SQL="SELECT * FROM order_artwork_detail OAD JOIN oorder O ON OAD.order_ID=O.order_ID WHERE O.user_ID=$user_ID AND OAD.order_ID=$order_ID";
$result=mysqli_query($link,$SQL);
while($row=mysqli_fetch_assoc($result)){
    $artwork_ID=$row['artwork_ID'];
    if(isset($_POST[$row['artwork_ID']])){
        $quantity=$_POST[$row['artwork_ID']];
        $price=$_POST[$row['artwork_ID']."price"];
        $amount=$quantity*$price;
    }
    else{
        $quantity=$row['OAD_Quantity'];
        $amount=$row['OAD_Amount'];
    }
    $stockcheck_SQL="SELECT artwork_stock FROM artwork where artwork_ID=$artwork_ID";
    $stockcheckresult=mysqli_query($link,$stockcheck_SQL);
    $stockcheckrow=mysqli_fetch_assoc($stockcheckresult);
    $stock=$stockcheckrow['artwork_stock'];
    $remain=$stock-$quantity;
    $stock_SQL="UPDATE artwork SET artwork_stock='$remain' where artwork_ID=$artwork_ID";
    $stockresult=mysqli_query($link,$stock_SQL);

    $updateSQL="UPDATE order_artwork_detail SET OAD_Quantity='$quantity',  OAD_Amount='$amount',  OAD_status='1' where order_ID=$order_ID AND artwork_ID=$artwork_ID";
    $updateresult=mysqli_query($link,$updateSQL);
    $totalquantity+=$quantity;
    $totalamount+=$amount;
}
$SQL="UPDATE oorder SET order_total_number='$totalquantity' , order_total_price='$totalamount',order_datetime='$checkout_date' where order_ID=$order_ID AND user_ID=$user_ID";
$updateresult=mysqli_query($link,$SQL);


header("location:result.php?order_ID=$order_ID")
?>
