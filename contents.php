<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = $_GET['id'];
            // $sql_query = "SELECT * FROM ADMINS WHERE adminEmail = '$admin' ORDER BY adminID DESC";
            // $res_for = $connector->query($sql_query);

            // if ($res_for->num_rows == 1) {
                $get_total = "SELECT * FROM DEALS WHERE deleted='false' AND mini_employee='$id' AND dealStatus != 'PENDING'";
                $response = $connector->query($get_total);
                $full = 0;
                if ($response) {
                    $total = 0;
                    // $a = array();
                    while ($row = $response->fetch_assoc()) {
                        $a = $row['dealID'];
                        $sql = "SELECT * FROM CONTENTS WHERE deleted='false' AND deal='$a'";
                        $res = $connector->query($sql);
                        $se = array();
                        while ($row2 = $res->fetch_assoc()) {
                            $se[] = $row2['price'] . "(" . $row2['quantity'] . ")";
                            $total += $row2['price'] * $row2['quantity'];
                        }
                    }
                    echo json_encode(array("status" => "200", "TOTAL" => $total));
                }

            // } else {
            //     json_encode(array("status" => "UnAuthorized User"));
            // }
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