<?php
//this page submits food post information to data base
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


$food = $json_obj['food'];
//echo $food;
$amount = $json_obj['amount'];
//echo $amount." ";
$units = $json_obj['units'];
//echo $units." ";
$time = $json_obj["time"];
//echo $time." ";
$ampm = $json_obj["ampm"];
//echo $ampm;
$date = $json_obj["date"];
$userId = $json_obj["userId"];



$_SESSION['userId'] = $userId;





if(isset($_SESSION['userId'])){
if ($connection->connect_error){
     die("Connection failed:" .$connection->connect_error);
 }

 $stmt = $connection->prepare("INSERT into meals (userId, foodName, unit, thisTime, ampm, amount, thisDate) values (?, ?, ?, ?, ?, ?,?)");
if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "Failed to prepare"
    ));
    exit;
}
 
 $stmt->bind_param('issisis', $userId, $food, $units, $time, $ampm, $amount, $date);
 if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "Failed to bind"
    ));
    exit;
}
 $stmt->execute();
if ($stmt) { 
        $stmt->close();
        echo json_encode(array(
            "success" => true
        ));
        exit;
        } 
        else {
            $stmt->close();

        echo json_encode(array(

            "success" => false,
            "message" => "Failed to insert" 
        ));
        exit;
        
        }
    

    }
    else{
        echo json_encode(array(

            "success" => false,
            "message" => "session not set" 
        ));
    }

?>