<?php

$dbhost = 'localhost';
$dbname = 'myassess3';
$dbuser = 'myAssess3';
$dbpass = 'PIhKVcYXmHzWV9dc';

$id = $_POST['id'];
$exam_sid = $_POST['exam_sid'];



try {

    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

    #刪除
    $sql = "DELETE FROM `exam_d`  WHERE id = :id ";
    $stmt = $connection->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();


    #讀取考卷題目
    $sql = "SELECT *,E.id rowid  "
        . " from `exam_d` E LEFT JOIN   questions Q on E.questions_sid=Q.sid "
        . "WHERE E.exam_sid=:exam_sid";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':exam_sid', $exam_sid, PDO::PARAM_STR);

    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $jsonResponse = json_encode($results);

    echo $jsonResponse;

} catch (PDOException $e) {
    echo "刪除失敗: " . $e->getMessage();
}
