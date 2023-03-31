<?php
//this page submits exercise post information to data table
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


$type = $json_obj['type'];
$duration = $json_obj['duration'];
$time = $json_obj["time"];
$ampm = $json_obj["ampm"];
$userId = $json_obj["userId"];
$date = $json_obj["date"];
$_SESSION['userId'] = $userId;




if(isset($_SESSION['userId'])){
if ($connection->connect_error){
     die("Connection failed:" .$connection->connect_error);
 }

 $stmt = $connection->prepare("INSERT into excersize (userId, activity, duration, thisTime, ampm, thisDate) values (?, ?, ?, ?, ?, ?);");
if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "Failed to prepare"
    ));
    exit;
}
 
 $stmt->bind_param('isiiss', $_SESSION['userId'], $type, $duration, $time, $ampm, $date);
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