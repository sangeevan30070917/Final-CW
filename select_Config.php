<?php
$server_name = "localhost";
$username = "webapp_selectSR";
$password = "w4F2Zv.Y5eh)UgRA";
//$password = "Gl0UOeHyH)Z7hVBY";

//Establishing a new connection to the server
$conn = new mysqli($server_name, $username, $password);

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}