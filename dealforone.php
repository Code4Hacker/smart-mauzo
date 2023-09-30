<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $employee = $_GET['employee'];
            $customer = $_GET['customer'];
            $sql_query = "SELECT * FROM DEALS WHERE registeredBy = '$employee' AND customerId = '$customer'";
            $res_for = $connector -> query($sql_query);

            if($res_for){
                $data_render = array();
                while($row = $res_for -> fetch_assoc()){
                    $data_render[] = $row;
                }
                $row_count = $res_for -> num_rows;
                echo json_encode(array("status" => "200","deals" => $data_render,"counter" => $row_count));
            }
            $connector -> close();
            break;
        case 'POST':
            $id = $_POST['id'];
            $id = str_replace("'","\'", $id);

            $sql_post = "SELECT * FROM DEALS WHERE customerId = '$id'";
                $addcustomer = $connector -> query($sql_post);

                if($addcustomer){
                    $data_render = array();
                    while($row = $addcustomer -> fetch_assoc()){
                        $data_render[] = $row;
                    }
                    echo json_encode(array("status" => "200", "deals" => $data_render));
                }else{
                    echo json_encode(array("status" => "500", "message" => "Something went Wrong"));
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