<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $admin = $_GET['admin_id'];
            $sql_query = "SELECT * FROM ADMINS WHERE adminEmail = '$admin' ORDER BY adminID DESC";
            $res_for = $connector -> query($sql_query);

            if($res_for){
                $data_render = array();
                while($row = $res_for -> fetch_assoc()){
                    $data_render[] = $row;
                }
                echo json_encode(array("status" => "200","admin" => $data_render));
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