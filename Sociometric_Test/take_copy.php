<head>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
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

/// Creating a dummy user and handling with data insertion

$database = "dummy";
mysqli_query($conn, "use $database");

$from = $_POST["from"];
$to = $_POST["to"];

$qry = " create table $to (
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

$ok = 1;

if (  mysqli_query($conn, $qry) == false )
{
    echo "Eroare creare copie";
    $ok = 0;
}

$qry = "insert into $to select * from $from";

if (  mysqli_query($conn, $qry) == false )
{
    echo "<p>Eroare copiere tabel</p>";
    $ok = 0;
}

if ( $ok )
{
    echo "<p>Colectiv copiat cu succes</p>";
}

mysqli_close($conn);

?>

<html>
</html>
