<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, PATCH, GET, DELETE");
    
    $host = 'localhost';
    $username = 'root';
    $passcode = '';
    $dbname = 'tailor';

    $connector = mysqli_connect($host,$username,$passcode,$dbname);

?>