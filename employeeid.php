<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $id = $_GET['id'];
            $sql_query = "SELECT employeeFirst, employeeLast FROM EMPLOYEES WHERE employeeID = '$id'";
            $res_for = $connector -> query($sql_query);

            if($res_for){
                $data_render = array();
                while($row = $res_for -> fetch_assoc()){
                    $data_render[] = $row;
                }
                echo json_encode(array("status" => "200","fullname" => $data_render));
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