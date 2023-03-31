<?php
session_start();

 // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
 header("Access-Control-Allow-Origin: *");
 require 'database.php';
 //global $connection;
 header("Content-Type: application/json");
//echo "in php";
//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);


$user = $json_obj['user'];
//echo $user;


$_SESSION['userId'] = 11;
$_SESSION['username'] = "user1";


if(isset($_SESSION['userId'])&& isset($_SESSION['username'])){ //makes sure session is set
    
if ($connection->connect_error){
     die("Connection failed:" .$connection->connect_error);
 }

 $stmt = $connection->prepare("select foodName, unit, amount FROM meals join users on (users.userId = meals.userId) where users.username = ?;");
if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "Failed to prepare"
    ));
    exit;
}
 
 $stmt->bind_param('s', $user);
 if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "Failed to bind"
    ));
    exit;
}
 $worked = $stmt->execute();

$result = $stmt->get_result();

//echo json_encode($result);
if($worked){
    //echo "in worked";
 while($row = $result->fetch_assoc()){
   //echo "in while";
    $arrayToSend[] = $row;
}
//this part is getting a random index from all the foods user2 has
$min = 0;
$max = sizeof($arrayToSend) -1;
$index = rand($min, $max); 
$result = $arrayToSend[$index];
//echo $result;


echo json_encode($result);
exit;
}
else{
    json_encode(array(
                "success" => false,
                "message" => "Failed to insert"
            ));
            exit;
}
}