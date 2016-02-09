<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<?php

include ("_conect.php");

$qry = "create database ".$database;
if ( mysqli_query($conn, $qry) === false )
{
    //echo "Error creating database: ".mysql_error($conn);
}
mysqli_query($conn, "use $database");

/// Dummy colectiv import

$qry = " create table $clasa (
    Id int(2) primary key ,
    Nume char(20) ,
    Prenume char(20) ,
    Sex char(1) ,
    Preferinta1 int(2) ,
    Preferinta2 int(2) ,
    Preferinta3 int(2) ,
    Antipatie1 int(2) ,
    Antipatie2 int(2) ,
    Antipatie3 int(2) )
";

echo "<p>";
if ( mysqli_query($conn, $qry) === false )
    echo "Error creating table: ".mysqli_error($conn);
else
    echo "A fost creat colectivul: ".$class_now."<br>";
echo "</p>";
mysqli_close($conn);

?>
