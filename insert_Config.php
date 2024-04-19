<?php
$server_name = "localhost";
$username = "webapp_insertSR";
$password = "(Ew6qN9YZzI2iWBJ";
//$password = "Gl0UOeHyH)Z7hVBY";

//Establishing a new connection to the server
$conn1 = new mysqli($server_name, $username, $password);

if ($conn1->connect_error){
    die("Connection failed: " . $conn1->connect_error);
}