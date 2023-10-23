<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $get_total = "SELECT * FROM DEALS WHERE deleted='false' AND dealStatus != 'PENDING'";
            $response = $connector->query($get_total);
            $full = 0;
            if ($response) {
                $total = 0;
                // $a = array();
                $se = array();
                while ($row = $response->fetch_assoc()) {
                    $another = explode("\n", $row['dealRequirements']);
                    foreach ($another as $one_line) {
                        $element = array(
                            "DATE_ADDED" => $row['registedDate'],
                            "THE_DATA" => $one_line
                        );

                        $se[] = $element;
                        $total += explode("-", $one_line)[1];
                    }

                    // $total += $row2['price'] * $row2['quantity'];
                }
                echo json_encode(array("status" => "200", "TOTAL" => $total, "RE_QUIREMENT" => $se));
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