<?php 
   include_once("connector.php");

   if($connector){
     switch($_SERVER['REQUEST_METHOD']){
      case 'GET':
          $dealnum = $_GET['dealnum'];
          $tracks = $_GET['tracks'];

          $sql_query = "UPDATE DEALS SET tracking='$tracks' WHERE dealID = '$dealnum' AND deleted='false'";
          $res_for = $connector -> query($sql_query);
          if($res_for){
              echo json_encode(array("status" => "200","message" => "Updated"));
          }
          $connector -> close();
          break;
          case 'POST':
            $dealnum = $_POST['dealnum'];
            $status = $_POST['status'];
  
            $sql_query = "UPDATE DEALS SET dealStatus='$status' WHERE dealID = '$dealnum' AND deleted='false'";
            $res_for = $connector -> query($sql_query);
            if($res_for){
                echo json_encode(array("status" => "200","message" => "Updated"));
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