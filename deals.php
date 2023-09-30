<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $sql_query = "SELECT * FROM DEALS ORDER BY dealID DESC";
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
            $description = $_POST['description'];
            $summary = $_POST['summary'];
            $picture = $_POST['phone'];
            $employee = $_POST['codes'];
            $customer = $_POST['customer'];
            $cash = $_POST['cash'];

            $title = str_replace("'","\'", $title);
            $description = str_replace("'","\'", $description);
            $summary = str_replace("'","\'",$summary);
            $picture = str_replace("'","\'", $picture);
            $employee = str_replace("'","\'", $employee);
            $customer = str_replace("'","\'", $customer);
            $cash = str_replace("'","\'", $cash);

            $sql_post = "INSERT INTO DEALS (dealTitle, dealDescription, dealSummary, dealPicture, registeredBy, customerId, price ) VALUES ('$title','$description','$summary','$picture','$employee','$customer','$cash')";

                $addemployee = $connector -> query($sql_post);

                if($addemployee){
                    echo json_encode(array("status" => "200", "message" => "Deal Successifull"));
                }else{
                    echo json_encode(array("status" => "500", "message" => "Something went Wrong"));
                }
            mysqli_close($connector);

            break;
        case 'DELETE':
           $json_data = file_get_contents('php://input');
           $content = json_decode($json_data, true);
           $id = $content['id'];
           $id = str_replace("'","\'", $id);
           if(!empty($id)){
            $sql_delete = "DELETE FROM DEALS WHERE dealID = '$id'";

            $response = mysqli_query($connector, $sql_delete);

            if($response){
                echo json_encode(array("status" => "200"));
            }else{
                echo json_encode(array("status" => "500"));
            }
           }
           break;    
        default:
           echo json_encode(array("status" => "404", "method" => "No such Method"));
           break;
     }
   }else{
    echo json_encode(array("Connection Status" => "Not Connected"));
   }
?>