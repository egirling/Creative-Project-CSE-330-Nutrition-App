<?php
//basically just destroys session
session_start();
session_regenerate_id();
 // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
 header("Access-Control-Allow-Origin: *");
 require 'database.php';
 global $connection;
 header("Content-Type: application/json");
//echo "in php";
//Because you are posting the data via fetch(), php has to retrieve it elsewhere.

session_destroy();

echo json_encode(array(
    "success" => true,
    "message" => "logged out"
));
exit;
?>