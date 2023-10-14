<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $id = $_GET['id'];
            $sql_query = "SELECT employeeID FROM EMPLOYEES WHERE employeeEmail = '$id'";
            $res_for = $connector -> query($sql_query);

            if($res_for){
                $data_render = $res_for -> fetch_assoc()['employeeID'];
                if(!empty($data_render)){
                    $query_customers = "SELECT * FROM CUSTOMERS WHERE registeredBy = '$data_render' AND deleted = 'false'";
                    $res = $connector -> query($query_customers);
                    if($res){
                        $data = array();
                        while($row = $res -> fetch_assoc()){
                            $data[] = $row;
                        }
                        echo json_encode(array("status" => "200", "customers" => $data));

                    }
                }
            }
            $connector -> close();
            break;
            
        case 'POST':
            $id = $_POST['id'];
            $sql_query = "SELECT employeeID FROM EMPLOYEES WHERE employeeEmail = '$id'";
            $res_for = $connector -> query($sql_query);

            if($res_for){
                $data_render = $res_for -> fetch_assoc()['employeeID'];
                if(!empty($data_render)){
                    $query_customers = "SELECT * FROM DEALS WHERE registeredBy = '$data_render' AND deleted = 'false'";
                    $res = $connector -> query($query_customers);
                    if($res){
                        $data = array();
                        while($row = $res -> fetch_assoc()){
                            $data[] = $row;
                        }
                        echo json_encode(array("status" => "200", "customers" => $data));

                    }
                }
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