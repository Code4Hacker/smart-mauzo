<?php
include_once("connector.php");

if ($connector) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $product = $_POST['p_name'];
            $s_price = $_POST['s_price'];
            $b_price = $_POST['b_price'];
            $qty = $_POST['qty'];
            if (!empty($product) && !empty($s_price) && !empty($b_price) && !empty($qty)) {
                // $sql_connect = "SELECT * FROM WORKERS WHERE workerName='$fullname'";
                // $result = mysqli_query($connector, $sql_connect);

                // if ($result->num_rows == 0) {
                $query_2 = "INSERT INTO PRODUCT (productName, sellingPrice, buyingPrice, quantity) VALUES ('$product', '$s_price', '$b_price', '$qty')";
                $res_2 = $connector->query($query_2);
                if ($res_2) {
                    echo json_encode(array("status" => "200", "message" => "Product Added"));
                } else {
                    echo json_encode(array("status" => "500", "message" => "Product Failed"));
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
            $select = "SELECT * FROM PRODUCT ORDER BY productId DESC";
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