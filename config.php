<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fetch_crud_app";

    try{
        $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        echo "Connection error= ".$e->getMessage();
    };
?>