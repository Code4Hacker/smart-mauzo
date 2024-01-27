<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $category = $_GET['category'];
            $datestart = $_GET['start'];
            $dateto_end = $_GET['to_end'];
            $sql_query = "SELECT * FROM STOCKS WHERE category = '$category' AND deleted = 'false' AND dateIn BETWEEN '$datestart' AND '$dateto_end'  ORDER BY stockID DESC";
            $res_for = $connector->query($sql_query);
            if ($res_for) {
                $data = array();
                $total = 0;

                while ($row = $res_for->fetch_assoc()) {
                    $data[] = $row;
                    $total += $row['stockCost'] * $row['quantity'];
                }
                echo json_encode(array("status" => "200", "stocks" => $data, "TOTAL" => $total));
            }
            $connector->close();
            break;

        case 'POST':
            $stockTitle = $_POST['stockTitle'];
            $stockDes = $_POST['stockDes'];
            $stockCost = $_POST['stockCost'];
            $registered = $_POST['registered'];
            $quantity = $_POST['quantity'];
            $category = $_POST['category'];
            $photo = "";
            if (isset($_FILES['photo']) && $_FILES['photo']['name']) {
                $photo = $_FILES['photo'];
            }

            $stockTitle = str_replace("'", "\'", $stockTitle);
            $stockDes = str_replace("'", "\'", $stockDes);
            $stockCost = str_replace("'", "\'", $stockCost);
            $registered = str_replace("'", "\'", $registered);
            $quantity = str_replace("'", "\'", $quantity);
            $category = str_replace("'", "\'", $category);

            if (!empty($stockTitle)) {
                if (!empty($photo)) {
                    $filepath = "stocks/STK_" . rand() . "." . pathinfo($photo['name'], PATHINFO_EXTENSION);
                    if (move_uploaded_file($photo['tmp_name'], $filepath)) {
                        $sql_post = "INSERT INTO STOCKS (stockTitle, stockDes, stockCost, registeredBy, stockImage, quantity, category) VALUES ('$stockTitle','$stockDes','$stockCost','$registered','/$filepath','$quantity', '$category')";

                        $responses = $connector->query($sql_post);
                        if ($responses) {
                            echo json_encode(array("status" => "200", "message" => "POSTED"));
                        } else {
                            echo json_encode(array("status" => "500", "message" => "NOT POSTED"));
                        }
                    } else {
                        $sql_post = "INSERT INTO STOCKS (stockTitle, stockDes, stockCost, registeredBy, quantity, category) VALUES ('$stockTitle','$stockDes','$stockCost','$registered','$quantity', '$category')";

                        $responses = $connector->query($sql_post);
                        if ($responses) {
                            echo json_encode(array("status" => "200", "message" => "POSTED WITHOUT IMAGE"));
                        } else {
                            echo json_encode(array("status" => "500", "message" => "NOT POSTED"));
                        }
                    }
                } else {
                    $sql_post = "INSERT INTO STOCKS (stockTitle, stockDes, stockCost, registeredBy, quantity, category) VALUES ('$stockTitle','$stockDes','$stockCost','$registered','$quantity', '$category')";

                    $responses = $connector->query($sql_post);
                    if ($responses) {
                        echo json_encode(array("status" => "200", "message" => "POSTED WITHOUT IMAGE"));
                    } else {
                        echo json_encode(array("status" => "500", "message" => "NOT POSTED"));
                    }
                }
            } else {
                echo json_encode(array("status" => "400", "message" => "Fill the fields"));
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