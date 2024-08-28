<?php

$host="localhost";
$user="root";
$pass="1d0ntw4nn4kn0w";
$db="login";
$conn=new mysqli($host,$user,$pass,$db);
if ($conn->connect_error) {
    echo "Failed to connect DB".$conn->connect_error;
}

?>