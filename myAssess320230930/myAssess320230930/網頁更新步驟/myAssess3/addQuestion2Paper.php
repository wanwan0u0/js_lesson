<?php

    $dbhost = 'localhost';
    $dbname = 'myassess3';
    $dbuser = 'myAssess3';
    $dbpass = 'PIhKVcYXmHzWV9dc';

    $questions_sid = $_POST['questions_sid'];
    $exam_sid = $_POST['exam_sid'];
    
    
try{
    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $sql = "SELECT 1 FROM `exam_d`  WHERE exam_sid = :exam_sid and questions_sid=:questions_sid";
    $stmt = $connection->prepare($sql);

    $stmt->bindParam(':exam_sid', $exam_sid, PDO::PARAM_STR);    
    $stmt->bindParam(':questions_sid', $questions_sid, PDO::PARAM_STR);
    $stmt->execute();
    
    // 檢查是否已新增
    if ($stmt->rowCount() > 0) {
        // #查詢題目資料


        $response = array(
            "status" => "1"
        );

        $jsonResponse = json_encode($response);

        echo $jsonResponse;


    } else {
        #新增考卷
        $sql = "INSERT INTO `exam_d` (`exam_sid`,`questions_sid`) VALUES(:exam_sid,:questions_sid) ";

        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':exam_sid', $exam_sid, PDO::PARAM_STR);    
        $stmt->bindParam(':questions_sid', $questions_sid, PDO::PARAM_STR);
    
        $stmt->execute();


        #讀取考卷題目
        $sql = "SELECT *,E.id rowid  "
              ." from `exam_d` E LEFT JOIN   questions Q on E.questions_sid=Q.sid "
              ."WHERE E.exam_sid=:exam_sid";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':exam_sid', $exam_sid, PDO::PARAM_STR);    
    
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   

        $response = array(
            "status" => "2", 
            "data" => $results 
        );

        $jsonResponse = json_encode($response);

        echo $jsonResponse;

    }

}
catch (PDOException $e) {
    echo "新增失敗: " . $e->getMessage();
}
