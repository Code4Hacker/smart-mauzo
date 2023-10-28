<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = $_GET['id'];
            // $cID = $_GET['cId'];
            $query = "SELECT * FROM CONTENTS WHERE deal = '$id' AND deleted = 'false'";
            $res = $connector -> query($query);
            $dealnumber = 0;
            $data = array();
            while($row = $res -> fetch_assoc()){
                // if()
                $dealnumber += 1;
                $data[] = $row['categories'];
            }
            echo json_encode(array("dealIndex" => $dealnumber, "content" => $data));
            $connector->close();
            break;
        default:
            break;
    }
} else {
    echo json_encode(array("connection Error"));
}
?>