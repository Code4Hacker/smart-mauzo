<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = $_GET['id'];
            $sql_query = "SELECT * FROM STOCKS WHERE stockID= '$id' AND deleted = 'false'";
            $res_for = $connector->query($sql_query);
            if ($res_for) {
                $data = array();
                $total = 0;

                while ($row = $res_for->fetch_assoc()) {
                    $data[] = $row;
                }
                echo json_encode(array("status" => "200", "stock" => $data));
            }
            $connector->close();
            break;

        case 'POST':
            $stockTitle = $_POST['stockTitle'];
            $stockDes = $_POST['stockDes'];
            $stockCost = $_POST['stockCost'];
            $id = $_POST['id'];
            $quantity = $_POST['quantity'];

            $stockTitle = str_replace("'", "\'", $stockTitle);
            $stockDes = str_replace("'", "\'", $stockDes);
            $stockCost = str_replace("'", "\'", $stockCost);
            $id = str_replace("'", "\'", $id);
            $quantity = str_replace("'", "\'", $quantity);

            
                    $sql_post = "UPDATE STOCKS SET stockTitle = '$stockTitle', stockDes = '$stockDes', stockCost = '$stockCost',  quantity = '$quantity' WHERE stockID = '$id'";

                    $responses = $connector->query($sql_post);
                    if ($responses) {
                        echo json_encode(array("status" => "200", "message" => "POSTED WITHOUT IMAGE"));
                    } else {
                        echo json_encode(array("status" => "500", "message" => "NOT POSTED"));
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