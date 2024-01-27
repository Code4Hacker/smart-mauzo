<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, PATCH, GET, DELETE");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");
    header("Access-Control-Max-Age: 3600");
    
    $host = 'localhost';
    $username = 'root';
    $passcode = '';
    $dbname = 'online';

    $connector = mysqli_connect($host,$username,$passcode,$dbname);

?>