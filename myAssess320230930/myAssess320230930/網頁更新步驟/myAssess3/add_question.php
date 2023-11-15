<?php

    $dbhost = 'localhost';
    $dbname = 'myassess3';
    $dbuser = 'myAssess3';
    $dbpass = 'PIhKVcYXmHzWV9dc';

    $info = $_POST['info'];
    $keyword = $_POST['keyWord'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $isUpload1 = $_POST['isUpload1'];
    $isUpload2 = $_POST['isUpload2'];
    $isUpload3 = $_POST['isUpload3'];
    $isUpload4 = $_POST['isUpload4'];
    $sid = $_POST['sid'];
    $correctValue = $_POST['correctValue'];
    
    
try{
    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $sql = "UPDATE `questions` " 
            ." set `info`=:info, `keyword`=:keyword, `optionStr1`=:option1, `optionStr2`=:option2,`correctValue`=:correctValue,"
            ." `optionStr3`=:option3,infoVideo=:isUpload1,optionVideo1=:isUpload2,optionVideo2=:isUpload3,optionVideo3=:isUpload4,updated_at=NOW() "
            ." WHERE sid=:sid";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':info', $info, PDO::PARAM_STR);
    $statement->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $statement->bindParam(':option1', $option1, PDO::PARAM_STR);
    $statement->bindParam(':option2', $option2, PDO::PARAM_STR);
    $statement->bindParam(':option3', $option3, PDO::PARAM_STR);
    $statement->bindParam(':isUpload1', $isUpload1, PDO::PARAM_INT);
    $statement->bindParam(':isUpload2', $isUpload2, PDO::PARAM_INT);
    $statement->bindParam(':isUpload3', $isUpload3, PDO::PARAM_INT);
    $statement->bindParam(':isUpload4', $isUpload4, PDO::PARAM_INT);    
    $statement->bindParam(':sid', $sid, PDO::PARAM_STR);
    $statement->bindParam(':correctValue', $correctValue, PDO::PARAM_STR);
    $statement->execute();
    
    echo "新增成功";
}
catch (PDOException $e) {
    echo "新增失敗: " . $e->getMessage();
}

?>