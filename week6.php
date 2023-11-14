<meta charset="uft-8">

<?php
date_default_timezone_set('Asia/Taipei');
echo date("Y-M-d H:i:s",time());
echo "</br>";
echo mktime(0,0,0,4,1,2023);
echo "</br>";
echo $nM=strtotime("next month");
echo "</br>";
echo date("Y-M-d H:i:s",$nM);
?>

<form action="wee6_check.php" method="post" enctype="multipart/form-data">
<?php
if(isset($_COOKIE["myID"])){
    echo $_COOKIE["myID"]."安安!</br>";
    //setcookie("myID","",time()-100);
    echo "ID:<input type='text' name='ID' value='".$_COOKIE["myID"]."' ></br>";
    echo "Password:<input type='password' name='PWD' value='".$_COOKIE["myPWD"]."' ></br>";
}
else{
    echo "ID:<input type='text' name='ID'></br>";
    echo "Password:<input type='password' name='PWD'></br>";
}

?>
<input type="file" name="myfile" accept="image/png"></br>
<input type="submit"> <input type="reset">
</form>