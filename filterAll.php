<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = $_GET['id'];
            $ctg = $_GET['ctg'];
            $sql_query = "SELECT * FROM CONTENTS WHERE deal = '$id' AND categories='$ctg' AND deleted = 'false' ORDER BY cID DESC";
            $res_for = $connector->query($sql_query);
            if ($res_for) {
                $data_render = array();
                while ($row = $res_for->fetch_assoc()) {
                    $data_render[] = $row;
                }
                $row_count = $res_for->num_rows;
                echo json_encode(array("status" => "200", "deals" => $data_render, "counter" => $row_count));
            }
            $connector->close();
            break;
        default:
            break;
    }
} else {
    echo json_encode(array("connection Error"));
}
?>