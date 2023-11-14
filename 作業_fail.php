<?php ob_start(); ?>
<?php
session_start();
if($_SESSION["login"]=="-1"){

}
else{
    header("Location:作業_error.php");
}
?>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
登入失敗!!!</br>
網頁將在三秒後跳轉登入頁面</br>
<a href="作業_使用者介面.php">點選這裡</a>
<?php
header("Refresh:3;url=http://127.0.0.1/%E4%BD%9C%E6%A5%AD_%E4%BD%BF%E7%94%A8%E8%80%85%E4%BB%8B%E9%9D%A2.php")
?>
</body>
</html>
<?php ob_end_flush(); ?>
