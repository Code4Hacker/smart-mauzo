<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            if (isset($data['resp'])) {
                $bodydata = $data['resp'];
                $main_desc = $data['main_data'];
                $title = $main_desc['title'];
                $description = $main_desc['description'];
                $requirements = $main_desc['requirements'];
                $pay_status = $main_desc['pay_status'];
                $deal_tracking = $main_desc['deal_tracking'];
                $registered_by = $main_desc['registered_by'];
                $customer = $main_desc['customer'];
                $the_worker = $main_desc['the_worker'];

                $query = "INSERT INTO DEALS (dealTitle, dealDescription, dealRequirements,registeredBy, customerId,dealStatus,tracking,mini_employee) VALUES ('$title','$description','$requirements','$registered_by','$customer','$pay_status','$deal_tracking','$the_worker')";

                $push = $connector -> query($query);
                if($push){
                    $getId = "SELECT dealID FROM DEALS ORDER BY dealID DESC";
                    $getCheck = $connector -> query($getId);
                    if($getCheck){
                        $content = "";
                        $res = 1;
                        $row = $getCheck -> fetch_assoc()['dealID'];
                        foreach ($bodydata as $item) {
                            $measurement = $item['measurement'];
                            $category = $item['category'];
                            $price = $item['price'];
                            $quantity = $item['quantity'];
                            $category = $item['category'];
    
                            $content = "INSERT INTO CONTENTS (cID,price,measurements,categories,quantity,deal) VALUES (NULL, '$price','$measurement', '$category','$quantity','$row')";
                            if($connector -> query($content)){
                                $res = "nice";
                            }else{
                                $res = "bad";
                            }
                            
                            // echo json_encode(array("status" => "200", "message" => $measurement));
                            
                        }
                        switch($res){
                            case "nice":
                                echo json_encode(array("status" => "200", "message" => "Data Success"));
                                break;
                            case "bad":
                                echo json_encode(array("status" => "500", "message" => "Bad Return"));
                                break;
                            default:
                                echo json_encode(array("status" => "400", "message" => "We can't Understand"));
                                break;
                        }
                    }else{
                        echo json_encode(array("status" => "500", "message" => "Something Went Wrong"));
                    }
                }else{
                    echo json_encode(array("status" => "500", "message" => "Something Went Wrong"));
                }

            } else {
                echo json_encode(array("status" => "400", "message" => "Missing 'resp' key in the JSON data"));
            }

            $connector->close();
            break;
        default:
            echo json_encode(array("status" => "404", "message" => "No such Method"));
            break;
    }
} else {
    echo json_encode(array("Connection Status" => "Not Connected"));
}
?>