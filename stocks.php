<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $sql_query = "SELECT * FROM STOCKS ORDER BY stockID";
            $res_for = $connector -> query($sql_query);
            if($res_for){
                $data = array();

                while($row = $res_for -> fetch_assoc()){
                    $data[] = $row;
                }
                echo json_encode(array("status" => "200", "stocks" => $data));
            }
            $connector -> close();
            break;
            
        case 'POST':
            $stockTitle = $_POST['stockTitle'];
            $stockDes = $_POST['stockDes'];
            $stockCost = $_POST['stockCost'];
            $registered = $_POST['registered'];
            $quantity = $_POST['quantity'];
            $photo = $_FILES['photo'];

            $stockTitle = str_replace("'", "\'", $stockTitle);
            $stockDes = str_replace("'", "\'", $stockDes);
            $stockCost = str_replace("'", "\'", $stockCost);
            $registered = str_replace("'", "\'", $registered);
            $quantity = str_replace("'", "\'", $quantity);

            if(!empty($stockTitle) && !empty($stockDes) && !empty($stockCost) && !empty($registered) && !empty($quantity) && ($photo != undefined)){
                $filepath = "stocks/STK_".rand().".".pathinfo($photo['name'], PATHINFO_EXTENSION);
                if(move_uploaded_file($photo['tmp_name'], $filepath)){
                    $sql_post = "INSERT INTO STOCKS (stockTitle, stockDes, stockCost, registeredBy, stockImage, quantity) VALUES ('$stockTitle','$stockDes','$stockCost','$registered','/$filepath','$quantity')";

                    $responses = $connector -> query($sql_post);
                    if($responses){
                        echo json_encode(array("status" => "200", "message" => "POSTED"));
                    }else{
                        echo json_encode(array("status" => "500", "message" => "NOT POSTED"));
                    }
                }
            }else{
                echo json_encode(array("status" => "400", "message" => "Fill the fields"));
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