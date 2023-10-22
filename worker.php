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
            $sql_query = "SELECT * FROM DEALS WHERE mini_employee = '$name_worker' AND deleted = 'false' AND registedDate BETWEEN '$datestart' AND '$dateto_end' ORDER BY dealID DESC";
            $res_for = $connector->query($sql_query);
            if ($res_for) {
                $data_render = array();
                while ($row = $res_for->fetch_assoc()) {
                    $data_render[] = $row;
                }
                $row_count = $res_for->num_rows;
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