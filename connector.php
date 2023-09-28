<?php 
    header("Access-Control-Allow-Origin: *");
    
    $host = 'localhost';
    $username = 'root';
    $passcode = '';
    $dbname = 'TAILOR';

    $connector = mysqli_connect($host,$username,$passcode,$dbname);

?>