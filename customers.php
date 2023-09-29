<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $sql_query = "SELECT * FROM CUSTOMERS ORDER BY customerID DESC";
            $res_for = $connector -> query($sql_query);

            if($res_for){
                $data_render = array();
                while($row = $res_for -> fetch_assoc()){
                    $data_render[] = $row;
                }
                echo json_encode(array("status" => "200","customers" => $data_render));
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

            $sql_post = "INSERT INTO customerS (customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerPasscode ) VALUES ('$fname','$lname','$mail','$address', '$contact', '$passcode')";
            $sql_check = "SELECT * FROM customerS WHERE customerEmail = '$mail'";

            
            $response = $connector -> query($sql_check);

            if($response -> num_rows == 1){
                echo json_encode(array("status" => "400", "message" => "User Exist"));
            }else{
                $addcustomer = $connector -> query($sql_post);

                if($addcustomer){
                    echo json_encode(array("status" => "200", "message" => "Registration Successifull"));
                }else{
                    echo json_encode(array("status" => "500", "message" => "Something went Wrong"));
                }
            }
            mysqli_close($connector);

            break;
        case 'DELETE':
           $json_data = file_get_contents('php://input');
           $content = json_decode($json_data, true);
           $id = $content['id'];
           $id = str_replace("'","\'", $id);
           if(!empty($id)){
            $sql_delete = "DELETE FROM CUSTOMERS WHERE customerID = '$id'";

            $response = mysqli_query($connector, $sql_delete);

            if($response){
                echo json_encode(array("status" => "200"));
            }else{
                echo json_encode(array("status" => "500"));
            }
           }
           break;
        case 'PATCH':
            $json_data = file_get_contents('php://input');
            $patch = json_decode($json_data, true);
            $fname = $patch['fname'];
            $lname = $patch['lname'];
            $address = $patch['address'];
            $contact = $patch['phone'];
            $passcode = $patch['codes'];
            $mail = $patch['mail'];
            $id = $patch['id'];

            $fname = str_replace("'","\'", $fname);
            $lname = str_replace("'","\'", $lname);
            $address = str_replace("'","\'",$address);
            $contact = str_replace("'","\'", $contact);
            $passcode = str_replace("'","\'", $passcode);
            $mail = str_replace("'","\'", $mail);

            $sql_post = "UPDATE CUSTOMERS SET customerFirst = '$fname', customerLast = '$lname', customerEmail = '$mail', customerAddress = '$address', customerContact = '$contact' WHERE customerID = '$id'";
            $addcustomer = $connector -> query($sql_post);

                if($addcustomer){
                    echo json_encode(array("status" => "200", "message" => "Update Successifull"));
                }else{
                    echo json_encode(array("status" => "500", "message" => "Something went Wrong"));
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