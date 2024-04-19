<?php
$server_name = "localhost";
$username = "webapp_delete";
$password = "j(Q(4fR0we_l_7@7";
//$password = "Gl0UOeHyH)Z7hVBY";

//Establishing a new connection to the server
$conn3 = new mysqli($server_name, $username, $password);

if ($conn3->connect_error){
    die("Connection failed: " . $conn3->connect_error);
}