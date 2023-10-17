<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
            $email = $_POST['Aemail'];
            $passcode = $_POST['Apasscode'];
            $passcode = str_replace("'","\'", $passcode);
            $passcode = str_replace("'","\'", $passcode);

            $sql_post = "SELECT * FROM EMPLOYEES WHERE employeeEmail = '$email' AND employeePasscode = '$passcode' AND deleted='false'";
            $addcustomer = $connector -> query($sql_post);

            if($addcustomer -> num_rows == 1){
                echo json_encode(array("status" => "200"));
            }else{
                echo json_encode(array("status" => "404"));
            }
               mysqli_close($connector);

            break; 
            case 'GET':
                $email = $_GET['employee_id'];
                $sql_query = "SELECT * FROM EMPLOYEES WHERE employeeEmail = '$email' AND deleted='false' ORDER BY employeeID DESC";
                $res_for = $connector -> query($sql_query);
    
                if($res_for){
                    $data_render = array();
                    while($row = $res_for -> fetch_assoc()){
                        $data_render[] = $row;
                    }
                    echo json_encode(array("status" => "200","employee" => $data_render));
                }
                $connector -> close();
                break;     
        default:
           echo json_encode(array("status" => "404", "method" => "No such Method"));
           break;
     }
   }else{
    echo json_encode(array("Connection Status" => "Not Connected"));
   }
?>