<?php
$servername = "localhost";  // 数据库服务器的主机名
$username = "myAssess3"; // 数据库用户名
$password = "PIhKVcYXmHzWV9dc"; // 数据库密码
$dbname = "myassess3";   // 要连接的数据库名称


// $dbhost = 'localhost';
// $dbname = 'myassess3';
// $dbuser = 'myAssess3';
// $dbpass = 'PIhKVcYXmHzWV9dc';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // 设置PDO错误模式为异常
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "连接成功";
    
    // 在这里可以执行数据库操作
} catch (PDOException $e) {
    echo "连接失败: " . $e->getMessage();
}
?>