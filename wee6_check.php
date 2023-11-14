<meta charset="utf-8">

<?php
$ID=$_POST["ID"];
$PWD=$_POST["PWD"];

$id="wanwan";
$pwd="wan0624";

if(($ID=$id)&&($PWD==$pwd)){
    echo "登入成功";
    setcookie("myID",$id);
    setcookie("myPWD",$pwd);
}
else{
    echo "登入失敗";
}

echo "檔案名稱: ".$_FILES["myfile"]["name"]."</br>";
echo "暫存檔名: ".$_FILES["myfile"]["tmp_name"]."</br>";
echo "檔案尺寸: ".$_FILES["myfile"]["size"]."</br>";
echo "檔案種類: ".$_FILES["myfile"]["type"]."</br>";

copy($_FILES["myfile"]["tmp_name"],"mypic.png");
unlink($_FILES["myfile"]["tmp_name"]);

?>