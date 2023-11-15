<?php

    $dbhost = 'localhost';
    $dbname = 'myassess3';
    $dbuser = 'myAssess3';
    $dbpass = 'PIhKVcYXmHzWV9dc';

    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $sql = "SELECT `info`, `keyword` FROM `questions` WHERE 1";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    $response = json_encode($data);
    header('Content-Type: application/json; charset=utf-8');
    echo $response;

?>