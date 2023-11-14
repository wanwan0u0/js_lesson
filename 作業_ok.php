<html>
<?php
session_start();

if($_SESSION["login"]=="prp" ||$_SESSION["login"]== "tch" ||$_SESSION["login"]== "stu"){
    echo "student</br>";
    if($_SESSION["login"]=="prp" ||$_SESSION["login"]== "tch"){
        echo "teacher</br>";
        if($_SESSION["login"]=="prp"){
            echo "principal</br>";
        }
        else{}
    }
    else{}
}
else{
    header("Location:作業_error.php");
}
?>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
echo "哈哈瑟瑟"."</br>";
?>
<a href="作業_logout.php">Logout</a>
</body>
</html>
