<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = $_GET['id'];
            $name_worker = $_GET['mini_employee'];

            $sql_query = "SELECT * FROM CONTENTS WHERE mini_employee = '$name_worker' AND  deal = '$id' AND deleted = 'false' ORDER BY cID DESC";
            $res_for = $connector->query($sql_query);
            if ($res_for) {
                $name_for = "";
                $sql = "SELECT customerId FROM DEALS WHERE dealID='$id'";
                $result = $connector -> query($sql);
                if($result){
                    $res = $result -> fetch_assoc()['customerId'];
                    $new_query = "SELECT * FROM CUSTOMERS WHERE customerUnique = '$res'";
                    $respond = $connector -> query($new_query) -> fetch_assoc();
                    $name_for = $respond['customerFirst'] . " " . $respond['customerLast'];
                }
                $data_render = array();
                while ($row = $res_for->fetch_assoc()) {
                    $data_render[] = $row;
                }
                $row_count = $res_for->num_rows;
                echo json_encode(array("status" => "200", "deals" => $data_render, "the_name" => $name_for, "counter" => $row_count));
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