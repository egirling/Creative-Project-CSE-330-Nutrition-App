<?php
//this page uploads a users stats to the data base
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


$weight = $json_obj['weight'];
$height = $json_obj['height'];
$gender = $json_obj["gender"];
$age = $json_obj["age"];
$ethnicity = $json_obj["ethnicity"];
$userId = $json_obj["userId"];
$_SESSION['userId'] = $userId;




if(isset($_SESSION['userId'])){
if ($connection->connect_error){
     die("Connection failed:" .$connection->connect_error);
 }

 $stmt = $connection->prepare("INSERT into stats (userId, height, userWeight, gender, age, ethnicity) values (?, ?, ?, ?, ?, ?)");
if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "Failed to prepare"
    ));
    exit;
}
 
 $stmt->bind_param('iiisis', $userId, $height, $weight, $gender, $age, $ethnicity);
 echo $userId;
 echo $weight;
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
            "success" => true,
            "height"=> $height,
            "weight"=> $weight,
            "age"=>$age,
            "ethnicity"=>$ethnicity

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