<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $title = $_GET['title'];
            $sql_query = "SELECT * FROM DEALS WHERE dealTitle LIKE '%$title%' AND deleted='false'";
            if ($response = $connector->query($sql_query)) {
                $results = array();
                while($row = $response->fetch_assoc()){
                    $results[] = $row;
                }
                echo json_encode(array("status" => "200", "deals" => $results));
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