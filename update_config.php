<?php
$server_name = "localhost";
$username = "webapp_update";
$password = "Hn!*hvULuNlHBqnw";


//Establishing a new connection to the server
$conn2 = new mysqli($server_name, $username, $password);

if ($conn2->connect_error){
    die("Connection failed: " . $conn2->connect_error);
}