<?php
// this file returns all the food posts from only public users
session_start();
 // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
 header("Access-Control-Allow-Origin: *");
 require 'database.php';
 //global $connection;
 header("Content-Type: application/json");
//echo "in php";
//Because you are posting the data via fetch(), php has to retrieve it elsewhere.

$isPrivate = "false";

$stmt = $connection->prepare("select foodName, unit, thisTime, ampm, amount, thisDate, users.username FROM meals join users on (users.userId = meals.userId) where users.isPrivate = ?;"); 

$stmt->bind_param('s', $isPrivate);
$worked = $stmt->execute();

$result = $stmt->get_result();


if($worked){
    
 while($row = $result->fetch_assoc()){
   
    $arrayToSend[] = $row;

}
echo json_encode($arrayToSend);
exit;
}
else{
    json_encode(array(
                "success" => false,
                "message" => "Failed to insert"
            ));
            exit;
}


