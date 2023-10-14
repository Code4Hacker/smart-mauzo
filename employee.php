<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $sql_query = "SELECT * FROM EMPLOYEES WHERE deleted='false' ORDER BY employeeID DESC";
            $res_for = $connector -> query($sql_query);

            if($res_for){
                $data_render = array();
                while($row = $res_for -> fetch_assoc()){
                    $data_render[] = $row;
                }
                echo json_encode(array("status" => "200","employees" => $data_render));
            }
            $connector -> close();
            break;
        case 'POST':
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $address = $_POST['address'];
            $contact = $_POST['phone'];
            $passcode = $_POST['codes'];
            $mail = $_POST['mail'];

            $fname = str_replace("'","\'", $fname);
            $lname = str_replace("'","\'", $lname);
            $address = str_replace("'","\'",$address);
            $contact = str_replace("'","\'", $contact);
            $passcode = str_replace("'","\'", $passcode);
            $mail = str_replace("'","\'", $mail);

            $sql_post = "INSERT INTO EMPLOYEES (employeeFirst, employeeLast, employeeEmail, employeeAddress, employeeContact, employeePasscode ) VALUES ('$fname','$lname','$mail','$address', '$contact', '$passcode')";
            $sql_check = "SELECT * FROM EMPLOYEES WHERE employeeEmail = '$mail'";

            
            $response = $connector -> query($sql_check);

            if($response -> num_rows == 1){
                echo json_encode(array("status" => "400", "message" => "User Exist"));
            }else{
                $addemployee = $connector -> query($sql_post);

                if($addemployee){
                    echo json_encode(array("status" => "200", "message" => "Registration Successifull"));
                }else{
                    echo json_encode(array("status" => "500", "message" => "Something went Wrong"));
                }
            }
            mysqli_close($connector);

            break;
        default:
           echo json_encode(array("status" => "404", "method" => "No such Method"));
           break;
     }
   }else{
    echo json_encode(array("Connection Status" => "Not Connected"));
   }
?>