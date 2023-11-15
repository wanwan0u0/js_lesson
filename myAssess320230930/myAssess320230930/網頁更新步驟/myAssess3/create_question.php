<?php
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
    $sql = "SELECT max(SUBSTRING_INDEX(sid, 'Q', -1))+1 AS numeric_part FROM `questions`  WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year";

    // 准备查询
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);


    // 执行查询
    $stmt->execute();

    // 检查查询是否成功
    if ($stmt->rowCount() > 0) {
        // // 获取结果
        // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //     echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"] . "<br>";
        // }
        $numericPart = $stmt->fetchColumn();

        $sid = "";

        if ($numericPart === null) {
            $sid = "Q" . strval($year) . strval($month) . "0001";
        } else {
            $sid ="Q". $numericPart;
        }
    } else {
        echo "没有结果";
    }

    $sql = "INSERT INTO `questions`( `sid`) " 
            ." VALUES (:sid)";


    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->execute();
   
    echo $sid;

    // 在这里可以执行数据库操作
} catch (PDOException $e) {
    echo "連接失敗: " . $e->getMessage();
}
