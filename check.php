<?php
session_start();

$myID="wanwan";
$myPWD="wan0624";

$id=$_POST["id"];
$pwd=$_POST["pwd"];

if(($myID==$id)&&($myPWD==$pwd)){
    $_SESSION["login"]="Yes";
    header("Location:ok.php");
}
else{
    $_SESSION["login"]="No";
    header("Location:fail.php");
}
?>