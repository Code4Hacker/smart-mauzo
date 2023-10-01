<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $admin = $_GET['admin_id'];
            $sql_query = "SELECT * FROM ADMINS WHERE adminEmail = '$admin' ORDER BY adminID DESC";
            $res_for = $connector -> query($sql_query);

            if($res_for -> num_rows == 1){
                $employees = "SELECT * FROM EMPLOYEES ";
                $customers = "SELECT * FROM CUSTOMERS ";
                $counte = 0;
                $countc = 0;
                if($connector -> query($employees)){
                    $counte = $connector -> query($employees) -> num_rows;
                }
                if($connector -> query($customers)){
                    $countc = $connector -> query($customers) -> num_rows;
                }
                echo json_encode(array("status" => "200","counts" => array("employees" => $counte,"customers" => $countc)));

            }else{
                json_encode(array("status" => "UnAuthorized User"));
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