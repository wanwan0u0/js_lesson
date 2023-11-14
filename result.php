<?php
if(isset($_POST["id"])){
    $id=$_POST["id"];
    $pwd=$_POST["pwd"];
    $gender=$_POST["gender"];

    $interest=$_POST["interest"];
    $myallinterest=implode(",",$interest);

    $city=$_POST["city"];
    $myallcity=implode(",",$city);

    $comment=$_POST["comment"];
    echo "你的ID是:".$id."</br>";
    echo "你的密碼是:".$pwd."</br>";
    if($gender=="male"){
        echo "你的性別是:男性</br>";
    }
    else{
        echo "你的性別是:女性</br>";
    }
    echo "你的興趣是:".$myallinterest."</br>";
    echo "你居住的城市是:".$myallcity."</br>";
    echo "你的建議有:</br>";
    echo nl2br(strip_tags($comment));
}


else{
    echo "資料輸入錯誤";
}


?>