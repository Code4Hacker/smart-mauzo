<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
           $id = $_GET['id'];
           $id = str_replace("'","\'", $id);
           if(!empty($id)){
            $sql_delete = "UPDATE CUSTOMERS SET deleted='true' WHERE customerID = '$id'";

            $response = mysqli_query($connector, $sql_delete);

            if($response){
                echo json_encode(array("status" => "200"));
            }else{
                echo json_encode(array("status" => "500"));
            }
           }
           break;
        case 'POST':
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $address = $_POST['address'];
            $contact = $_POST['phone'];
            $passcode = $_POST['codes'];
            $mail = $_POST['mail'];
            $id = $_POST['id'];

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