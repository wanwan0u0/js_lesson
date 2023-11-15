<?php

    $dbhost = 'localhost';
    $dbname = 'myassess3';
    $dbuser = 'myAssess3';
    $dbpass = 'PIhKVcYXmHzWV9dc';

    $examPaper_id = $_POST['examPaper_id'];
    $Ansers = json_decode($_POST['Ansers'],true);

   
    
try{
    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

    foreach ($Ansers as $data) {
        $anser = $data['anser'];
        $qsid = $data['qsid'];
        
        // 创建 SQL 更新语句
        $sql = "UPDATE `exampaper_d` SET Anser = :anser WHERE examPaper_id=:examPaper_id and questions_sid = :qsid";
        
        // 准备更新语句
        $stmt = $connection->prepare($sql);
        
        // 绑定参数
        $stmt->bindParam(':anser', $anser, PDO::PARAM_STR);
        $stmt->bindParam(':qsid', $qsid, PDO::PARAM_STR);
        $stmt->bindParam(':examPaper_id', $examPaper_id, PDO::PARAM_STR);
        
        // 执行更新语句
        $stmt->execute();
    }

    $sql = "SELECT EM.*,Q.correctValue,"
            ." case EM.Anser=Q.correctValue"
            ." when true THEN 'O'"
            ." ELSE 'X' END isCorrect"
            ." FROM `exampaper_d` EM LEFT JOIN questions Q on EM.questions_sid=Q.sid WHERE examPaper_id=:examPaper_id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':examPaper_id', $examPaper_id, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = json_encode($results);
    echo $response;
    
}
catch (PDOException $e) {
    echo "新增失敗: " . $e->getMessage();
}

?>