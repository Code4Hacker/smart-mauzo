<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = $_GET['id'];
            $sql_query = "SELECT customerUnique FROM CUSTOMERS WHERE customerID = '$id'";
            if ($response = $connector->query($sql_query)) {
                $unique = $response->fetch_assoc()['customerUnique'];
                echo json_encode(array("status" => "200", "UNIQUE_ID" => $unique));
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