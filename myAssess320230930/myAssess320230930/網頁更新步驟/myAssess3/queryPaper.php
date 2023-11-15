<?php

$sid = $_POST['sid']; // 额外参数1


$servername = "localhost";
$username = "myAssess3";
$password = "PIhKVcYXmHzWV9dc";
$dbname = "myassess3";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $currentDateTime = new DateTime();
    $year = $currentDateTime->format('Y');
    $month = $currentDateTime->format('m');

    // 查询语句
    $sql = "SELECT sid FROM `exam_m` ";

    // 准备查询
    $stmt = $conn->prepare($sql);

    // 执行查询
    $stmt->execute();

    // 检查查询是否成功
    if ($stmt->rowCount() > 0) {
        // 获取查询结果，使用 fetchAll() 获取所有结果集
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $jsonResult = json_encode($results);

        echo $jsonResult;
        // // 获取结果
        // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //     echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"] . "<br>";
        // }

    } else {
        echo "没有结果";
    }



    // 在这里可以执行数据库操作
} catch (PDOException $e) {
    echo "連接失敗: " . $e->getMessage();
}
