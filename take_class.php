<?php

$severname = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($severname,$username,$password);

if ( $conn === false )
{
    die("Connection failed:".mysqli_connect_error());
}

$database = "dummy";

$qry = "create database ".$database;
if ( mysqli_query($conn, $qry) === false )
{
    //echo "Error creating database: ".mysql_error($conn);
}
mysqli_query($conn, "use $database");

/// Dummy colectiv import

$class_now = $_POST["nume_clasa"];

$file = fopen("class_session","w");
fwrite($file,$class_now);
fclose($file);

mysqli_close($conn);

include('new_table.php');

?>
