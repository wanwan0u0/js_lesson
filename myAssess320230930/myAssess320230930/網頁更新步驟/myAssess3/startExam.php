<?php

$exam_sid = $_POST['exam_sid'];

$dbhost = 'localhost';
$dbname = 'myassess3';
$dbuser = 'myAssess3';
$dbpass = 'PIhKVcYXmHzWV9dc';

$connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$sql = "SELECT * FROM `exam_d` D LEFT join questions Q on D.questions_sid=Q.sid WHERE D.exam_sid =:exam_sid;";

$stmt = $connection->prepare($sql);
$stmt->bindParam(':exam_sid', $exam_sid, PDO::PARAM_STR);
$stmt->execute();

#試卷是否存在
if ($stmt->rowCount() > 0) {

    #產生考卷
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);



     #考試試卷新增
     /*$sql = "INSERT INTO `exampaper_m`(`exam_sid`) VALUES (:exam_sid); "
             ."SET @last_id = LAST_INSERT_ID();"

             ."INSERT INTO `exampaper_d`(`examPaper_id`, `questions_sid`) "
             ."SELECT @last_id,sid FROM questions "
             ."WHERE sid in(SELECT questions_sid FROM exam_d WHERE exam_sid=:exam_sid) "
             ."SELECT @last_id";

     $stmt = $connection->prepare($sql);
     $stmt->bindParam(':exam_sid', $exam_sid, PDO::PARAM_STR);
     $stmt->execute();

     $results2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "INSERT INTO `exampaper_m`(`exam_sid`) VALUES (:exam_sid);";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':exam_sid', $exam_sid, PDO::PARAM_STR);
    $stmt->execute();*/
    $lastInsertId_m = $connection->lastInsertId();


    /*$sql = "INSERT INTO `exampaper_d`(`examPaper_id`, `questions_sid`) 
        SELECT :examPaper_id, sid FROM questions 
        WHERE sid IN (SELECT questions_sid FROM exam_d WHERE exam_sid = :exam_sid);";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':examPaper_id', $lastInsertId_m, PDO::PARAM_INT); // 使用exampaper_m的自增ID
    $stmt->bindParam(':exam_sid', $exam_sid, PDO::PARAM_STR);

    // 执行插入操作
    $stmt->execute();*/


    $response = array(
        "status" => "1",
        "data" => $results,
        "examPaper_sid" => $lastInsertId_m
    );

    $response = json_encode($response);
    echo $response;
} else {
    $response = array(
        "status" => "0",
    );

    $response = json_encode($response);
    echo $response;
}
