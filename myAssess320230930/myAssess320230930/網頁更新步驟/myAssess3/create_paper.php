<?php
$sid = $_POST['sid']; 

$servername = "localhost";
$username = "myAssess3";
$password = "PIhKVcYXmHzWV9dc";
$dbname = "myassess3";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 查询语句
    $sql = "SELECT 1 FROM `exam_m`  WHERE sid = :sid";
    // 准备查询
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    // 执行查询
    $stmt->execute();

    // 检查查询是否成功
    if ($stmt->rowCount() > 0) {
        #查詢題目資料

        // 查询语句
        // $sql = "SELECT * FROM `exam_d`  WHERE exam_sid = :sid";
        $sql = "SELECT *,E.id rowid "
        ." from `exam_d` E LEFT JOIN   questions Q on E.questions_sid=Q.sid "
        ."WHERE E.exam_sid=:exam_sid";
        // 准备查询
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':exam_sid', $sid, PDO::PARAM_STR);
        // 执行查询
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   

        $response = array(
            "status" => "d", 
            "data" => $results 
        );

        $jsonResponse = json_encode($response);

        echo $jsonResponse;


    } else {
        #新增考卷
        $sql = "INSERT INTO exam_m (sid) VALUES(:sid) ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
        $stmt->execute();

        $response = array(
            "status" => "m", 
        );

        $jsonResponse = json_encode($response);

        echo $jsonResponse;

    }


    // 在这里可以执行数据库操作
} catch (PDOException $e) {
    echo "連接失敗: " . $e->getMessage();
}
