<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $fullname = $_POST['fullname'];
            if (!empty($fullname)) {
                $sql_connect = "SELECT * FROM WORKERS WHERE workerName='$fullname'";
                $result = mysqli_query($connector, $sql_connect);
                if ($result->num_rows == 0) {
                    $query_2 = "INSERT INTO WORKERS (workerID, workerName) VALUES (NULL, '$fullname')";
                    $res_2 = $connector->query($query_2);
                    if ($res_2) {
                        echo json_encode(array("status" => "200", "message" => "Worker Added"));
                    } else {
                        echo json_encode(array("status" => "500", "message" => "Worker Failed"));

                    }
                } else {
                    echo json_encode(array("status" => "400", "message" => "User Already Exist"));

                }
            }else{
                echo json_encode(array("status" => "402", "message" => "Fill the Field"));
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