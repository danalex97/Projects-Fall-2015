<?php

$severname = "localhost";
$username = "root";
$password = "";

function load()
{
    $file = fopen("class_session","r");
    $token = fgets($file,1024);
    return $token;
}
$clasa = load();

$conn = mysqli_connect($severname,$username,$password);

if ( $conn === false ) { die("Connection failed:".mysqli_connect_error()); }

$database = "dummy";
mysqli_query($conn, "use $database");

?>
