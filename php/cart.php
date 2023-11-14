<link rel="stylesheet" href="cart.css?v=<?=time()?>"> 
<script src="https://kit.fontawesome.com/ad45004b60.js" crossorigin="anonymous"></script>

<?php
echo "<h1><i class='fa-solid fa-cart-shopping'>購物車</h1></i>";
session_start();
$user_ID=$_SESSION['viewer_user_ID'];
$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");
$SQL="SELECT * FROM order_artwork_detail OAD JOIN oorder O ON OAD.order_ID=O.order_ID JOIN artwork A ON OAD.artwork_ID=A.artwork_ID WHERE O.user_ID=$user_ID AND OAD_status=0";
$result=mysqli_query($link,$SQL);
$total=0;
$count=0;
echo "<form id='form1' name='form1' action='checkout.php' method='post'>";
while($row=mysqli_fetch_assoc($result)){
    $order_ID=$row['order_ID'];
    $artwork_ID=$row['artwork_ID'];
    echo "<div class=cart>";
    echo "<IMG SRC='".$row['artwork_file']."'></IMG>";
    echo "<text>";
    echo "<font size=6>商品名稱:".$row['artwork_name']."</font></br>";
    echo "<HR width=80% color='#dddddd'>";
    echo"</br>";
    echo "數量:<input type='number' name='".$row['artwork_ID']."' id='".$row['artwork_ID']."' onmousedown='Showprice(this.id,".$row['artwork_price'].")' min='1' max='".$row['artwork_stock']."' onfocus=this.blur() value='".$row['OAD_Quantity']."'></br>";
    echo "<input type='hidden' name='".$row['artwork_ID']."price' value='".$row['artwork_price']."'>";
    echo "小計:<span id='".$row['artwork_ID']."total' >".$row['OAD_Amount']."元</span></br></br></br>";
    echo "<font size='5'><a href='delete_product.php?order_ID=".$order_ID."&artwork_ID=".$artwork_ID."' style='color:red;'>刪除商品</a></font>";
    echo "</text>";
    echo "</div>";
    if($count==0){
        $allID=$row['artwork_ID'];
        $allprice=$row['artwork_price'];
    }
    else{
        $allID.="@".$row['artwork_ID'];
        $allprice.="@".$row['artwork_price'];
    }
    $total+=$row['OAD_Amount'];
    $count++;
}

@$allIDarray=explode("@",$allID);
@$allpricearray=explode("@",$allprice);

foreach ($allIDarray as $value) {
    @$json .= json_encode($value) . ',';
  } 
$arr='[' . substr($json,0,strlen($json) - 1) . ']';

foreach ($allpricearray as $pvalue) {
    @$pjson .= json_encode($pvalue) . ',';
  } 
$parr='[' . substr($pjson,0,strlen($pjson) - 1) . ']';

echo "<div class=total-block>";
echo "<div class=total>";
echo "總計:<span id='Total' >".$total."元</span></br>";;
echo "</div>";
echo @"<input type='hidden' name='order' value='$order_ID'>";
if(!empty($order_ID)){
    echo "<input type='submit' value='去結帳'></br>";
}

echo "</div>";
echo"<div class='back'>";
    echo"<center>";
        echo"<a href='index.php'><button>返回商品首頁</button></a>";
    echo"</center>";
echo"</div>";
echo "</form>";
?>

<script type="text/javascript">
function Showprice(id,price){

    const json = '<?php echo $arr; ?>';
    const arr = JSON.parse(json);

    const pjson = '<?php echo $parr; ?>';
    const parr = JSON.parse(pjson);

    var total=0
    document.getElementById(id).onchange = function(){
        if(!isNaN(this.value) && this.value != ""){
            document.getElementById(id+"total").innerHTML = (parseInt(this.value, 10) * price) + ".00元";
        }
        arr.forEach(function(x,index){
            var quantity=document.getElementById(x).value;
            parr.forEach(function(y,pindex){
                if(index==pindex){
                    total+=(parseInt(quantity, 10) * parseInt(y, 10));
                }
            });
        });
    document.getElementById("Total").innerHTML = (total) + "元";
    }
}
</script>


