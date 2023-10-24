<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = $_GET['id'];
            $sql_query = "UPDATE STOCKS SET deleted='true' WHERE stockID = '$id'";
            $res_for = $connector->query($sql_query);
            if ($res_for) {
                echo json_encode(array("status" => "200"));
            }else{
                echo json_encode(array("status" => "400"));

            }
            $connector->close();
            break;
        default:
            echo json_encode(array("status" => "404", "method" => "No such Method"));
            break;
    }
} else {
    echo json_encode(array("Connection Status" => "Not Connected"));
}
?>