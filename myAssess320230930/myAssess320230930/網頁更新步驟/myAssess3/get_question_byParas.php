<?php

    $keyword = $_POST['keyword']; 

    $dbhost = 'localhost';
    $dbname = 'myassess3';
    $dbuser = 'myAssess3';
    $dbpass = 'PIhKVcYXmHzWV9dc';

    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $sql = "SELECT `sid`, `info`, `keyword` FROM `questions` WHERE 1";

    if (!empty($keyword)) {
        $sql .= " AND `keyword` LIKE :keyword";
    }

    $statement = $connection->prepare($sql);

    if (!empty($keyword)) {
        $keyword = "%$keyword%"; 
        $statement->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    }
    

    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    $response = json_encode($data);
    header('Content-Type: application/json; charset=utf-8');
    echo $response;

?>