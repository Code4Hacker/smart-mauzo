<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
      case 'GET':
          $dealnum = $_GET['dealnum'];
          $sql_query = "SELECT * FROM DEALS WHERE customerId = '$dealnum' AND deleted='false' ORDER BY dealID DESC";
          $sql_user = "SELECT * FROM CUSTOMERS WHERE customerUnique = '$dealnum'";
          $res_for = $connector -> query($sql_query);
          if($res_for){
              $row = $res_for -> fetch_assoc();
              $row_count = $connector -> query($sql_user) -> fetch_assoc();
              echo json_encode(array("status" => "200","deal" => $row,"user" => $row_count));
          }
          $connector -> close();
          break;
          case 'POST':
              $dealnum = $_GET['dealnum'];
              $sql_query = "SELECT * FROM DEALS WHERE dealID = '$dealnum' AND deleted='false' ORDER BY dealID DESC";
              
              $res_for = $connector -> query($sql_query);
              if($res_for){
                  $row = $res_for -> fetch_assoc();
                  $gemini = $row['customerId'];
                  $sql_user = "SELECT * FROM CUSTOMERS WHERE customerUnique = '$gemini'";
                  $row_count = $connector -> query($sql_user) -> fetch_assoc();
                  echo json_encode(array("status" => "200","deal" => $row,"user" => $row_count));
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