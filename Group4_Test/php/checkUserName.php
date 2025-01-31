<?php
header('Access-Control-Allow-Origin: *');
include '../inc/dbConnection.php';
$dbConn = getDBConnection();
    
    $sql = "SELECT username 
            FROM admin
            WHERE username = :username";

    $statement = $dbConn->prepare($sql);
    $npara = array();
    $npara[":username"] = $_GET['username'];
    $statement->execute( $npara );
    $record = $statement->fetch(PDO::FETCH_ASSOC);
    
    print_r($record);
    echo json_encode($record); //jsonp -> "json format with padding"
?>