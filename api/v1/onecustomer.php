<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $id = $_GET['id'];
            $sql_query = "SELECT * FROM CUSTOMERS WHERE customerID = '$id' AND deleted='false' ORDER BY customerID DESC";
            $res_for = $connector -> query($sql_query);

            if($res_for){
                $data_render = array();
                while($row = $res_for -> fetch_assoc()){
                    $data_render[] = $row;
                }
                echo json_encode(array("status" => "200","customer" => $data_render));
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
        default:
           echo json_encode(array("status" => "404", "method" => "No such Method"));
           break;
     }
   }else{
    echo json_encode(array("Connection Status" => "Not Connected"));
   }
?>