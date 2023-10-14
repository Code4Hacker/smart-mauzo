<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $employee = $_GET['employee_id'];
            $sql_query = "SELECT * FROM EMPLOYEES WHERE employeeEmail = '$employee' AND deleted='false' ORDER BY employeeID DESC";
            $res_for = $connector -> query($sql_query);

            if($res_for -> num_rows == 1){
                $row = $res_for -> fetch_assoc()['employeeID'];
                $your_customers = "SELECT * FROM CUSTOMERS WHERE registeredBy = '$row' AND deleted='false' ";
                $customers = "SELECT * FROM CUSTOMERS WHERE deleted='false' ";
                $counte = 0;
                $countc = 0;
                if($connector -> query($your_customers)){
                    $counte = $connector -> query($your_customers) -> num_rows;
                }
                if($connector -> query($customers)){
                    $countc = $connector -> query($customers) -> num_rows;
                }
                echo json_encode(array("status" => "200","counts" => array("your_customers" => $counte,"customers" => $countc)));

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