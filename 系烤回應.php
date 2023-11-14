<?php
if(isset($_POST["id"])){
    $id=$_POST["id"];
    $name=$_POST["name"];
    $choose1=$_POST["choose1"];
    $choose2=$_POST["choose2"];
    echo "你的學號是:".$id."</br>";
    echo "你的姓名是:".$name."</br>";
    if($choose1=="yes"){
        echo "是否會參加系烤:是</br>";
    }
    else{
        echo "是否會參加系烤:否</br>";
    }
    if($choose2=="yes"){
        echo "是否有繳系費:是</br>";
    }
    else{
        echo "是否有繳系費:否</br>";
    }
}
else{
    echo "資料輸入錯誤";
}



?>