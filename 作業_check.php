<?php
session_start();

$prpID="prp";
$prpPWD="prp";

$tchID="tch";
$tchPWD="tch";

$stuID="stu";
$stuPWD="stu";

$id=$_POST["id"];
$pwd=$_POST["pwd"];

if(($id==$prpID)&&($pwd==$prpPWD)){
    $_SESSION["login"]="prp";
    header("Location:作業_ok.php");
}
elseif(($id==$tchID)&&($pwd==$tchPWD)){
    $_SESSION["login"]="tch";
    header("Location:作業_ok.php");
}
elseif(($id==$stuID)&&($pwd==$stuPWD)){
    $_SESSION["login"]="stu";
    header("Location:作業_ok.php");
}
else{
    $_SESSION["login"]="-1";
    header("Location:作業_fail.php");
}
?>