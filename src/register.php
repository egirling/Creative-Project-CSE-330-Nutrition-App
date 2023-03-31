<?php
//this page adds new user to database
header("Access-Control-Allow-Origin: *");
require 'database.php';
global $connection;
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

$json_str = file_get_contents('php://input'); 
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$username = htmlentities($json_obj['username']);
$password = htmlentities($json_obj['pass']);
$isPrivate = htmlentities($json_obj['private']);

$passw= password_hash($password, PASSWORD_DEFAULT);


$stmt = $connection->prepare("INSERT INTO users(username, pass, isPrivate) VALUES (?, ?, ?)"); 

$stmt->bind_param('sss', $username, $passw, $isPrivate);


if ($stmt->execute()) { 
    
    echo json_encode(array(
        "success" => true
    ));
    //exit;
    } 
    else {
    echo json_encode(array(
        "success" => false,
        "message" => "Failed to insert"
    ));
    //exit;
    
    }



    

?>