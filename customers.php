<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $sql_query = "SELECT * FROM CUSTOMERS WHERE deleted='false' ORDER BY customerID DESC";
            $res_for = $connector->query($sql_query);

            if ($res_for) {
                $data_render = array();
                while ($row = $res_for->fetch_assoc()) {
                    $data_render[] = $row;
                }
                echo json_encode(array("status" => "200", "customers" => $data_render));
            }
            $connector->close();
            break;
        case 'POST':
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $address = $_POST['address'];
            $contact = $_POST['phone'];
            $mail = $_POST['mail'];
            $profile = "";
            $registeredBy = $_POST['registered'];

            $fname = str_replace("'", "\'", $fname);
            $lname = str_replace("'", "\'", $lname);
            $address = str_replace("'", "\'", $address);
            $contact = str_replace("'", "\'", $contact);
            $registeredBy = str_replace("'", "\'", $registeredBy);
            $mail = str_replace("'", "\'", $mail);


            $sql_check = "SELECT customerUnique FROM CUSTOMERS ORDER BY customerID DESC";
            $idnum = "";
            if ($connector->query($sql_check)) {
                $row = $connector->query($sql_check)->fetch_assoc();
                if(!empty($row)){
                    list($idnum, $month, $year) = explode("/", $row['customerUnique']);
                }else{
                    $idnum = "0";
                }

                if ((int) $idnum <= 9) {
                    $idnum = "00" . ((int) $idnum + 1) . "/" . date("m/Y");
                } else if ((int) $idnum <= 99) {
                    $idnum = "0" . ((int) $idnum + 1) . "/" . date("m/Y");
                } else {
                    $idnum = ((int) $idnum + 1) . "/" . date("m/Y");
                }
                
            }

            // $unique = $unique . rand();
            if (!empty($fname) && !empty($lname) && !empty($address) && !empty($contact) && !empty($registeredBy)) {
                if (isset($_FILES['photo']) && isset($_FILES['photo']['name'])) {
                    $profile = $_FILES['photo'];
                    $filepath = "profiles/" . "PRF" . rand() . "." . pathinfo($profile['name'], PATHINFO_EXTENSION);

                    if (move_uploaded_file($profile['tmp_name'], $filepath)) {

                        $sql_post = "INSERT INTO CUSTOMERS (customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerProfile, customerUnique, registeredBy ) VALUES ('$fname','$lname','$mail','$address', '$contact', '/$filepath','$idnum', '$registeredBy')";
                    }
                } else {
                    $sql_post = "INSERT INTO CUSTOMERS (customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerUnique, registeredBy ) VALUES ('$fname','$lname','$mail','$address', '$contact','$idnum', '$registeredBy')";
                }

                if ($connector->query($sql_post)) {
                    echo json_encode(array("status" => "200", "message" => "Customer Added","UNIQUE_GENERATED" => $idnum));
                } else {
                    echo json_encode(array("status" => "500", "message" => "Something went Wrong"));
                }
            } else {
                echo json_encode(array("status" => "400", "message" => "Field Required"));
            }
            mysqli_close($connector);

            break;
        default:
            echo json_encode(array("status" => "404", "method" => "No such Method"));
            break;
    }
} else {
    echo json_encode(array("Connection Status" => "Not Connected"));
}


?>