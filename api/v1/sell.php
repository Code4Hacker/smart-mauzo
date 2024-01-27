<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $cId = $_POST['cId'];
            $quantity = $_POST['qty'];
            $price = $_POST['price'];
            $product = $_POST['p_name'];
            if (!empty($product) && !empty($quantity) && !empty($price) && !empty($product)) {
                // $sql_connect = "SELECT * FROM WORKERS WHERE workerName='$fullname'";
                // $result = mysqli_query($connector, $sql_connect);

                // if ($result->num_rows == 0) {
                $update = "UPDATE PRODUCT SET quantity=quantity - $quantity WHERE productName = '$product'";
                $ss = $connector -> query($update);
                if($ss){
                    $query_2 = "INSERT INTO SOLD (customerId, quantity, price, productN) VALUES ('$cId', '$quantity', '$price', '$product')";
                $res_2 = $connector->query($query_2);
                if ($res_2) {
                    echo json_encode(array("status" => "200", "message" => "Product SOLD"));
                } else {
                    echo json_encode(array("status" => "500", "message" => "Product Failed"));
                }
                }else{

                    echo json_encode(array("status" => "500", "message" => "Update Failed".$connector -> error));
                }
                
                // } else {
                //     echo json_encode(array("status" => "400", "message" => "User Already Exist"));

                // }
            }else{
                echo json_encode(array("status" => "402", "message" => "Fill the Field"));
            }
            $connector->close();
            break;
        case 'GET':
            $select = "SELECT * FROM SOLD ORDER BY ctId DESC";
            $result  = $connector -> query($select);
            if($result){
                $data = array();

                while($row = $result -> fetch_assoc()){
                    $data[] = $row;
                }
               echo json_encode(array("status" => "200", "products" => $data));

            }
            break;
        default:
            echo json_encode(array("status" => "404", "method" => "No such Method"));
            break;
    }
} else {
    echo json_encode(array("Connection Status" => "Not Connected"));
}
?>