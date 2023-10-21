<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $employee = $_GET['employee'];
            $customer = $_GET['customer'];
            //  registeredBy = '$employee' AND 
            $sql_query = "SELECT * FROM DEALS WHERE customerId = '$customer' AND deleted = 'false' ORDER BY dealID DESC";
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
            $title = $_POST['title'];
            $descr = $_POST['description'];
            $requires = $_POST['requires'];
            $registeredBy = $_POST['bywho'];
            $customerId = $_POST['cId'];
            $price = $_POST['price'];
            $measures = $_POST['measures'];
            $category = $_POST['category'];
            $status = $_POST['status'];
            $tracking = $_POST['track'];
            $quantity = $_POST['quantity'];

            $title = str_replace("'", "\'", $title);
            $descr = str_replace("'", "\'", $descr);
            $requires = str_replace("'", "\'", $requires);
            $registeredBy = str_replace("'", "\'", $registeredBy);
            $customerId = str_replace("'", "\'", $customerId);
            $price = str_replace("'", "\'", $price);
            $measures = str_replace("'", "\'", $measures);
            $category = str_replace("'", "\'", $category);
            $status = str_replace("'", "\'", $status);
            $tracking = str_replace("'", "\'", $tracking);
            $quantity = str_replace("'", "\'", $quantity);

            $sql_query = "SELECT * FROM CUSTOMERS WHERE customerUnique = '$customerId'";
            $res_for = $connector -> query($sql_query);

            if($res_for -> num_rows == 1){
                if(!empty($title) && !empty($descr) && !empty($requires) && !empty($registeredBy) && !empty($customerId) && !empty($price) && !empty($measures) && !empty($category) && !empty($quantity)){
                    $query_send = "";
                    if(empty($status)){
                        $query_send = "INSERT INTO DEALS (dealID, dealTitle, dealDescription, dealRequirements, registeredBy, customerId, price, measurements, categories, tracking, quantity) VALUES (NULL, '$title','$descr','$requires','$registeredBy','$customerId','$price','$measures', '$category','$tracking', '$quantity')";
                    } else if(empty($tracking)){
                        $query_send = "INSERT INTO DEALS (dealID, dealTitle, dealDescription, dealRequirements, registeredBy, customerId, price, measurements, categories, dealStatus, quantity) VALUES (NULL, '$title','$descr','$requires','$registeredBy','$customerId','$price','$measures', '$category', '$status', '$quantity')";
                    } else {
                        $query_send = "INSERT INTO DEALS (dealID, dealTitle, dealDescription, dealRequirements, registeredBy, customerId, price, measurements, categories, dealStatus, tracking, quantity) VALUES (NULL, '$title','$descr','$requires','$registeredBy','$customerId','$price','$measures', '$category', '$status','$tracking', '$quantity')";
                    }

                    $responses  =  $connector -> query($query_send);

                    if($responses){
                        echo json_encode(array("status" => "200","message" => "New Deall Added, Successiful!"));
                    }else{
                        echo json_encode(array("status" => "500","message" => "Something Went Wrong!"));
                    }
                }else{
                    echo json_encode(array("status" => "400","message" => "Fill All Fields"));
                }
            }else{
                echo json_encode(array("status" => "404","message" => "No Customer with this Id ".$customerId));
            }

            
            break;
        case 'DELETE':
           $json_data = file_get_contents('php://input');
           $content = json_decode($json_data, true);
           $id = $content['id'];
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