<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $sql_query = "SELECT * FROM WORKERS ORDER BY workerID DESC";
            $res_for = $connector->query($sql_query);
            if ($res_for) {
                $data_render = array();
                while ($row = $res_for->fetch_assoc()) {
                    $data_render[] = $row;
                }
                $row_count = $res_for->num_rows;
                echo json_encode(array("status" => "200", "workers" => $data_render, "counter" => $row_count));
            }
            $connector->close();
            break;
        case 'POST':
            $name_worker = $_POST['name_worker'];
            $datestart = $_POST['start'];
            $dateto_end = $_POST['to_end'];
            // $name_worker = $_GET['name_worker'];
            $sql_query = "SELECT * FROM DEALS WHERE deleted = 'false' AND registedDate BETWEEN '$datestart' AND '$dateto_end' ORDER BY dealID DESC";
            $res_for = $connector->query($sql_query);
            if ($res_for) {
                $data_render = array();
                $row_count = 0;
                // $total = 0;
                while ($row = $res_for->fetch_assoc()) {
                    $data_render[] = $row;
                    $id = $row['dealID'];
                    $sql_query2 = "SELECT * FROM CONTENTS WHERE mini_employee = '$name_worker' AND  deal = '$id' AND deleted = 'false' ORDER BY cID DESC";
                    $res_for2 = $connector->query($sql_query2);
                    $row_count += $res_for2->num_rows;
                }
                echo json_encode(array("status" => "200", "deals" => $data_render, "counter" => $row_count, "date_start" => $datestart,"date_end" => $dateto_end));
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