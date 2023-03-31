<?php

 // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
 header("Access-Control-Allow-Origin: *");
 require 'database.php';
 global $connection;
 header("Content-Type: application/json");
//echo "in php";
//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$username = $json_obj['username'];
$password = $json_obj['pass'];
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)


if ($connection->connect_error){
     die("Connection failed:" .$connection->connect_error);
 }

 $stmt = $connection->prepare("SELECT COUNT(*), username, pass, userId FROM users WHERE userName=?");
    $stmt -> bind_param('s', $username);
    $stmt->execute();


    $stmt->bind_result($count, $username, $pwd_hash, $userId);
    $stmt->fetch();
    $stmt->close();

    $password = trim($password);
//checks to see if password matches
if($count == 1 && password_verify($password, $pwd_hash)){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['userId'] = $userId;
	$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
	$token = $_SESSION['token'];

	echo json_encode(array(
		"success" => true, "token" => $token, "userId" => $userId, "sessionid" => session_id()
		
	));
	exit;
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}
exit;
//kqudu4jq8vq3m4et0ujsmsldml session id from login.php
//arec1levb6nvrmu314vqi14sqd session id from mystats.php
?>



