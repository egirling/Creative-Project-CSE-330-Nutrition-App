<?php
// creates and provides database connection for the whole site
$connection = new mysqli('localhost', 'creative', 'creative', 'nutritionApp'); 

    if ($connection->connect_errno){
        printf("Connection Failed: %s\n", $connection->connect_error);
        exit;
 }
 
 ?>

