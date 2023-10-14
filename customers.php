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
            // $passcode = $_POST['codes'];
            $mail = $_POST['mail'];
            $profile = $_FILES['photo'];
            $unique = $_POST['unique'];
            $registeredBy = $_POST['registered'];

            $fname = str_replace("'","\'", $fname);
            $lname = str_replace("'","\'", $lname);
            $address = str_replace("'","\'",$address);
            $contact = str_replace("'","\'", $contact);
            $profile = str_replace("'","\'", $profile);
            $unique = str_replace("'","\'", $unique);
            $registeredBy = str_replace("'","\'", $registeredBy);
            $mail = str_replace("'","\'", $mail);

            

            
            $sql_check = "SELECT * FROM CUSTOMERS WHERE customerUnique = '$unique' AND deleted='false'";

            if(!empty($fname) &&!empty($lname) &&!empty($address) &&!empty($contact) &&!empty($unique) &&!empty($registeredBy) &&!empty($mail)){
                $sql_post = "";
                if($connector -> query($sql_check) -> num_rows == 1){
                    $unique = $unique.rand();
                    if(!empty($profile)){
                        $filepath = "profiles/"."PRF".rand().".".pathinfo($profile['name'], PATHINFO_EXTENSION);
                        if(move_uploaded_file($profile['tmp_name'], $filepath)){
                            $sql_post = "INSERT INTO CUSTOMERS (customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerProfile, customerUnique, registeredBy ) VALUES ('$fname','$lname','$mail','$address', '$contact', '/$filepath','$unique', '$registeredBy')";
                        }
                    }else{
                        $sql_post = "INSERT INTO CUSTOMERS (customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerUnique, registeredBy ) VALUES ('$fname','$lname','$mail','$address', '$contact','$unique', '$registeredBy')";
                    }
                    if($connector -> query($sql_post)){
                        echo json_encode(array("status" => "200", "message" => "Customer Added"));
                    }else{
                        echo json_encode(array("status" => "500", "message" => "Something went Wrong"));
                    }
                }else{
                    if(!empty($profile)){
                        $filepath = "profiles/".rand().".".pathinfo($profile['name'], PATHINFO_EXTENSION);
                        if(move_uploaded_file($profile['tmp_name'], $filepath)){
                            $sql_post = "INSERT INTO CUSTOMERS (customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerProfile, customerUnique, registeredBy ) VALUES ('$fname','$lname','$mail','$address', '$contact', '/$filepath','$unique', '$registeredBy')";
                        }
                    }else{
                        $sql_post = "INSERT INTO CUSTOMERS (customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerUnique, registeredBy ) VALUES ('$fname','$lname','$mail','$address', '$contact','$unique', '$registeredBy')";
                    }
                    if($connector -> query($sql_post)){
                        echo json_encode(array("status" => "200", "message" => "Customer Added"));
                    }else{
                        echo json_encode(array("status" => "500", "message" => "Something went Wrong"));
                    }
                }
            }else{
                echo json_encode(array("status" => "400", "message" => "Field Required"));
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